<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class Country extends AbstractMapper
{
    protected $table = 'country';
    protected $primary = 'countryId';
    protected $model = 'Shop\Model\Country';
    protected $hydrator = 'Shop\Hydrator\Country';
    
    
}
