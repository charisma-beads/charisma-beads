<?php

declare(strict_types=1);

namespace Shop\Service\Factory;

use PDO;
use Shop\Service\ProductAvailabilityService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

final class ProductAvailabilityServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): ProductAvailabilityService
    {
        $config     = $serviceLocator->get('config');
        $dbOptions  = $config['uthando_common']['db_options'];
        $pdo        = new PDO(sprintf(
            'mysql:host=%s;dbname=%s;port=%d;charset=%s',
            $dbOptions['host'],
            $dbOptions['database'],
            $dbOptions['port'],
            'utf8'
        ), $dbOptions['user'], $dbOptions['password'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return new ProductAvailabilityService($pdo);
    }
}

