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
            ->get('UthandoServiceManager')
            ->get('ShopTaxRate')
            ->fetchAll();
        
        $taxRateOptions = [];
		
		/* @var $taxRate \Shop\Model\Tax\Rate */
		foreach ($taxRates as $taxRate) {
			$taxRateOptions[$taxRate->getTaxRateId()] = $taxRate->getTaxRate();
		}
        
        $this->setValueOptions($taxRateOptions);
    }

}
