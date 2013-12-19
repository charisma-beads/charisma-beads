<?php
namespace Application\Hydrator;

use Zend\Stdlib\Hydrator\AbstractHydrator as ZendAbstractHydrator;
use Exception;

class AbstractHydrator extends ZendAbstractHydrator
{
    protected $isChild = false;
    
    protected $useRelationships = false;
    
    protected $hydratorMap = array();
    
    protected $prefix;
    
	public function hydrate(array $data, $object)
	{
	    $modelData = array();
	    // if Child model filter out the keys based on an prefix alias
	    if ($this->getIsChild()) {
	        foreach ($data as $key => $value) {
    	    	if (0 === strpos($key, $this->prefix)) {
    	    		$key = str_replace($this->prefix, '', $key);
    	    		$modelData[$key] = $value;
    	    	}
	        }
	    } else {
	        $modelData = $data;
	    }
	    
		foreach ($modelData as $key => $value) {
			if ($object->has($key)) {
				$method = 'set' . ucfirst($key);
				$value = $this->hydrateValue($key, $value, $modelData);
				$object->$method($value);
			}
		}
	
		if (true === $this->useRelationships) {
    		$object = $this->hydrateChild($data, $object);
    	}
    	 
    	return $object;
	}
	
	public function hydrateChild(array $data, $object)
	{
	    foreach ($this->hydratorMap as $hydrator => $model) {
	        $hydrator = new $hydrator($this->useRelationships);
	        $hydrator->setIsChild(true);
	        $model = $hydrator->hydrate($data, new $model());
	        $object->setRelationalModel($model);
	    }
	    
	    return $object;
	}
	
	public function extract($object) 
	{
		throw new Exception('Method not used. Please overload this method.');
	}
	
	/**
	 * @return boolean $isChild
	 */
	public function getIsChild()
	{
		return $this->isChild;
	}

	/**
	 * @param boolean $isChild
	 */
	public function setIsChild($isChild)
	{
		$this->isChild = $isChild;
		return $this;
	}
}
