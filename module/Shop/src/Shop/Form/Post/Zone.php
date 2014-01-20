<?php

namespace Shop\Form\Post;

use Shop\Service\Tax\Code;
use Zend\Form\Form;

class Zone extends Form
{
	/**
	 * @var Code
	 */
	protected $taxCodeService;
	
	public function __construct()
	{
		parent::__construct('Post Zone Form');
		
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
	}
	
	public function init()
	{
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
		$taxCodes = $this->taxCodeService->fetchAll();
		$taxCodeOptions = array();
		
		/* @var $taxCode \Shop\Model\Tax\Code */
		foreach($taxCodes as $taxCode) {
			$taxCodeOptions[$taxCode->getTaxCodeId()] = $taxCode->getTaxCode() . ' - ' . $taxCode->getDescription();
		}
		
		return $taxCodeOptions;
	}
	
	/**
	 * @param Code $taxCodeService
	 * @return \Shop\Form\Post\Zone
	 */
	public function setTaxCodeService(Code $taxCodeService)
	{
		$this->taxCodeService = $taxCodeService;
		return $this;
	}
	
}
