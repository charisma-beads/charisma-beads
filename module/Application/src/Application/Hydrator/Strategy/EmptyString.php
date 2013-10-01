<?php
namespace Application\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class EmptyString implements StrategyInterface
{

	public function extract($value)
	{
		return '';
	}
	
	public function hydrate($value)
	{
		return $value;
	}

}
