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
