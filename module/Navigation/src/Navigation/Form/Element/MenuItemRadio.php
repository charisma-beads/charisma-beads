<?php

namespace Navigation\Form\Element;

use Common\Mapper\AbstractNestedSet;
use Zend\Form\Element\Radio;

class MenuItemRadio extends Radio
{
    /**
     * init
     */
    public function init()
    {
        $valueOptions = [
            [
                'value' => AbstractNestedSet::INSERT_NO,
                'label' => 'No change.',
                'label_attributes' => [
                    'class' => 'col-md-12',
                ],

            ],
            [
                'value' => AbstractNestedSet::INSERT_NODE,
                'label' => 'Insert after.',
                'label_attributes' => [
                    'class' => 'col-md-12',
                ],

            ],
            [
                'value' => AbstractNestedSet::INSERT_CHILD,
                'label' => 'Insert as a sub-page.',
                'label_attributes' => [
                    'class' => 'col-md-12',
                ],

            ],
        ];

        $this->setValueOptions($valueOptions);

        $this->setValue(AbstractNestedSet::INSERT_NO);
    }
}
