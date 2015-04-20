<?php
namespace Shop\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Shop\Service\Tax\Tax as TaxService;

class Tax implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $shopOptions \Shop\Options\ShopOptions */
        $shopOptions = $serviceLocator->get('Shop\Options\Shop');
        
        $taxService = new TaxService();
         
        $taxService->setTaxState($shopOptions->getVatState());
         
        return $taxService;
    }
}
