<?php

namespace FileManager;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;
use SessionManager\Service\Factory\SessionManagerFactory;
use Laminas\Http\Request;
use Laminas\Mvc\MvcEvent;


class Module implements ConfigInterface
{
    use ConfigTrait;

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $app            = $event->getApplication();
        $eventManager   = $app->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'startSession'],10);
    }

    /**
     * @param MvcEvent $event
     */
    public function startSession(MvcEvent $event)
    {
        // this is for use when uploading via flash
        $request = $event->getRequest();

        if ($request instanceof Request && $request->isFlashRequest() && $request->isPost()) {
            try {
                $sid = $request->getPost('sid', null);

                if ($sid) {
                    $session = $event->getApplication()
                        ->getServiceManager()
                        ->get(SessionManagerFactory::class);

                    $session->setId($sid);
                }
            } catch(\Exception $e) {
                echo '<pre>';
                echo $e->getMessage();
                echo '</pre';
                exit();
            }
        }

    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        );
    }
}
