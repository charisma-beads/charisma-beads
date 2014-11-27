<?php
namespace Shop\Mapper\Country;

use UthandoCommon\Mapper\AbstractDbMapper;

class Province extends AbstractDbMapper
{
    protected $table = 'countryProvince';
    protected $primary = 'provinceId';
    
    public function getProvincesByCountryId($id)
    {
        $id = (int) $id;
        
        $select = $this->getSelect();
        $select->where->equalTo('countryId', $id);
        return $this->fetchResult($select);
    }
}
