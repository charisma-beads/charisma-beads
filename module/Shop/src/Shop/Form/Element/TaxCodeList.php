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

use Shop\Service\TaxCodeService;
use UthandoCommon\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class TaxCodeList
 *
 * @package Shop\Form\Element
 */
class TaxCodeList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a tax code---';
    
    public function init()
    {
        $taxCodes = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(TaxCodeService::class)
            ->fetchAll();
        
        $taxCodeOptions = [];
    	
    	/* @var $taxCode \Shop\Model\TaxCodeModel */
    	foreach($taxCodes as $taxCode) {
    		$taxCodeOptions[$taxCode->getTaxCodeId()] = $taxCode->getTaxCode() . ' - ' . $taxCode->getDescription();
    	}
        
        $this->setValueOptions($taxCodeOptions);
    }

}
