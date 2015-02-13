<?php
namespace Shop\Form\Customer;

trait CustomerTrait
{
    public function addElements()
    {
        $this->add([
            'name' => 'prefixId',
            'type' => 'CustomerPrefixList',
            'attributes'	=> [
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Prefix:',
                'required'	=> true,
            ],
        ]);
         
        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'options'		=> [
                'label' => 'Firstname:'
            ],
        ]);
         
        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'options'		=> [
                'label' => 'Lastname:'
            ],
        ]);
        
        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email:',
            ],
        ]);
    }
}
