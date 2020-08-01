<?php

namespace SessionManager\Service\Factory;

use SessionManager\Options\SessionOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

class SessionManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        /** @var SessionOptions $sessionOptions */
        $sessionOptions         = $sm->get(SessionOptions::class);
        $sessionConfigOptions   = $sm->get(SessionConfigOptionsFactory::class);

        $class                  = $sessionOptions->getStorage();
        $sessionStorage         = new $class();

        $sessionSaveHandler = $sessionOptions->getSaveHandler();

        if (null !== $sessionSaveHandler) {
            // class should be fetched from service manager since it will require constructor arguments
            $sessionSaveHandler = $sm->get($sessionSaveHandler);
        }

        $sessionManager = new SessionManager(
            $sessionConfigOptions,
            $sessionStorage,
            $sessionSaveHandler
        );

        $chain = $sessionManager->getValidatorChain();

        foreach ($sessionOptions->getValidators() as $validator) {
            $validator = new $validator();
            $chain->attach('session.validate', [$validator, 'isValid']);
        }

        Container::setDefaultManager($sessionManager);

        return $sessionManager;
    }
}
