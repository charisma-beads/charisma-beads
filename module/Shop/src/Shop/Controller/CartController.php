<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller;

use Shop\Model\CartItemModel;
use Shop\Model\CustomerAddressModel;
use Shop\Model\ProductModel;
use Shop\Service\CartService;
use Shop\Service\CountryService;
use Shop\Service\CustomerAddressService;
use Shop\Service\ProductService;
use Common\Service\ServiceTrait;
use SessionManager\SessionContainerTrait;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * Class Cart
 *
 * @package Shop\Controller
 * @method Request getRequest()
 * @method Container sessionContainer()
 */
class CartController extends AbstractActionController
{
    use ServiceTrait,
        SessionContainerTrait;

    public function addAction()
    {
        if (! $this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('shop');
        }
        
        /* @var $productService ProductService */
        $productService = $this->getService(ProductService::class);
        $product = $productService->getFullProductById(
            $this->params()->fromPost('productId')
        );
        
        if ($product instanceof ProductModel) {
            /* @var $cart CartService */
            $cart = $this->getService(CartService::class);
            $result = $cart->addItem(
                $product,
                $this->params()->fromPost()
            );
    
            if ($result instanceof CartItemModel) {
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

        $session = $this->sessionContainer(CartService::class);
        $countryId = $this->params()->fromPost('countryId', $session->offsetGet('countryId'));

        if ($this->identity()) {
            /* @var $customerAddressService CustomerAddressService */
            $customerAddressService = $this->getService(CustomerAddressService::class);

            $customerAddress = $customerAddressService->getAddressByUserId(
                $this->identity()->getUserId(), 'delivery'
            );

            if ($customerAddress instanceof CustomerAddressModel) {
                $countryId = $customerAddress->getCountryId();
            }
        }

        if (!$countryId) {
            /* @var \Shop\Service\CountryService $countryService */
            $countryService = $this->getService(CountryService::class);
            $country = $countryService->getCountryByCountryCode('GB');
            $countryId = $country->getCountryId();
        }

        $session->offsetSet('countryId', $countryId);

        /* @var $cart CartService */
        $cart = $this->getService(CartService::class);

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
        $cart = $this->getService(CartService::class);
        
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
        $cart = $this->getService(CartService::class);

        $items = $this->params()->fromPost('quantity');

        $cart->updateItem($items);
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
        
    }

    public function emptyAction()
    {
        /* @var $cart CartService */
        $cart = $this->getService(CartService::class);

        $cart->clear();
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }
}
