<?php

namespace Shop\Form\Tax;

use Application\Form\AbstractForm;

class Code extends AbstractForm
{
	public function init()
	{
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
		$taxRates = $this->getTaxRateService()->fetchAll();
		$taxRateOptions = array();
		
		/* @var $taxRate \Shop\Model\Tax\Rate */
		foreach ($taxRates as $taxRate) {
			$taxRateOptions[$taxRate->getTaxRateId()] = $taxRate->getTaxRate();
		}
		
		return $taxRateOptions;
	}
	
	/**
	 * @return \Shop\Service\Tax\Rate
	 */
	public function getTaxRateService()
	{
		return $this->getServiceLocator()->get('Shop\Service\TaxRate');
	}
}
