<?php

namespace Navigation\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class MenuEntity extends AbstractEntity
{
    protected $filters = array(
        array(
            'name'       => 'menu',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 2,
                        'max'      => 255,
                    ),
                ),
            ),
        )
    );
}
