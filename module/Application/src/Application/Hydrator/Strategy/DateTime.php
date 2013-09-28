<?php
namespace Application\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use DateTime;

class DateTime implements StrategyInterface
{
	protected $dateFormat = 'Y-m-d H:i:s';
	
	public function extract($value)
	{
		if (!$value instanceof DateTime) {
			$value = new DateTime();
		}
		
		return $value->format($this->dateFormat);
	}

	public function hydrate($value)
	{
		if (is_string($value) && '' === $value) {
			$value = null;
		} else {
			$value = new DateTime($value);
		}
		
		return $value;
	}
}
