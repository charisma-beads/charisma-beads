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

use Shop\Form\CountryProvinceForm;
use Shop\Hydrator\CountryProvinceHydrator;
use Shop\InputFilter\CountryProvinceInputFilter;
use Shop\Mapper\CountryProvinceMapper;
use Shop\Model\CountryProvinceModel;
use Shop\ShopException;
use Common\Service\AbstractMapperService;

/**
 * Class Province
 *
 * @package Shop\Service
 */
class CountryProvinceService extends AbstractMapperService
{
    protected $form         = CountryProvinceForm::class;
    protected $hydrator     = CountryProvinceHydrator::class;
    protected $inputFilter  = CountryProvinceInputFilter::class;
    protected $mapper       = CountryProvinceMapper::class;
    protected $model        = CountryProvinceModel::class;
    
    protected $tags = [
        'country-province',
    ];

    /**
    * @param array $post
    * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
    * @throws ShopException
    */
    public function search(array $post)
    {
        if (!isset($post['countryId'])) {
            throw new ShopException('countryId needs to be set.');
        }

        return $this->getProvincesByCountryId($post['countryId']);
    }

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getProvincesByCountryId($id)
    {
        $id = (int) $id;

        /* @var $mapper \Shop\Mapper\CountryProvinceMapper */
        $mapper = $this->getMapper();
        
        $provinces = $mapper->getProvincesByCountryId($id);

        return $provinces;
    }
}
