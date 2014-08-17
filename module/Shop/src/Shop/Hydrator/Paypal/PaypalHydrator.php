<?php
namespace Shop\Hydrator\Paypal;

use Zend\Stdlib\Hydrator\AbstractHydrator;

class PaypalHydrator extends AbstractHydrator
{
    const  PAYPAL_NAMESPACE = 'PayPal\\Api\\';
    
    protected $modelName;
    
    public function __construct($modelName)
    {
    	parent::__construct();
    	
    	$this->modelName = (string) $modelName;
    }
    
    /**
     * @param array $data
     * @param \PayPal\Common\PPModel $object
     * @return \PayPal\Common\PPModel $object
     */
    public function hydrate(array $data, $object)
    {
        $model = $this->getModelName();
        \FB::info($model, __METHOD__);
    	if (!$object instanceof $model) {
    		return $object;
    	}
    	
        $object->fromArray($data[$this->modelName]);
    
    	return $object;
    }
    
    /**
     * @param \PayPal\Common\PPModel $object
     * @return array
     */
    public function extract($object)
    {
        $model = $this->getModelName();
        
    	if (!$object instanceof $model) {
    		return $object;
    	}
    
    	return $object->toArray();
    }
    
    public function getModelName()
    {
        return self::PAYPAL_NAMESPACE . ucfirst($this->modelName);
    }
}
