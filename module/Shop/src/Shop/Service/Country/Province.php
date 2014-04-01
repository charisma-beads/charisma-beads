<?php
namespace Shop\Service\Country;

use Application\Service\AbstractService;

class Province extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Country\Province';
    protected $form = 'Shop\Form\Country\Province';
    protected $inputFilter = 'Shop\InputFilter\Country\Province';
    
    public function populate($model, $children = false)
    {
        return;
    }
}
