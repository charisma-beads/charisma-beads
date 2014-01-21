<?php

namespace Shop\Form\Post;

use Application\Form\AbstractForm;

class Zone extends AbstractForm
{	
	public function init()
	{
		$this->add(array(
			'name'	=> 'postZoneId',
			'type'	=> 'hidden',
		));
		
		$this->add(array(
			'name'			=> 'zone',
			'type'			=> 'text',
			'attributes'	=> array(
				'placeholder'	=> 'Post Zone:',
				'autofocus'		=> true,
			),
			'options'		=> array(
				'label'		=> 'Post Zone:',
				'required'	=> true,
			),
		));
	
		$this->add(array(
			'name'		=> 'taxCodeId',
			'type'		=> 'select',
			'options'	=> array(
				'label'			=> 'Tax Code:',
				'required'		=> true,
				'empty_option'	=> '---Please select a tax code---',
				'value_options'	=> $this->getTaxCodeList(),
			),
		));
	}
	
	public function getTaxCodeList()
	{
		$taxCodes = $this->getTaxCodeService()->fetchAll();
		$taxCodeOptions = array();
		
		/* @var $taxCode \Shop\Model\Tax\Code */
		foreach($taxCodes as $taxCode) {
			$taxCodeOptions[$taxCode->getTaxCodeId()] = $taxCode->getTaxCode() . ' - ' . $taxCode->getDescription();
		}
		
		return $taxCodeOptions;
	}
	
	/**
	 * @return \Shop\Service\Tax\Code
	 */
	public function getTaxCodeService()
	{
		return $this->getServiceLocator()->get('Shop\Service\TaxCode');
	}
	
}
