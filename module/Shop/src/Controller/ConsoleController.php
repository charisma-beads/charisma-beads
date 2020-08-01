<?php

namespace Shop\Controller;

use Shop\Service\CartService;
use Common\Service\ServiceTrait;
use Laminas\Console\Request;
use Laminas\Mvc\Controller\AbstractActionController;

/**
 * Class Console
 *
 * @package Shop\Controller
 */
class ConsoleController extends AbstractActionController
{
    use ServiceTrait;

    /**
     * Clears all old expired carts
     */
    public function gcAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof Request) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        /* @var $service CartService */
        $service = $this->getService(CartService::class, ['initialize' => false]);

        $result = $service->clearExpired();

        return "No of database rows deleted: " . $result . "\r\n";
    }
} 