<?php
namespace Application\Model;

trait RelationalModel
{	
    /**
     * key value pairing of map => oject values
     * 
     * @var array
     */
    protected $relationalVars = array();
	
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
