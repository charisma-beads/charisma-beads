<?php
namespace Application\Model;

class AbstractModel
{	
    /**
     * key value pairing of map => oject values
     * 
     * @var array
     */
    protected $relationalVars = array();
    
    /**
     * Check to see if this class has a getter method defined
     * 
     * @param string $prop
     * @return boolean
     */
	public function has($prop)
	{
		$getter = 'get' . ucfirst($prop);
		return method_exists($this, $getter);
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	/**
	 * Set relationship model
	 * 
	 * @param object $model
	 * @return \Application\Model\AbstractModel
	 */
	public function setRelationalModel($model)
	{
	    if ($model) {
	       $className = get_class($model);
	       $this->relationalVars[$className] = $model;
	    }
	    
	    return $this;
	}
	
	/**
	 * Check all relationship models for method
	 * 
	 * @param string $method
	 * @param array $arguments
	 * @return mixed|boolean
	 */
	public function __call($method, array $arguments)
	{
	    // check the relational vars, if not found return false.
	    foreach ($this->relationalVars as $object) {
	        $callback = call_user_func_array(array($object, $method), $arguments);
	        
	        if ($callback) {
	            return $callback;
	        }
	    }
	    
	    return false;
	}
}
