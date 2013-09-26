<?php
namespace Article\InputFilter;

use Zend\InputFilter\InputFilter;

class Article extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
            'name'       => 'title',
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
            'name'       => 'slug',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
                array('name'    => 'Application\Filter\Slug')
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
