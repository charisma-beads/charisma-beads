<?php
namespace User\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class UserEntity extends AbstractEntity
{   
    protected $filters = array(
        array(
            'name'       => 'firstname',
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
        ),
        array(
            'name'       => 'lastname',
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
        ),
        array(
            'name'       => 'email',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
        ),
        array(
            'name'       => 'passwd',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
        ),
    );
    
    public function getFullName()
    {
    	return $this->row->firstname . ' ' . $this->row->lastname;
    }
    
    public function getLastNameFirst()
    {
    	return $this->row->lastname . ', ' . $this->row->firstname;
    }
}
