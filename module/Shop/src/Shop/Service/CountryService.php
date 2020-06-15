<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Form\CountryForm;
use Shop\Hydrator\CountryHydrator;
use Shop\InputFilter\CountryInputFilter;
use Shop\Mapper\CountryMapper;
use Shop\Model\CountryModel;
use Common\Service\AbstractRelationalMapperService;

/**
 * Class Country
 *
 * @package Shop\Service
 * @method null|CountryModel getById($id, $col=null);
 */
class CountryService extends AbstractRelationalMapperService
{
    protected $form         = CountryForm::class;
    protected $hydrator     = CountryHydrator::class;
    protected $inputFilter  = CountryInputFilter::class;
    protected $mapper       = CountryMapper::class;
    protected $model        = CountryModel::class;
    
    protected $tags = [
        'country', 'post-zone',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'postZone'  => [
            'refCol'    => 'postZoneId',
            'service'   => PostZoneService::class,
        ],
    ];

    /**
     * @param $code
     * @return null|CountryModel
     */
    public function getCountryByCountryCode($code)
    {
        /* @var $mapper \Shop\Mapper\CountryMapper */
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
        /* @var $mapper \Shop\Mapper\CountryMapper */
        $mapper = $this->getMapper();

        return $mapper->getCountryPostalRates($id);
    }
}
