<?php
namespace Shop\Controller;

use Shop\ShopException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Cart extends AbstractActionController
{
    /**
     * @var \Shop\Model\Cart\Cart
     */
    protected $cart;

    /**
     * @var \Shop\Service\Product|Product
     */
    protected $productService;

    /**
     * @var \Shop\Service\Customer\Address
     */
    protected $customerAddressService;

    public function addAction()
    {
        if (! $this->request->isPost()) {
            return $this->redirect()->toRoute('shop');
        }
        
        $product = $this->getProductService()->getFullProductById($this->params()
            ->fromPost('productId'));
        
        if (null === $product) {
            throw new ShopException('Product could not be added to cart as it does not exist');
        }
        
        $this->getCart()->addItem($product, $this->params()
            ->fromPost('qty'));
        
        $this->flashMessenger()->addInfoMessage('You have added ' . $this->params()
            ->fromPost('qty') . ' X ' . $product->getName() . ' to your cart');
        
        return $this->redirect()->toUrl($this->params()
            ->fromPost('returnTo'));
    }

    public function viewAction()
    {
        if ($this->identity()) {
            $countryId = $this->getCustomerAddressService()
                ->getAddressByUserId($this->identity()
                ->getUserId(), 'delivery')
                ->getCountryId();
        } else {
            $countryId = null;
        }
        
        return new ViewModel(array(
            'countryId' => $countryId
        ));
    }

    public function removeAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        
        if ($id) {
            $this->getCart()->removeItem($id);
        }
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }

    public function updateAction()
    {
        if (! $this->request->isPost()) {
            return $this->redirect()->toRoute('shop/cart', [
                'action' => 'view'
            ]);
        }
        
        foreach ($this->params()->fromPost('quantity') as $id => $value) {
            $product = $this->getProductService()->getFullProductById($id);
            
            if (null !== $product) {
                $this->getCart()->addItem($product, $value);
            }
        }
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }

    public function emptyAction()
    {
        $this->getCart()->clear();
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }

    /**
     *
     * @return \Shop\Model\Cart\Cart
     */
    protected function getCart()
    {
        if (! $this->cart) {
            $sl = $this->getServiceLocator();
            $this->cart = $sl->get('Shop\Service\Cart');
        }
        
        return $this->cart;
    }

    /**
     *
     * @return \Shop\Service\Product
     */
    protected function getProductService()
    {
        if (! $this->productService) {
            $sl = $this->getServiceLocator();
            $this->productService = $sl->get('Shop\Service\Product');
        }
        
        return $this->productService;
    }

    /**
     *
     * @return \Shop\Service\Customer\Address
     */
    public function getCustomerAddressService()
    {
        if (! $this->customerAddressService) {
            $sl = $this->getServiceLocator();
            $this->customerAddressService = $sl->get('Shop\Service\Customer\Address');
        }
        
        return $this->customerAddressService;
    }
}
