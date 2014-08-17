<?php
namespace Shop\Service\Country;

use UthandoCommon\Service\AbstractService;

class Province extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Country\Province';
    protected $form = 'Shop\Form\Country\Province';
    protected $inputFilter = 'Shop\InputFilter\Country\Province';
    
    public function getProvincesByCountryId($id)
    {
        $id = (int) $id;
        
        $provinces = $this->getMapper()->getProvincesByCountryId($id);
        
        return $provinces;
    }
}
