<?php

namespace Shop\Form;

use Shop\Service\Post\Zone;
use Zend\Form\Form;

class Country extends Form
{
	/**
	 * @var \Shop\Service\Post\Zone
	 */
	public $postZoneService;
	
	public function __construct()
	{
		parent::__construct('Country Form');
		
		$this->add(array(
			'name'	=> 'countryId',
			'type'	=> 'hidden',
		));
		
		$this->add(array(
        	'name'			=> 'country',
        	'type'			=> 'text',
        	'attributes'	=> array(
        		'placeholder'	=> 'Country:',
        		'autofocus'		=> true,
        	),
        	'options'		=> array(
        		'label'		=> 'Country:',
        		'required'	=> true,
        	),
        ));
	}
	
	public function init()
	{
		$this->add(array(
			'name'		=> 'postZoneId',
			'type'		=> 'select',
			'options'	=> array(
				'label'			=> 'Post Zone:',
				'required'		=> true,
				'empty_option'	=> '---Please select a post zone---',
				'value_options'	=> $this->getPostZoneList(),
			),
		));
	}
	
	protected function getPostZoneList()
	{
		$zones = $this->postZoneService->fetchAll();
		$zoneOptions = array();
		 
		/* @var $zone \Shop\Model\Post\Zone */
		foreach($zones as $zone) {
			$zoneOptions[$zone->getPostZoneId()] = $zone->getZone();
		}
		 
		return $zoneOptions;
	}
	
	/**
	 * @param Zone $postZoneService
	 * @return \Shop\Form\Country
	 */
	public function setPostZoneService(Zone $postZoneService)
	{
		$this->postZoneService = $postZoneService;
		return $this;
	}
	
}
