<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Shop\Service\Tax\Tax as TaxService;

/**
 * Class Tax
 *
 * @package Shop\Service\Factory
 */
class Tax implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $shopOptions \Shop\Options\ShopOptions */
        $shopOptions = $serviceLocator->get('Shop\Options\Shop');
        
        $taxService = new TaxService();
         
        $taxService->setTaxState($shopOptions->isVatState());
         
        return $taxService;
    }
}
