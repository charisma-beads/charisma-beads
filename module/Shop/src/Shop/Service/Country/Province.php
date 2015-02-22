<?php
namespace Shop\Service\Country;

use Shop\ShopException;
use UthandoCommon\Service\AbstractMapperService;

class Province extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCountryProvince';
    
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

        /* @var $mapper \Shop\Mapper\Country\Province */
        $mapper = $this->getMapper();
        
        $provinces = $mapper->getProvincesByCountryId($id);

        return $provinces;
    }
}
