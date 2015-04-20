<?php
namespace Shop\Form\Order;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Shop\Model\Order\Line as LineModel;
use Shop\Hydrator\Order\Line as LineHydrator;

class LineFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name=null, $options=[])
    {
        parent::__construct($name, $options);
        
        $this->setHydrator(new LineHydrator())
            ->setObject(new LineModel());
        
        
    }
    public function init()
    {
        
    }
    
    public function getInputFilterSpecification()
    {
        return [];
    }
}
