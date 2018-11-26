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

use Shop\Options\ShopOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
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
