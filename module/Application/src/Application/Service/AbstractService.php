<?php
namespace Application\Service;

use Application\Model\AbstractModel;
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
	
	protected $form;
	protected $inputFilter;
	protected $mapperClass;
	protected $saveOverRide;
	
	public function getById($id)
	{
		$id = (int) $id;
		return $this->getMapper()->getById($id);
	}
	
	public function fetchAll()
	{
		return $this->getMapper()->fetchAll();
	}
	
	public function add($post)
	{
		$model = $this->getMapper()->getModel();
		$form  = $this->getForm($model, $post);
	
		if (!$form->isValid()) {
			return $form;
		}
	
		return $this->save($form->getData());
	}
	
	public function edit($model, $post, $form = null)
	{
		$form  = ($form) ? $form : $this->getForm($model, $post);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		$save = ($this->saveOverRide) ? : 'save';
		
		return $this->$save($form->getData());
	}
	
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
	
	public function delete($id)
	{
		$id = (int) $id;
		return $this->getMapper()->delete(array(
			$this->getMapper()->getPrimaryKey() => $id
		));
	}
	
	/**
	 * 
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
	 * TODO: make this a seperate service and set input filter too from service.
	 * @return $form
	 */
	public function getForm($model=null, $data=null)
	{
		$sl = $this->getServiceLocator();
		$form = $sl->get($this->form);
		$form->setInputFilter($sl->get($this->inputFilter));
		$form->setHydrator($this->getMapper()->getHydrator());
		 
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
	 * @return \Application\Model\AbstractModel
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this;
	}
	
	/**
	 * Get the service locator.
	 *
	 * @return \Zend\ServiceManager\ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
}
