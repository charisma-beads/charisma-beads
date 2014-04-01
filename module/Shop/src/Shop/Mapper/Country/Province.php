<?php
namespace Shop\Mapper\Country;

use Application\Mapper\AbstractMapper;

class Province extends AbstractMapper
{
    protected $table = 'countryProvince';
    protected $primary = 'countryProvinceId';
    protected $model = 'Shop\Model\Country\Province';
    protected $hydrator = 'Shop\Hydrator\Country\Province';
}
