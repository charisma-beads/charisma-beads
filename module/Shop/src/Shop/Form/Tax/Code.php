<?php

namespace Shop\Form\Tax;

use Shop\Service\Tax\Rate as TaxRateService;
use Zend\Form\Form;

class Code extends Form
{
	/**
	 * @var TaxRateService
	 */
	protected $taxRateService;
	
	public function __construct()
	{
		parent::__construct('Tax Rate Form');
		
		$this->add(array(
			'name'	=> 'taxCodeId',
			'type'	=> 'hidden',
		));
		
		$this->add(array(
			'name'			=> 'taxCode',
			'type'			=> 'text',
			'attributes'	=> array(
				'placeholder'		=> 'Tax Code:',
				'autofocus'			=> true,
				'autocapitalize'	=> 'on',
			),
			'options'		=> array(
				'label' => 'Tax Code:',
			),
		));
		
		$this->add(array(
			'name'			=> 'description',
			'type'			=> 'text',
			'attributes'	=> array(
				'placeholder'		=> 'Description:',
				'autofocus'			=> true,
				'autocapitalise'	=> 'on',
			),
			'options'		=> array(
				'label'	=> 'Description:',
			),
		));
	}
	
	public function init()
	{
		$this->add(array(
			'name'		=> 'taxRateId',
			'type'		=> 'select',
			'options'	=> array(
				'label'			=> 'Tax Rate:',
				'required'		=> true,
				'empty_option'	=> '---Please select a tax rate---',
				'value_options'	=> $this->getTaxRateList(),
			),
		));
	}
	
	public function getTaxRateList()
	{
		$taxRates = $this->taxRateService->fetchAll();
		$taxRateOptions = array();
		
		/* @var $taxRate \Shop\Model\Tax\Rate */
		foreach ($taxRates as $taxRate) {
			$taxRateOptions[$taxRate->getTaxRateId()] = $taxRate->getTaxRate();
		}
		
		return $taxRateOptions;
	}
	
	/**
	 * @param TaxRateService $taxRateService
	 * @return \Shop\Form\Tax\Code
	 */
	public function setTaxRateService(TaxRateService $taxRateService)
	{
		$this->taxRateService = $taxRateService;
		return $this;
	}
}
