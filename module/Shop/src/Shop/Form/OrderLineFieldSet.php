<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;


use Shop\Form\Element\Number;
use Shop\Hydrator\Order\OrderLineHydrator;
use Shop\Model\OrderLineModel;
use Zend\Form\Element\Hidden;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Class LineFieldSet
 *
 * @package Shop\Form
 */
class OrderLineFieldSet extends Fieldset implements InputFilterProviderInterface
{
    /**
     * Constructor
     *
     * @param null|string $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        
        $this->setHydrator(new OrderLineHydrator())
            ->setObject(new OrderLineModel());
    }

    /**
     * set up elements
     */
    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'productId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'quantity',
            'type' => Number::class,
            'options' => [
                'label' => 'Quantity:',
                'required' => true,
            ],
            'attributes' => [
                'min'  => '0',
                'step' => '1',
                'value' => 1,
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [];
    }
}
