<?php
namespace Navigation\InputFilter;

use Zend\InputFilter\InputFilter;

class Page extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
            'name'       => 'label',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
                array('name'    => 'Application\Filter\Ucwords'),
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
        ));
		
		$this->add(array(
            'name'       => 'params',
            'required'   => false,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
        ));
		
		$this->add(array(
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
        ));
		
		$this->add(array(
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
        ));
	}
}
