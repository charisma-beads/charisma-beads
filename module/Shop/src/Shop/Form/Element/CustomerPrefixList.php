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

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class CustomerPrefixList
 *
 * @package Shop\Form\Element
 */
class CustomerPrefixList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a prefix---';
    
    public function init()
    {
        $prefixes = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopCustomerPrefix')
            ->fetchAll();
        
    	$prefixOptions = [];
    	
    	/* @var $prefix \Shop\Model\Customer\Prefix */
    	foreach($prefixes as $prefix) {
    		$prefixOptions[$prefix->getPrefixId()] = $prefix->getPrefix();
    	}
        
        $this->setValueOptions($prefixOptions);
    }

}
