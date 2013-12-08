<?php
namespace Application\Hydrator;

use Zend\Stdlib\Hydrator\AbstractHydrator as ZendAbstractHydrator;
use Exception;

class AbstractHydrator extends ZendAbstractHydrator
{
    protected $isChild = false;
    
    protected $useRetionships = true;
    
    protected $relationshipHydrators = array();
    
    protected $parentMap = array();
    
	public function hydrate(array $data, $object)
	{
		foreach ($data as $key => $value) {
			if ($object->has($key)) {
				$method = 'set' . ucfirst($key);
				$value = $this->hydrateValue($key, $value, $data);
				$object->$method($value);
				
			}
			
			if (!$this->isChild && in_array($key, $this->parentMap)) {
			    unset($data[$key]);
			}
		}
	
		if (true === $this->useRetionships) {
    		$object = $this->hydrateChild($data, $object);
    	}
    	 
    	return $object;
	}
	
	public function hydrateChild(array $data, $object)
	{
	    foreach($this->relationshipHydrators as $hydrator => $model) {
	        $hydrator = new $hydrator();
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
