<?php
namespace Application\Service;

use Application\Model\AbstractModel;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Exception;

class AbstractService implements ServiceLocatorAwareInterface
{
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	/**
	 * @var \Application\Mapper\AbstractMapper
	 */
	protected $mapper;
	
	/**
	 * @var string
	 */
	protected $form;
	
	/**
	 * @var string
	 */
	protected $inputFilter;
	
	/**
	 * @var string
	 */
	protected $mapperClass;
	
	/**
	 * @var string
	 */
	protected $saveOverRide;
	
	/**
	 * return just one record from database
	 * 
	 * @param int $id
	 * @return AbstractModel|null
	 */
	public function getById($id)
	{
		$id = (int) $id;
		return $this->getMapper()->getById($id);
	}
	
	/**
	 * fetch all records form database
	 * 
	 * @return \Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator|\Zend\Db\ResultSet\HydratingResultSet
	 */
	public function fetchAll()
	{
		return $this->getMapper()->fetchAll();
	}
	
	/**
	 * basic search on database
	 * 
	 * @param array $post
	 * @return \Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator|\Zend\Db\ResultSet\HydratingResultSet
	 */
	public function search(array $post)
	{
		$sort = (isset($post['sort'])) ? (string) $post['sort']: '';
		unset($post['sort'], $post['count'], $post['offset'], $post['page']);
		
		$searches = array();
		
		foreach($post as $key => $value) {
			$searches[] = array(
				'searchString'	=> (string) $value,
				'columns'		=> explode('-', $key),
			);
		}
		 
		$models = $this->getMapper()->search($searches, $sort);
		 
		return $models;
	}
	
	/**
	 * override this to populate relational records.
	 * 
	 * @param AbstractModel $model
	 * @param string $children
	 * @return AbstractModel $model
	 */
	public function populate($model, $children = false)
	{
		return $model;
	}
	
	/**
	 * prepare data to be inserted into database
	 * 
	 * @param array $post
	 * @return int results from self::save()
	 */
	public function add(array $post)
	{
		$model = $this->getMapper()->getModel();
		$form  = $this->getForm($model, $post, true, true);
	
		if (!$form->isValid()) {
			return $form;
		}
	
		return $this->save($form->getData());
	}
	
	/**
	 * prepare data to be updated and saved into database.
	 * 
	 * @param AbstractModel $model
	 * @param array $post
	 * @param Form $form
	 * @return int results from self::save()
	 */
	public function edit(AbstractModel $model, array $post, Form $form = null)
	{
		$form  = ($form) ? $form : $this->getForm($model, $post, true, true);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		$save = ($this->saveOverRide) ? : 'save';
		
		return $this->$save($form->getData());
	}
	
	/**
	 * updates a row if id is supplied else insert a new row
	 * 
	 * @param array|AbstractModel $data
	 * @throws Exception
	 * @return int $reults number of rows affected or insertId
	 */
	public function save($data)
	{
		if ($data instanceof AbstractModel) {
			$data = $this->getMapper()->extract($data);
		}
		
		$pk = $this->getMapper()->getPrimaryKey();
		$id = $data[$pk];
		
		if (0 === $id || null === $id) {
			$result = $this->getMapper()->insert($data);
		} else {
			if ($this->getById($id)) {
				$result = $this->getMapper()->update($data, array($pk => $id));
			} else {
				throw new Exception('Id ' . $id . ' does not exist');
			}
		}
		
		return $result;
	}
	
	/**
	 * delete row from database
	 * 
	 * @param int $id
	 * @return int $result number of rows affected
	 */
	public function delete($id)
	{
		$id = (int) $id;
		$result = $this->getMapper()->delete(array(
			$this->getMapper()->getPrimaryKey() => $id
		));
		
		return $result;
	}
	
	/**
	 * @return \Application\Mapper\AbstractMapper
	 */
	public function getMapper()
	{
		if (!$this->mapper) {
			$sl = $this->getServiceLocator();
			$this->mapper = $sl->get($this->mapperClass);
		}
		
		return $this->mapper;
	}
	
	/**
	 * Gets the default form for the service.
	 * 
	 * @param AbstractModel $model
	 * @param array $data
	 * @param bool $useInputFilter
	 * @param bool $useHydrator
	 * @return Form $form
	 */
	public function getForm(AbstractModel $model=null, array $data=null, $useInputFilter=false, $useHydrator=false)
	{
		$sl = $this->getServiceLocator();
		$form = $sl->get($this->form);
		$form->init();
		
		if ($useInputFilter) {
			$form->setInputFilter($sl->get($this->inputFilter));
		}
		
		if ($useHydrator) {
			$form->setHydrator($this->getMapper()->getHydrator());
		}
		 
		if ($model) {
			$form->bind($model);
		}
		 
		if ($data) {
			$form->setData($data);
		}
	
		return $form;
	}
	
	/**
	 * get application config option by its key.
	 *
	 * @param string $key
	 * @return array $config
	 */
	protected function getConfig($key)
	{
		$config = $this->getServiceLocator()->get('config');
		return $config[$key];
	}
	
	public function usePaginator($options=array())
	{
		$this->getMapper()->usePaginator($options);
		return $this;
	}
	
	/**
	 * Set the service locator.
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return AbstractModel
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this;
	}
	
	/**
	 * Get the service locator.
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
}
