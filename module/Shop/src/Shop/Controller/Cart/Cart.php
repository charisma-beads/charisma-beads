<?php
namespace Shop\Controller\Cart;

use Shop\Model\Cart\Item;
use Shop\Model\Customer\Address as AddressModel;
use Shop\Model\Product\Product as ProductModel;
use Shop\Service\Cart\Cart as CartService;
use Shop\Service\Customer\Address;
use Shop\Service\Product\Product;
use UthandoCommon\Controller\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class Cart
 * @package Shop\Controller\Cart
 * @method \Zend\Http\Request getRequest()
 */
class Cart extends AbstractActionController
{
    use ServiceTrait;

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
        $countryId = $this->params()->fromPost('countryId', null);

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

        return new ViewModel(array(
            'countryId' => $countryId
        ));
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