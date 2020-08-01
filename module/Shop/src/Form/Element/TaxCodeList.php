<?php

namespace Shop\Form\Element;

use Shop\Service\TaxCodeService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

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
