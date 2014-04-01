<?php
namespace Shop\Controller\Country;

use Application\Controller\AbstractCrudController;

class Province extends AbstractCrudController
{
    protected $searchDefaultParams = array('sort' => 'countryCode');
    protected $serviceName = 'Shop\Service\CountryProvince';
    protected $route = 'admin/shop/country/province';
}
