<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use NumberFormatter;
use Common\View\AbstractViewHelper;
use Zend\I18n\View\Helper\NumberFormat;

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
