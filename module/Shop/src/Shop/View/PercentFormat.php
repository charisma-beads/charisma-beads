<?php

namespace Shop\View;

use NumberFormatter;
use UthandoCommon\View\AbstractViewHelper;
use Zend\I18n\View\Helper\NumberFormat;

class PercentFormat extends AbstractViewHelper
{
	/**
	 * @var NumberFormat
	 */
	protected $numberFormatHelper;
	
	public function __invoke($percentage)
	{
		$numberFormatHelper = $this->getNumberFormat()
			->setFormatStyle(NumberFormatter::PERCENT)
			->setFormatType(NumberFormatter::TYPE_DEFAULT)
			->setDecimals(1)
			->setLocale('en_GB');
		
		return $numberFormatHelper($percentage);
	}
	
	/**
	 * @return \Zend\I18n\View\Helper\NumberFormat
	 */
	public function getNumberFormat()
	{
		if (!$this->numberFormatHelper instanceof NumberFormat) {
			$this->numberFormatHelper = $this->view->plugin('numberFormat');
		}
		
		return $this->numberFormatHelper;
	}
}
