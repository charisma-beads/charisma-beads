<?php
namespace Shop\Mapper\Country;

use UthandoCommon\Mapper\AbstractMapper;

class Province extends AbstractMapper
{
    protected $table = 'countryProvince';
    protected $primary = 'countryProvinceId';
    protected $model = 'Shop\Model\Country\Province';
    protected $hydrator = 'Shop\Hydrator\Country\Province';
    
    public function getProvincesByCountryId($id)
    {
        $id = (int) $id;
        
        $select = $this->getSelect();
        $select->where->equalTo('countryId', $id);
        return $this->fetchResult($select);
    }
}
