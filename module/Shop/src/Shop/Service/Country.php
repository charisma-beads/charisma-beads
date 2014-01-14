<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Country extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Country';
    protected $form = 'Shop\Form\Country';
    protected $inputFilter = 'Shop\InputFilter\Country';
    
    public function getCountryPostalRates($id)
    {
        $id = (int) $id;
        return $this->getMapper()->getCountryPostalRates($id);
    }
    
    public function searchCountries(array $post)
    {
    	$country = (isset($post['country'])) ? (string) $post['country'] : '';
    	$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
    
    	//$this->getMapper()->useModelRelationships(true);
    
    	$countries = $this->getMapper()->searchCountries($country, $sort);
    
    	return $countries;
    }
}
