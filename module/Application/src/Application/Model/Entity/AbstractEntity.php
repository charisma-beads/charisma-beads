<?php

namespace Application\Model\Entity;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\ArraySerializableInterface;
use Exception;

abstract class AbstractEntity implements ArraySerializableInterface, InputFilterAwareInterface
{
	protected $inputFilter;
	protected $inputFilterClass;
	
	public function __get($columnName)
	{
		$lazyLoader = 'get' . ucfirst($columnName);
		
		if (!method_exists($this, $lazyLoader)) {
			throw new Exception('Method "' . $columnName . '" does not exist.');
		}
		
		return $this->$lazyLoader();
	}
	
	public function __set($columnName, $val)
	{
	    $lazyLoader = 'set' . ucfirst($columnName);
	    
	    if (!method_exists($this, $lazyLoader)) {
	        throw new Exception('Method "' . $columnName . '" does not exist.');
	    }
	    
		return $this->$lazyLoader($val);
	}
	
	abstract public function exchangeArray(array $data);
	
	abstract public function getArrayCopy();
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new Exception("Not used");
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			if (!$this->inputFilterClass) {
				throw new Exception('Input filter class not defined.');
			}
			
			$filterClass = $this->inputFilterClass;
			$inputFilter = new $filterClass();
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
}
