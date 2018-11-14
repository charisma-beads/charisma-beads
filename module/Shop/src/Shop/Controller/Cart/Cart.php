<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller\Cart;

use Shop\Model\Cart\Item;
use Shop\Model\Customer\Address as AddressModel;
use Shop\Model\Product\Product as ProductModel;
use Shop\Service\Cart\Cart as CartService;
use Shop\Service\Customer\Address;
use Shop\Service\Product\Product;
use UthandoCommon\Service\ServiceTrait;
use UthandoSessionManager\SessionContainerTrait;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * Class Cart
 *
 * @package Shop\Controller\Cart
 * @method Request getRequest()
 * @method Container sessionContainer()
 */
class Cart extends AbstractActionController
{
    use ServiceTrait,
        SessionContainerTrait;

    public function addAction()
    {
        if (! $this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('shop');
        }
        
        /* @var $productService Product */
        $productService = $this->getService('ShopProduct');
        $product = $productService->getFullProductById(
            $this->params()->fromPost('productId')
        );
        
        if ($product instanceof ProductModel) {
            /* @var $cart CartService */
            $cart = $this->getService('ShopCart');
            $result = $cart->addItem(
                $product,
                $this->params()->fromPost()
            );
    
            if ($result instanceof Item) {
                $messages = $cart->getMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        $this->flashMessenger()->addInfoMessage($message);
                    }
                }

                $this->flashMessenger()->addInfoMessage(
                    'You have added ' . $result->getQuantity() . ' X ' . $result->getMetadata()->getName() . ' to your cart'
                );
            }
        }
        
        return $this->redirect()->toUrl($this->params()
            ->fromPost('returnTo'));
    }

    public function viewAction()
    {
        $viewModel = new ViewModel();

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        $session = $this->sessionContainer('ShopCart');
        $countryId = $this->params()->fromPost('countryId', $session->offsetGet('countryId'));

        if ($this->identity()) {
            /* @var $customerAddressService Address */
            $customerAddressService = $this->getService('ShopCustomerAddress');

            $customerAddress = $customerAddressService->getAddressByUserId(
                $this->identity()->getUserId(), 'delivery'
            );

            if ($customerAddress instanceof AddressModel) {
                $countryId = $customerAddress->getCountryId();
            }
        }

        if (!$countryId) {
            /* @var \Shop\Service\Country\Country $countryService */
            $countryService = $this->getService('ShopCountry');
            $country = $countryService->getCountryByCountryCode('GB');
            $countryId = $country->getCountryId();
        }

        $session->offsetSet('countryId', $countryId);

        /* @var $cart CartService */
        $cart = $this->getService('ShopCart');

        $messages = $cart->getMessages();
        if (!empty($messages)) {
            foreach ($messages as $message) {
                $this->flashMessenger()->addInfoMessage($message);
            }
        }

        return $viewModel->setVariable('countryId', $countryId);
    }

    public function removeAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        /* @var $cart CartService */
        $cart = $this->getService('ShopCart');
        
        if ($id) {
            $cart->removeItem($id);
        }
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }

    public function updateAction()
    {
        if (! $this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('shop/cart', [
                'action' => 'view'
            ]);
        }

        /* @var $cart CartService */
        $cart = $this->getService('ShopCart');

        $items = $this->params()->fromPost('quantity');

        $cart->updateItem($items);
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
        
    }

    public function emptyAction()
    {
        /* @var $cart CartService */
        $cart = $this->getService('ShopCart');

        $cart->clear();
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }
}
