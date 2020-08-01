<?php

namespace Shop\Service\Factory;

use Shop\Options\ShopOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\TaxService;

/**
 * Class Tax
 *
 * @package Shop\Service\Factory
 */
class TaxServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $shopOptions \Shop\Options\ShopOptions */
        $shopOptions = $serviceLocator->get(ShopOptions::class);
        
        $taxService = new TaxService();
         
        $taxService->setTaxState($shopOptions->isVatState());
         
        return $taxService;
    }
}
