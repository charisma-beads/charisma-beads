<?php
namespace Application\Model;

trait Model
{	
    /**
     * optional options can be supplied
     * 
     * @param array $options
     */
    public function __construct($options = [])
    {
        if ($options) {
            $this->setFromArray($options);
        }
    }
    
    /**
     * Sets each option checking if this model uses it first.
     * 
     * @param array $options
     */
    public function setFromArray(array $options)
    {
        foreach ($options as $key => $value) {
            if ($this->has($key)) {
                $setter = 'set' . ucfirst($key);
                $this->$setter($value);
            }
        }
    }
    
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
	
	/**
	 * Returns object properties as an array
	 * 
	 * @return array:
	 */
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}
