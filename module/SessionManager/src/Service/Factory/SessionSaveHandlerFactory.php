<?php

namespace SessionManager\Service\Factory;

use Common\Options\DbOptions;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Session\SaveHandler\DbTableGatewayOptions;
use SessionManager\Session\SaveHandler\DbTableGateway;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class SessionSaveHandlerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        // grab the config array
        $options = $sm->get(DbOptions::class);

        $dbAdapter = new Adapter($options->toArray());

        // get the session options (column names)
        $sessionOptions = new DbTableGatewayOptions();

        // crate the TableGateway object specifying the table name
        $sessionTableGateway = new TableGateway('session', $dbAdapter);
        // create your saveHandler object
        $saveHandler = new DbTableGateway($sessionTableGateway, $sessionOptions);

        return $saveHandler;
    }
}
