<?php

namespace Shop\Form;


use Shop\Form\Element\Number;
use Shop\Hydrator\Order\OrderLineHydrator;
use Shop\Model\OrderLineModel;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;

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
