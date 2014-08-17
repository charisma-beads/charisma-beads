<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class TaxRateList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a tax rate---';
    
    public function init()
    {
        $taxRates = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Shop\Service\Tax\Rate')
            ->fetchAll();
        
        $taxRateOptions = [];
		
		/* @var $taxRate \Shop\Model\Tax\Rate */
		foreach ($taxRates as $taxRate) {
			$taxRateOptions[$taxRate->getTaxRateId()] = $taxRate->getTaxRate();
		}
        
        $this->setValueOptions($taxRateOptions);
    }

}
