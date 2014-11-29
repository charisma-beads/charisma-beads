<?php
namespace Shop\Controller\Cart;

use Shop\Model\Cart\Item;
use Shop\Service\Cart\Cart as CartService;
use Shop\Service\Customer\Address;
use Shop\Service\Product\Product;
use Shop\ShopException;
use UthandoCommon\Controller\ServiceTrait;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class Cart
 * @package Shop\Controller\Cart
 * @method Request getRequest()
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
        $productService = $this->getService('Shop\Service\Product');
        $product = $productService->getFullProductById(
            $this->params()->fromPost('productId')
        );
        
        if (null === $product) {
            throw new ShopException('Product could not be added to cart as it does not exist');
        }

        /* @var $cart CartService */
        $cart = $this->getService('Shop\Service\Cart');
        $result = $cart->addItem(
            $product,
            $this->params()->fromPost('qty')
        );

        if ($result instanceof Item) {
            $this->flashMessenger()->addInfoMessage(
                'You have added ' . $result->getQuantity() . ' X ' . $result->getMetadata()->getName() . ' to your cart'
            );
        }

        
        return $this->redirect()->toUrl($this->params()
            ->fromPost('returnTo'));
    }

    public function viewAction()
    {
        if ($this->identity()) {
            /* @var $customerAddress Address */
            $customerAddress = $this->getService('Shop\Service\Customer\Address');
            $countryId = $customerAddress
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

        /* @var $cart CartService */
        $cart = $this->getService('Shop\Service\Cart');
        
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

        /* @var $productService Product */
        $productService = $this->getService('Shop\Service\Product');

        /* @var $cart CartService */
        $cart = $this->getService('Shop\Service\Cart');
        
        foreach ($this->params()->fromPost('quantity') as $id => $value) {

            $product = $productService->getFullProductById($id);
            
            if (null !== $product) {
                $cart->addItem($product, $value);
            }
        }
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }

    public function emptyAction()
    {
        /* @var $cart CartService */
        $cart = $this->getService('Shop\Service\Cart');

        $cart->clear();
        
        return $this->redirect()->toRoute('shop/cart', [
            'action' => 'view'
        ]);
    }
}
