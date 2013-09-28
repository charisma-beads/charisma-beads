<?php
namespace Shop\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Exception;

class AbstractModel implements InputFilterAwareInterface
{
	protected $inputFilter;
	protected $inputFilterClass;
	
	public function has($prop)
	{
		$getter = 'get' . ucfirst($prop);
		
		return method_exists($this, $getter);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new Exception("Not used");
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$filterClass = $this->inputFilterClass;
			
			if (!$filterClass) {
				throw new Exception('Input filter class not defined.');
			}
			
			if (!class_exists($filterClass)) {
				throw new Exception('Input filter class "' . $filterClass . '" cannot be found.');
			}
			
			$inputFilter = new $filterClass();
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
}
