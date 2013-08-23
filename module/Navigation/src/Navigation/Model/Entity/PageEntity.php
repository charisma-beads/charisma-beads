<?php

namespace Navigation\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class PageEntity extends AbstractEntity
{
    protected $filters = array(
        array(
            'name'       => 'label',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
                array('name'    => 'Core\Filter\Ucwords'),
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
        ),
        array(
            'name'       => 'params',
            'required'   => false,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
        ),
        array(
            'name'       => 'route',
            'required'   => false,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 0,
                        'max'      => 255,
                    ),
                ),
            ),
        ),
        array(
            'name'       => 'resource',
            'required'   => false,
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
        ),
    );
    
    public function getIsVisible()
    {
        return ($this->row->visible) ? 'Yes' : 'No';
    }
    
    public function getRoute()
    {
        return ($this->row->route == '0') ? 'Category Heading' : $this->row->route;
    }
}
