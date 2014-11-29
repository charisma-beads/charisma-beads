<?php
namespace Shop\Service\Cart;

use Shop\Service\StockControl;
use UthandoCommon\Model\CollectionException;
use Shop\Model\Cart\Cart as CartModel;
use Shop\Model\Cart\Item as CartItem;
use Shop\Model\Product\Product as ProductModel;
use Shop\Model\Product\MetaData as ProductMetaData;
use Shop\Service\Cart\Cookie as CartCookie;
use Shop\Service\Shipping;
use Shop\Service\Tax\Tax;
use UthandoCommon\Service\AbstractMapperService;
use Zend\Session\Container;
use Zend\Stdlib\InitializableInterface;

class Cart extends AbstractMapperService implements InitializableInterface
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCart';

    /**
     * @var Container
     */
    protected $container;
    
    /**
     * @var Shipping
     */
    protected $shippingService;

    /**
     * @var Tax
     */
    protected $taxService;

    /**
     *
     * @var Item
     */
    protected $cartItemService;

    /**
     * @var CartCookie
     */
    protected $cartCookieService;

    /**
     * @var CartModel
     */
    protected $cart;

    /**
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
     * Total shipping tax
     * 
     * @var float
     */
    protected $shippingTax = 0;
    
    /**
     * Total of tax
     *
     * @var float
     */
    protected $taxTotal = 0;

    /**
     * Attach events
     */
    public function attachEvents()
    {
        /* @var $stockControl StockControl */
        $stockControl = $this->getServiceLocator()->get('Shop\Service\StockControl');

        $this->getEventManager()->attach('stock.check', [$stockControl, 'check']);
        $this->getEventManager()->attach('stock.restore', [$stockControl, 'restore']);
    }

    /**
     * @throws CollectionException
     */
    public function init()
    {
        if ($this->isInitialized) {
            return;
        }

        $cart = null;
        
        // check first if there is a cartId in the session data,
        // else try to retrieve the cartId from cookie verifier.
        /** @noinspection PhpUndefinedFieldInspection */
        if (isset($this->getContainer()->cartId)) {
            /** @noinspection PhpUndefinedFieldInspection */
            $cartId = $this->getContainer()->cartId;
            /* @var $cartMapper \Shop\Mapper\Cart\Cart */
            $cartMapper = $this->getMapper();
            $cart = $cartMapper->getCartById($cartId);


        } else {
            $verifier = $this->getCartCookieService()
                ->retrieveCartVerifierCookie();
            
            if ($verifier) {
                $cart = $this->getCartByVerifier($verifier);
            }
        }

        // load any cart items
        if ($cart) {
            $cart = $this->loadCartItems($cart);
        }
        
        $this->setCart($cart);
        $this->isInitialized = true;
    }

    /**
     * @param CartModel $cart
     * @return CartModel
     * @throws CollectionException
     */
    public function loadCartItems(CartModel $cart)
    {
        $itemsService = $this->getCartItemService();
        $items = $itemsService->getCartItemsByCartId($cart->getCartId());

        /* @var $item \Shop\Model\Cart\Item */
        foreach ($items as $item) {
            $cart->offsetSet(
                $item->getMetadata()->getProductId(),
                $item
            );
        }

        return $cart;
    }

    /**
     * @param $verifier
     * @return CartModel
     */
    public function getCartByVerifier($verifier)
    {
        $verifier = (string) $verifier;
        /* @var $cartMapper \Shop\Mapper\Cart\Cart */
        $cartMapper = $this->getMapper();
        $cart = $cartMapper->getCartByVerifier($verifier);
        
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
        if (0 > $qty) {
            return false;
        }
        
        $cart = $this->getCart();

        /** @var $cartItem \Shop\Model\Cart\Item */
        $cartItem = ($cart->offsetExists($product->getProductId())) ? $cart->offsetGet($product->getProductId()) : new CartItem();

        $argv = compact('product', 'qty', 'cartItem');
        $argv = $this->prepareEventArguments($argv);

        $this->getEventManager()->trigger('stock.check', $this, $argv);

        $qty = $argv['qty'];
        
        if (0 == $qty) {
            $this->removeItem($cartItem->getCartItemId());
            return false;
        }
        
        $cartItem->setPrice($product->getPrice())
            ->setQuantity($qty)
            ->setTax($product->getTaxCode()->getTaxRate()->getTaxRate())
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
            ->setCategory($product->getProductCategory()->getCategory())
            ->setDescription($product->getShortDescription())
            ->setTaxable($product->getTaxable())
            ->setVatInc($product->getVatInc())
            ->setAddPostage($product->getAddPostage())
            ->setPostUnit($product->getPostUnit()->getPostUnit())
            ->setImage($product->getDefaultImage());
        
        return $metadata;
    }

    /**
     * Remove an item for the shopping cart
     *
     * @param $id
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
     * @param Container $ns
     */
    public function setContainer(Container $ns)
    {
        $this->container = $ns;
    }

    /**
     * @return Container
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
     * the database, then set a cookie for persistence after
     * session has been expired.
     */
    public function persist()
    {
        $cart = $this->getCart();
        $cart->setDateModified();
        
        $this->save($cart);
        
        /* @var $cartItem \Shop\Model\Cart\Item */
        foreach ($cart as $cartItem) {
            $this->getCartItemService()->save($cartItem);
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $this->getContainer()->cartId = $cart->getCartId();
    }

    /**
     * @return CartModel
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     *
     * @param CartModel $cart            
     */
    public function setCart($cart = null)
    {
        if (!$cart instanceof CartModel) {
            /* @var $cart \Shop\Model\Cart\Cart */
            $cart = $this->getModel();
            $cart->setExpires($this->getCartCookieService()->getCookieConfig()->getExpiry())
                ->setVerifyId($this->getCartCookieService()->setCartVerifierCookie());
            $cartId = $this->save($cart);
            $cart->setCartId($cartId);
            /** @noinspection PhpUndefinedFieldInspection */
            $this->getContainer()->cartId = $cartId;
        }
        
        $this->cart = $cart;
    }

    /**
     * calculates the item line price
     *
     * @param CartItem $item            
     * @return number
     */
    public function getLineCost(CartItem $item)
    {
        $price = $item->getPrice();
        $tax = 0;
        
        if (true === $item->getMetadata()->getTaxable()) {
            $taxService = $this->getTaxService()
                ->setTaxState($this->getShopOptions()->getVatState())
                ->setTaxInc($item->getMetadata()->getVatInc());
            $taxService->addTax($price, $item->getTax(true));
            
            $price = $taxService->getPrice();
            $tax = $taxService->getTax();
            
            $this->taxTotal += $tax * $item->getQuantity();
        }
        
        $price = ($item->getMetadata()->getVatInc()) ? $price + $tax : $price;
        
        return $price * $item->getQuantity();
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
     * @param null $countryId
     * @return $this
     */
    public function setShippingCost($countryId = null)
    {
        if ($countryId) {
            $countryId = (int) $countryId;
            $shipping = $this->getShippingService();
            $shipping->setCountryId($countryId);
        
            $cost = $shipping->calculateShipping($this);
        
            $this->shippingTax = $shipping->getShippingTax();
        } else {
            $cost = 0;
            $this->shippingTax = 0;
        }
        
        $this->shipping = $cost;
        
        return $this;
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
     * Get the tax total
     * 
     * @return float
     */
    public function getTaxTotal()
    {
        $this->calculateTotals();
        return $this->taxTotal + $this->shippingTax;
    }

    /**
     * Clear old, forgotten and abandoned shopping carts.
     *
     * @return int
     */
    public function clearExpired()
    {
        /* @var $cartMapper \Shop\Mapper\Cart\Cart */
        $cartMapper = $this->getMapper();
        /* @var $cartCookie \Shop\Options\CartCookieOptions */
        $cartCookie = $this->getService('Shop\Options\CartCookie');
        $expiry = $cartCookie->getExpiry();

        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $expiry  = $timestamp - $expiry;
        $date->setTimestamp($expiry);
        // TODO: add date format to shop options.
        $expiryDate = $date->format('Y-m-d H:i:s');

        $carts = $this->getMapper()->getExpiredCarts($expiryDate);

        if ($carts->count() == 0) {
            return 0;
        }

        foreach ($carts as $cart) {
            $this->loadCartItems($cart);
        }

        $ids = [];
        $argv = compact('carts', 'ids');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('stock.restore', $this, $argv);
        $ids = $argv['ids'];

        return $cartMapper->deleteCartsByIds($ids);

    }

    /**
     * @return array|object
     */
    public function getShopOptions()
    {
        return $this->getServiceLocator()->get('Shop\Options\Shop');
    }

    /**
     * @return Shipping
     */
    protected function getShippingService()
    {
        if (!$this->shippingService instanceof Shipping) {
            $this->shippingService = $this->getServiceLocator()
                ->get('Shop\Service\Shipping');
        }
         
        return $this->shippingService;
    }

    /**
     * @return Tax
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
     * @return Item
     */
    public function getCartItemService()
    {
        if (! $this->cartItemService instanceof Item) {
            $sl = $this->getServiceLocator();
            $this->cartItemService = $sl->get('Shop\Service\Cart\Item');
        }
        
        return $this->cartItemService;
    }

    /**
     * @return CartCookie
     */
    public function getCartCookieService()
    {
        if (! $this->cartCookieService instanceof CartCookie) {
            $sl = $this->getServiceLocator();
            $this->cartCookieService = $sl->get('Shop\Service\Cart\Cookie');
        }
        
        return $this->cartCookieService;
    }
}
