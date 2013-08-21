<?php

namespace Application\Model\Entity;

use stdClass;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\ArraySerializableInterface;

abstract class AbstractEntity implements ArraySerializableInterface, InputFilterAwareInterface
{
	protected $inputFilter;
	protected $row;
	protected $columns = array();
	protected $filters = array();
	
	public function __construct()
	{
	    $this->init();
	}
	
	public function __get($columnName)
	{
		$lazyLoader = 'get' . ucfirst($columnName);
		if (method_exists($this, $lazyLoader)) {
			return $this->$lazyLoader();
		}
		
		return $this->row->$columnName;
	}
	
	public function __set($columnName, $val)
	{
	    $lazyLoader = 'set' . ucfirst($columnName);
	    if (method_exists($this, $lazyLoader)) {
	        return $this->$lazyLoader($val);
	    }
	    
		return $this->row->$columnName = $val;
	}
	
	public function __isset($columnName)
	{
		return $this->row->$columnName;
	}
	
	public function init()
	{
	    
	}
	
	public function setColumns(array $array)
	{
		$this->columns = $array;
	}
	
	public function exchangeArray(array $data)
	{
	    if (!is_object($this->row)) {
	        $this->row = new stdClass();
	    }
	    
		foreach($data as $column => $val) {
			$this->row->$column = (isset($val)) ? $val : null;
		}
	}
	
	public function getArrayCopy()
	{
		$returnArray = array();
		
		foreach($this->row as $columnName => $val) {
			if (in_array($columnName, $this->columns)) {
				$returnArray[$columnName] = $val;
			}
		}
		
		return $returnArray;
	}
	
	public function toArray()
	{
		return get_object_vars($this->row);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		$this->inputFilter = $inputFilter;
		return $this;
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$this->setInputFilter(new InputFilter())->addFilters();
		}
	
		return $this->inputFilter;
	}
	
	public function addFilters()
	{
		foreach ($this->filters as $filter) {
			$this->inputFilter->add($filter);
		}
		return $this;
	}
}
