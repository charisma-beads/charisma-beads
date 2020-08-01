<?php

namespace Shop\View;

use NumberFormatter;
use Common\View\AbstractViewHelper;
use Laminas\I18n\View\Helper\NumberFormat;

/**
 * Class PercentFormat
 *
 * @package Shop\View
 */
class PercentFormat extends AbstractViewHelper
{
	/**
	 * @var NumberFormat
	 */
	protected $numberFormatHelper;
	
	public function __invoke($percentage)
	{
	    if ($percentage > 0) {
	        $percentage--;
        }
		$numberFormatHelper = $this->getNumberFormat()
			->setFormatStyle(NumberFormatter::PERCENT)
			->setFormatType(NumberFormatter::TYPE_DEFAULT)
			->setDecimals(1)
			->setLocale('en_GB');
		
		return $numberFormatHelper($percentage);
	}
	
	/**
	 * @return \Laminas\I18n\View\Helper\NumberFormat
	 */
	public function getNumberFormat()
	{
		if (!$this->numberFormatHelper instanceof NumberFormat) {
			$this->numberFormatHelper = $this->view->plugin('numberFormat');
		}
		
		return $this->numberFormatHelper;
	}
}
