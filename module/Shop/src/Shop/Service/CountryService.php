<?php

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
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getCountryPostalRates($id)
    {
        $id = (int) $id;
        /* @var $mapper \Shop\Mapper\CountryMapper */
        $mapper = $this->getMapper();

        return $mapper->getCountryPostalRates($id);
    }
}
