<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Form\Order;

use Shop\Hydrator\Order\MetaData as MetaDataHydrator;
use Shop\Model\Order\MetaData;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class MetadataFieldSet extends Fieldset implements InputFilterProviderInterface
{
    /**
     * MetadataFieldSet constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new MetaDataHydrator())
            ->setObject(new MetaData());
    }

    /**
     * set up form elements
     */
    public function init()
    {
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [];
    }
}
