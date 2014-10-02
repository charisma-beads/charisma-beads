<?php
namespace Shop\Service\Country;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Country extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCountry';

    /**
     * @var array
     */
    protected $referenceMap = [
        'postZone'  => [
            'refCol'    => 'postZoneId',
            'service'   => 'Shop\Service\Post\Zone',
        ],
    ];

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getCountryPostalRates($id)
    {
        $id = (int) $id;
        /* @var $mapper \Shop\Mapper\Country\Country */
        $mapper = $this->getMapper();

        return $mapper->getCountryPostalRates($id);
    }
}
