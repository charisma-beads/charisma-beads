<?php
namespace Shop\InputFilter;

use Zend\InputFilter\InputFilter;

class Advert extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'advertId',
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
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}
