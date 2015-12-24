<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Country;

use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class Country
 *
 * @package Shop\Service\Country
 * @method null|\Shop\Model\Country\Country getById($id, $col=null);
 */
class Country extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCountry';
    
    protected $tags = [
        'country', 'post-zone',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'postZone'  => [
            'refCol'    => 'postZoneId',
            'service'   => 'ShopPostZone',
        ],
    ];

    /**
     * @param $code
     * @return null|\Shop\Model\Country\Country
     */
    public function getCountryByCountryCode($code)
    {
        /* @var $mapper \Shop\Mapper\Country\Country */
        $mapper = $this->getMapper();

        return $mapper->getCountryByCountryCode($code);
    }

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
