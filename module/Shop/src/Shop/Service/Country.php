<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Country extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Country';
    protected $form = 'Shop\Form\Country';
    protected $inputFilter = 'Shop\InputFilter\Country';
    
    public function getCountryPostalRates($id)
    {
        $id = (int) $id;
        return $this->getMapper()->getCountryPostalRates($id);
    }
    
}
