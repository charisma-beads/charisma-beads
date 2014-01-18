<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Cost extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\PostCost';
	protected $form = 'Shop\Form\PostCost';
	protected $inputFilter = 'Shop\InputFilter\PostCost';
	
	/**
	 * @var \Shop\Service\Post\Level
	 */
	protected $postLevelService;
	
	/**
	 * @var \Shop\Service\Post\Zone
	 */
	protected $postZoneService;
	
	public function search(array $post)
	{
		$costs = parent::search($post);
		
		foreach ($costs as $cost) {
			$this->populate($cost, true);
		}
	
		return $costs;
	}
	
	/*
	 * @param Shop\Model\Post\Cost $model
	 */
	public function populate($model, $children = false)
	{
		$allChildren = ($children === true) ? true : false;
		$children = (is_array($children)) ? $children : array();
		
		if ($allChildren || in_array('postLevel', $children)) {
			$id = $model->getPostLevelId();
			$model->setRelationalModel($this->getPostLevelService()->getById($id));
		}
		
		if ($allChildren || in_array('postZone', $children)) {
			$id = $model->getPostZoneId();
			$model->setRelationalModel($this->getPostZoneService()->getById($id));
		}
	}
	
	/**
	 * @return \Shop\Service\Post\Level
	 */
	public function getPostLevelService()
	{
		if (!$this->postLevelService) {
			$sl = $this->getServiceLocator();
			$this->postLevelService = $sl->get('Shop\Service\PostLevel');
		}
	
		return $this->postLevelService;
	}
	
	/**
	 * @return \Shop\Service\Post\Zone
	 */
	public function getPostZoneService()
	{
		if (!$this->postZoneService) {
			$sl = $this->getServiceLocator();
			$this->postZoneService = $sl->get('Shop\Service\PostZone');
		}
		
		return $this->postZoneService;
	}
	
}
