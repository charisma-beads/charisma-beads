<?php
namespace Shop\Form\Country;

use Zend\Form\Form;

class Province extends Form
{
    public function init()
    {
        $this->add([
            'name'	=> 'provinceId',
            'type'	=> 'hidden',
        ]);

        $this->add([
            'name'	=> 'countryId',
            'type'	=> 'hidden',
        ]);

        $this->add([
            'name'			=> 'provinceCode',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Province Code:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Province Code:',
                'required'	=> true,
            ],
        ]);

        $this->add([
            'name'			=> 'provinceName',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Name:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Name:',
                'required'	=> true,
            ],
        ]);

        $this->add([
            'name'			=> 'provinceAlternateNames',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Alternate Name:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Alternate Name:',
                'required'	=> true,
            ],
        ]);
    }
}
