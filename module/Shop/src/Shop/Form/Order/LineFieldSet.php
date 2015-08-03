<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Order;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Shop\Model\Order\Line as LineModel;
use Shop\Hydrator\Order\Line as LineHydrator;

/**
 * Class LineFieldSet
 *
 * @package Shop\Form\Order
 */
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
