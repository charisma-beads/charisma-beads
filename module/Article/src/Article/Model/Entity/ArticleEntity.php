<?php

namespace Article\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class ArticleEntity extends AbstractEntity
{
	protected $filters = array(
	    array(
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
        ),
        array(
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
        )
	);
}
