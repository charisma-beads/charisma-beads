<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   Shop\Controller\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller\Cart;

use Shop\Service\Cart\Cart as CartService;
use UthandoCommon\Service\ServiceTrait;
use Zend\Console\Request;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class Console
 *
 * @package Shop\Controller\Cart
 */
class Console extends AbstractActionController
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
        $service = $this->getService('ShopCart', ['initialize' => false]);

        $result = $service->clearExpired();

        return "No of database rows deleted: " . $result . "\r\n";
    }
} 