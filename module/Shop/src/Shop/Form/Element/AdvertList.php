<?php
namespace Shop\Form\Element;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AdvertList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = 'Where did you hear about us (please select an option)';
    
    public function init()
    {
        $this->setName('advertId');
        
        $adverts = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopAdvert')
            ->fetchAll();
        
    	$advertOptions = [];
    	
    	/* @var $advert \Shop\Model\Advert\Advert */
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
