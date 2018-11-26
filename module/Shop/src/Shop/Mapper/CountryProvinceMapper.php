<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

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
