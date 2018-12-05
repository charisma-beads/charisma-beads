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

use Shop\Service\TaxRateService;
use UthandoCommon\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

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
