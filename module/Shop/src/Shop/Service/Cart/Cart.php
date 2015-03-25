<?php
namespace Shop\Service\Cart;

use Shop\Mapper\Cart\Cart as CartMapper;
use Shop\Model\Cart\Cart as CartModel;
use Shop\Model\Cart\Item as CartItem;
use Shop\Model\Product\Product as ProductModel;
use Shop\Model\Product\MetaData as ProductMetaData;
use Shop\Options\CartCookieOptions;
use Shop\Service\Cart\Cookie as CartCookie;
use Shop\Service\Shipping;
use Shop\Service\StockControl;
use Shop\Service\Tax\Tax;
use UthandoCommon\Model\CollectionException;
use UthandoCommon\Service\AbstractMapperService;
use Zend\Session\Container;
use Zend\Stdlib\InitializableInterface;
use Shop\Model\Product\Option as ProductOption;

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
        $stockControl = $this->getService('Shop\Service\StockControl');

        $this->getEventManager()->attach([
            'stock.check',
            'stock.save',
            'stock.restore',
            'stock.restore.cart',
            'stock.restore.carts'
        ], [$stockControl, 'init']);
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
        if ($this->getContainer()->offsetExists('cartId')) {
            $cartId = $this->getContainer()->offsetGet('cartId');
            /* @var $cartMapper CartMapper */
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

        /* @var $item CartItem */
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
        /* @var $cartMapper CartMapper */
        $cartMapper = $this->getMapper();
        $cart = $cartMapper->getCartByVerifier($verifier);
        
        return $cart;
    }
    
    /**
     * Checks if cart has any items.
     * 
     * @return boolean
     */
    public function hasItems()
    {
        $cart = $this->getCart();
        
        if ($cart->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adds or updates an item contained with the shopping cart
     *
     * @param ProductModel $product            
     * @param array $post           
     * @return CartItem
     */
    public function addItem(ProductModel $product, $post)
    {
        $qty = $post['qty'];
        
        if (0 > $qty || $product->inStock() === false) {
            return false;
        }
        
        $productClone = clone $product;
        
        $optionId = (isset($post['ProductOptionList'])) ? (int) substr(strrchr($post['ProductOptionList'], "-"), 1) : null;
        
        $productOption = ($optionId) ? $product->getProductOption($optionId) : null;
        
        if ($productOption instanceof ProductOption) {
            $productClone->setPostUnitId($productOption->getPostUnitId())
                ->setPostUnit($productOption->getPostUnit())
                ->setPrice($productOption->getPrice())
                ->setDiscountPercent($productOption->getDiscountPercent());
        }
        
        $cart = $this->getCart();

        /** @var $cartItem CartItem */
        $cartItem = ($cart->offsetExists($productClone->getProductId())) ? $cart->offsetGet($productClone->getProductId()) : new CartItem();

        $argv = compact('product', 'qty', 'cartItem');
        $argv = $this->prepareEventArguments($argv);

        $this->getEventManager()->trigger('stock.check', $this, $argv);

        $qty = $argv['qty'];
        
        if (0 == $qty) {
            $this->removeItem($cartItem->getCartItemId());
            return false;
        }

        $cartItem->setPrice($productClone->getPrice())
            ->setQuantity($qty)
            ->setTax($productClone->getTaxCode()->getTaxRate()->getTaxRate())
            ->setMetadata($this->getProductMetaData($productClone, $optionId))
            ->setCartId($this->getCart()->getCartId());
        
        $cart->offsetSet($productClone->getProductId(), $cartItem);
        
        $this->persist();

        $this->getEventManager()->trigger('stock.save', $this, $argv);
        
        return $cartItem;
    }

    /**
     * @param ProductModel $product
     * @param int $optionId
     * @return \Shop\Model\Product\MetaData
     */
    public function getProductMetaData(ProductModel $product, $optionId)
    {
        $metadata = new ProductMetaData();
        
        $metadata->setProductId($product->getProductId())
            ->setSku($product->getSku())
            ->setName($product->getName())
            ->setCategory($product->getProductCategory()->getCategory())
            ->setDescription($product->getShortDescription())
            ->setTaxable($product->getTaxable())
            ->setVatInc($product->getVatInc())
            ->setAddPostage($product->getAddPostage())
            ->setPostUnit($product->getPostUnit()->getPostUnit())
            ->setImage($product->getDefaultImage());
        
        if ($optionId) {
            $metadata->setOption($product->getProductOption($optionId));
        }
        
        return $metadata;
    }

    /**
     * Remove an item for the shopping cart
     *
     * @param $id
     */
    public function removeItem($id)
    {
        $cartItem = $this->getCartItemService()->getById($id);;

        $argv = compact('cartItem');
        $argv = $this->prepareEventArguments($argv);

        $this->getEventManager()->trigger('stock.restore', $this, $argv);
        $this->getCartItemService()->delete($id);
    }

    /**
     * clears shopping cart of all items
     * @param bool $restoreStock
     */
    public function clear($restoreStock = true)
    {
        $cart = $this->getCart();

        if ($restoreStock) {
            $argv = compact('cart');
            $argv = $this->prepareEventArguments($argv);

            $this->getEventManager()->trigger('stock.restore.cart', $this, $argv);
        }

        $cart->clear();
        $this->delete($cart->getCartId());
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
        
        /* @var $cartItem CartItem */
        foreach ($cart as $cartItem) {
            $this->getCartItemService()->save($cartItem);
        }

        $this->getContainer()->offsetSet('cartId', $cart->getCartId());
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
            /* @var $cart CartModel */
            $cart = $this->getModel();
            $cart->setExpires($this->getCartCookieService()->getCookieConfig()->getExpiry())
                ->setVerifyId($this->getCartCookieService()->setCartVerifierCookie());
            $cartId = $this->save($cart);
            $cart->setCartId($cartId);

            $this->getContainer()->offsetSet('cartId', $cartId);
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

        if (true === $this->getShopOptions()->getVatState()) {
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
        
            $this->setShippingTax($shipping->getShippingTax());
        } else {
            $cost = 0;
            $this->setShippingTax(0);
        }
        
        $this->shipping = $cost;
        
        return $this;
    }

    /**
     * @return float
     */
    public function getShippingTax()
    {
        return $this->shippingTax;
    }

    /**
     * @param float $shippingTax
     * @return $this
     */
    public function setShippingTax($shippingTax)
    {
        $this->shippingTax = $shippingTax;
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
        /* @var $cartMapper CartMapper */
        $cartMapper = $this->getMapper();
        /* @var $cartCookie CartCookieOptions */
        $cartCookie = $this->getService('Shop\Options\CartCookie');
        $expiry = $cartCookie->getExpiry();

        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $expiry  = $timestamp - $expiry;
        $date->setTimestamp($expiry);
        // TODO: add date format to shop options.
        $expiryDate = $date->format('Y-m-d H:i:s');

        $carts = $cartMapper->getExpiredCarts($expiryDate);

        if ($carts->count() == 0) {
            return 0;
        }

        /* @var $cart CartModel */
        foreach ($carts as $cart) {
            $this->loadCartItems($cart);
        }

        $argv = compact('carts');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('stock.restore.carts', $this, $argv);
        $ids = $argv['ids'];

        return $cartMapper->deleteCartsByIds($ids);

    }

    /**
     * @return \Shop\Options\ShopOptions
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
            $this->cartItemService = $sl->get('ShopCartItem');
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
