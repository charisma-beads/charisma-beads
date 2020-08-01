<?php

namespace Shop\Form\Element;

use Shop\Service\TaxRateService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class TaxRateList
 *
 * @package Shop\Form\Element
 */
class TaxRateList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a tax rate---';
    
    public function init()
    {
        $taxRates = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(TaxRateService::class)
            ->fetchAll();
        
        $taxRateOptions = [];
		
		/* @var $taxRate \Shop\Model\TaxRateModel */
		foreach ($taxRates as $taxRate) {
		    $rate = $taxRate->getTaxRate();
			$taxRateOptions[$taxRate->getTaxRateId()] = $rate . '%';
		}
        
        $this->setValueOptions($taxRateOptions);
    }

}
