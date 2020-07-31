<?php

namespace Shop\Form\Element;

use Shop\Service\AdvertService;
use Common\Service\ServiceManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class AdvertList
 *
 * @package Shop\Form\Element
 */
class AdvertList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = 'Where did you hear about us (please select an option)';
    
    public function init()
    {
        $this->setName('advertId');
        
        $adverts = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(AdvertService::class)
            ->fetchAll();
        
    	$advertOptions = [];
    	
    	/* @var $advert \Shop\Model\AdvertModel */
    	foreach($adverts as $advert) {
    		$advertOptions[$advert->getAdvertId()] = $advert->getAdvert();
    	}
        
        $this->setValueOptions($advertOptions);
    }
    
    public function getInputSpecification()
    {
        $spec = parent::getInputSpecification();
        
        $spec['filters'][] = ['name' => 'StripTags'];
        $spec['filters'][] = ['name' => 'StringTrim'];
        
        return $spec;
    }
}
