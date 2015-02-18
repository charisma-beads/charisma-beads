<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class TaxCodeList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a tax code---';
    
    public function init()
    {
        $taxCodes = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopTaxCode')
            ->fetchAll();
        
        $taxCodeOptions = [];
    	
    	/* @var $taxCode \Shop\Model\Tax\Code */
    	foreach($taxCodes as $taxCode) {
    		$taxCodeOptions[$taxCode->getTaxCodeId()] = $taxCode->getTaxCode() . ' - ' . $taxCode->getDescription();
    	}
        
        $this->setValueOptions($taxCodeOptions);
    }

}
