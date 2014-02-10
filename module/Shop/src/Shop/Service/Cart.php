<?php
namespace Shop\Service;

use Application\Service\AbstractService;
use Shop\Model\Cart as CartModel;
use Shop\Model\Cart\Item as CartItem;
use Shop\Model\Product as ProductModel;
use Shop\Model\Product\MetaData as ProductMetaData;
use Shop\Service\Cart\Cookie as CartCookie;
use Shop\Service\Cart\Item;
use Shop\Service\Tax;
use Zend\Session\Container;

class Cart extends AbstractService
{

    protected $mapperClass = 'Shop\Mapper\Cart';

    /**
     *
     * @var Container
     */
    protected $container;

    /**
     *
     * @var Tax
     */
    protected $taxService;

    /**
     *
     * @var Item
     */
    protected $cartItemService;

    /**
     *
     * @var CartCookie
     */
    protected $cartCookieService;

    /**
     *
     * @var CartModel
     */
    protected $cart;

    /**
     *
     * @var boolean
     */
    protected $isInitialized = false;
    
    /**
     * Total before shipping
     *
     * @var float
     */
    protected $subTotal = 0;
    
    /**
     * Total with shipping
     *
     * @var float
     */
    protected $total = 0;
    
    /**
     * The shipping cost
     *
     * @var float
     */
    protected $shipping = 0;
    
    /**
     * Total of tax
     *
     * @var float
     */
    protected $taxTotal = 0;

    public function initialize()
    {
        if ($this->isInitialized) {
            return;
        }
        
        $cart = null;
        
        // check first if there is a cartId in the session data,
        // else try to retrieve the cartId from cookie verifier.
        if (isset($this->getContainer()->cartId)) {
            $cartId = $this->getContainer()->cartId;
            $cart = $this->getById($cartId);
        } else {
            $verifier = $this->getCartCookieService()->retrieveCartVerifierCookie();
            
            if ($verifier) {
                $cart = $this->getCartByVerifier($verifier);
            }
        }
        
        // load any cart items
        if ($cart) {
            $items = $this->getCartItemService()->getCartItemsByCartId($cart->getCartId());
            
            /* @var $item \Shop\Model\Cart\Item */
            foreach ($items as $item) {
                $cart->offsetSet($item->getMetadata()->getProductId(), $item);  
            }
        }
        
        $this->setCart($cart);
        $this->isInitialized = true;
    }

    /**
     *
     * @param string $verifier            
     * @return \Shop\Model\Cart
     */
    public function getCartByVerifier($verifier)
    {
        $verifier = (string) $verifier;
        $cart = $this->getMapper()->getCartByVerifier($verifier);
        
        return $cart;
    }

    /**
     * Adds or updates an item contained with the shopping cart
     *
     * @param ProductModel $product            
     * @param int $qty            
     * @return CartItem
     */
    public function addItem(ProductModel $product, $qty)
    {
        $this->initialize();
        
        if (0 > $qty) {
            return false;
        }
        
        $cart = $this->getCart();
        
        $cartItem = ($cart->offsetExists($product->getProductId())) ? $cart->offsetGet($product->getProductId()): new CartItem();
        
        if (0 == $qty) {
            $this->removeItem($cartItem->getCartItemId());
            return false;
        }
        
        $cartItem->setDescription($product->getShortDescription())
            ->setPrice($product->getPrice())
            ->setQuantity($qty)
            ->setTax($product->getTaxRate())
            ->setMetadata($this->getProductMetaData($product))
            ->setCartId($this->getCart()->getCartId());
        
        $cart->offsetSet($product->getProductId(), $cartItem);
        
        $this->persist();
        
        return $cartItem;
    }

    /**
     *
     * @param ProductModel $product            
     * @return ProductMetaData
     */
    public function getProductMetaData(ProductModel $product)
    {
        $metadata = new ProductMetaData();
        
        $metadata->setProductId($product->getProductId())
            ->setName($product->getName())
            ->setCategory($product->getCategory())
            ->setTaxable($product->getTaxable())
            ->setVatInc($product->getVatInc())
            ->setAddPostage($product->getAddPostage())
            ->setPostUnit($product->getPostUnit());
        
        return $metadata;
    }

    /**
     * Remove an item for the shopping cart
     *
     * @param ProductModel $product            
     */
    public function removeItem($id)
    {
        $this->getCartItemService()->delete($id);
    }

    /**
     * clears shopping cart of all items
     */
    public function clear()
    {
        $this->getCart()->clear();
        $this->delete($this->getCart()->getCartId());
        $this->getCartCookieService()->removeCartVerifierCookie();
        unset($this->cart);
    }

    /**
     * Setter for the session namespace
     *
     * @param Zend\Session\Container $ns            
     */
    public function setContainer(Container $ns)
    {
        $this->container = $ns;
    }

    /**
     * Getter for session namespace
     *
     * @return Zend\Session\Container
     */
    public function getContainer()
    {
        if (! $this->container instanceof Container) {
            $this->setContainer(new Container(__CLASS__));
        }
        
        return $this->container;
    }

    /**
     * Persist the cart data in the session and in
     * the database, then set a cookie for persistance after
     * session has been expired.
     */
    public function persist()
    {
        $cart = $this->getCart();
        $cart->setDateModified();
        
        $result = $this->save($cart);
        
        foreach ($cart as $cartItem) {
            $this->getCartItemService()->save($cartItem);
        }
        
        $this->getContainer()->cartId = $cart->getCartId();
    }

    /**
     *
     * @return CartModel
     */
    public function getCart()
    {
        $this->initialize();
        return $this->cart;
    }

    /**
     *
     * @param CartModel $cart            
     */
    public function setCart($cart = null)
    {
        if (! $cart instanceof CartModel) {
            $cart = $this->getMapper()->getModel();
            $cart->setExpires($this->getCartCookieService()->getCookieConfig()->getExpiry())
                ->setVerifyId($this->getCartCookieService()->setCartVerifierCookie());
            $cartId = $this->save($cart);
            $cart->setCartId($cartId);
            $this->getContainer()->cartId = $cartId;
        }
        
        $this->cart = $cart;
    }

    /**
     * calulates the item line price
     *
     * @param CartItem $item            
     * @return number
     */
    public function getLineCost(CartItem $item)
    {
        $price = $item->getPrice(true);
        
        if (true === $item->getMetadata()->getTaxable()) {
            $taxService = $this->getTaxService();
            $taxService->setTaxInc($item->getVatInc());
            $price = $taxService->addTax($price, $item->getTaxRate(true));
            $this->taxTotal += $price['tax'] * $item->getQuantity();
        }
        
        return ($price['price'] + $price['tax']) * $item->getQuantity();
    }

    /**
     * Calculate the totals
     */
    public function calculateTotals()
    {
        $sub = 0;
        $this->taxTotal = 0;
        
        foreach($this->getCart() as $cartItem) {
            $sub = $sub + $this->getLineCost($cartItem);
        }
        
        $this->subTotal = $sub;
        $this->total = $this->subTotal + $this->shipping;
    }

    /**
     * Set the shipping cost
     *
     * @param float $cost            
     */
    public function setShippingCost($cost)
    {
        $this->shipping = $cost;
        $this->calculateTotals();
        $this->persist();
    }

    /**
     * Get the shipping cost
     *
     * @return float
     */
    public function getShippingCost()
    {
        $this->calculateTotals();
        return $this->shipping;
    }

    /**
     * Get the sub total
     *
     * @return float
     */
    public function getSubTotal()
    {
        $this->calculateTotals();
        return $this->subTotal;
    }

    /**
     * Get the basket total
     *
     * @return float
     */
    public function getTotal()
    {
        $this->calculateTotals();
        return $this->total;
    }

    /**
     *
     * @return Tax $taxService
     */
    public function getTaxService()
    {
        if (! $this->taxService instanceof Tax) {
            $sl = $this->getServiceLocator();
            $this->taxService = $sl->get('Shop\Service\Tax');
        }
        
        return $this->taxService;
    }

    /**
     *
     * @return Item $cartItemService
     */
    public function getCartItemService()
    {
        if (! $this->cartItemService instanceof Item) {
            $sl = $this->getServiceLocator();
            $this->cartItemService = $sl->get('Shop\Service\CartItem');
        }
        
        return $this->cartItemService;
    }

    /**
     *
     * @return CartCookie $cartCookieService
     */
    public function getCartCookieService()
    {
        if (! $this->cartCookieService instanceof CartCookie) {
            $sl = $this->getServiceLocator();
            $this->cartCookieService = $sl->get('Shop\Service\CartCookie');
        }
        
        return $this->cartCookieService;
    }
}
