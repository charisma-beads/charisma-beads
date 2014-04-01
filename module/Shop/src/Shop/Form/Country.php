<?php

namespace Shop\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Country extends Form implements ServiceLocatorAwareInterface
{	
    use ServiceLocatorAwareTrait;
    
	public function init()
	{
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
		
		$this->add(array(
		    'name'		=> 'code',
		    'type'		=> 'text',
		    'options'	=> array(
		        'placeholder'	=> 'Country Code:',
        		'autofocus'		=> true,
		    ),
		    'options'		=> array(
		        'label'		=> 'Country Code:',
		        'required'	=> true,
		    ),
		));
		
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
		$zones = $this->getPostZoneService()->fetchAll();
		$zoneOptions = array();
		 
		/* @var $zone \Shop\Model\Post\Zone */
		foreach($zones as $zone) {
			$zoneOptions[$zone->getPostZoneId()] = $zone->getZone();
		}
		 
		return $zoneOptions;
	}
	
	/**
	 * @return \Shop\Service\Post\Zone
	 */
	public function getPostZoneService()
	{
		return $this->getServiceLocator()->get('Shop\Service\PostZone');
	}
}
