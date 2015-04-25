<?php
namespace Shop\InputFilter;

use Zend\InputFilter\InputFilter;

class Advert extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'advertId',
            'type' => 'hidden',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'   => [
                ['name' => 'Int'],
            ],
        ]);
        
        $this->add([
            'name' => 'advert',
            'type' => 'text',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'StringLength', 'options' => [
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 255,
                ]],
            ],
        ]);
        
        $this->add([
            'name' => 'enabled',
            'type' => 'checkbox',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}
