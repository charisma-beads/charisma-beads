<?php

namespace Shop\Service\Factory;

use Shop\Options\InvoiceOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Class InvoiceOptions
 *
 * @package Shop\Service\Factory
 */
class InvoiceOptionsFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $config = $serviceLocator->get('config');
	    $options = isset($config['shop']['invoice_options']) ? $config['shop']['invoice_options'] : [];

	    return new InvoiceOptions($options);
	}
}
