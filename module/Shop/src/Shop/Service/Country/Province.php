<?php
namespace Shop\Service\Country;

use UthandoCommon\Service\AbstractMapperService;

class Province extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Country\Province';
    protected $form = 'Shop\Form\Country\Province';
    protected $inputFilter = 'Shop\InputFilter\Country\Province';

    protected $serviceAlias = 'ShopCountryProvince';
    
    public function getProvincesByCountryId($id)
    {
        $id = (int) $id;
        
        $provinces = $this->getMapper()->getProvincesByCountryId($id);
        
        return $provinces;
    }
}
