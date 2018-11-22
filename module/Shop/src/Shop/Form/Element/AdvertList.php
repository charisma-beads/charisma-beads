<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use UthandoCommon\Service\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

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
