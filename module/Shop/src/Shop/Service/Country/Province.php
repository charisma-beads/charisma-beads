<?php
namespace Shop\Service\Country;

use UthandoCommon\Service\AbstractMapperService;

class Province extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCountryProvince';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getProvincesByCountryId($id)
    {
        $id = (int) $id;

        /* @var $mapper \Shop\Mapper\Country\Province */
        $mapper = $this->getMapper();
        
        $provinces = $mapper->getProvincesByCountryId($id);
        
        return $provinces;
    }
}
