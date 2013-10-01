<?php

namespace Application\View;

use Zend\View\Helper\AbstractHelper;
use DateTime;

/**
 * View Helper
 */
class FormatDate extends AbstractHelper
{
	protected $format = 'd/m/Y H:i:s';
	
	public function __invoke($date)
	{
		if (!$date instanceof DateTime) {
			$date = new DateTime($date);
		}
        
        return $date->format($this->format);
	}
}
