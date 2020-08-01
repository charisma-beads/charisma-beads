<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Province
 *
 * @package Shop\Mapper
 */
class CountryProvinceMapper extends AbstractDbMapper
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
