<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Service\Cart;

use Shop\Mapper\Cart\Cart as CartMapper;
use Shop\Model\Cart\Cart as CartModel;
use Shop\Model\Cart\Item as CartItem;
use Shop\Model\Order\LineInterface;
use Shop\Options\CartCookieOptions;
use Shop\Service\Cart\Cookie as CartCookie;
use Shop\Service\Order\AbstractOrder;
use UthandoCommon\Model\CollectionException;
use Zend\Session\Container;
use Zend\Stdlib\InitializableInterface;

/**
 * Class Cart
 *
 * @package Shop\Service\Cart
 * @method CartModel getOrderModel()
 */
class Cart extends AbstractOrder implements InitializableInterface
{
    protected $cart;

    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCart';

    /**
     * @var string
     */
    protected $lineService = 'CartItem';

    /**
     * @var Container
     */
    protected $container;

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
     * @var boolean
     */
    protected $isInitialized = false;

    /**
     * @var array
     */
    protected $referenceMap = [
        'CartItem'    => [
            'refCol'        => 'cartId',
            'service'       => 'ShopCartItem',
            'getMethod'     => 'getCartItemsByCartId',
            'setMethod'     => 'setEntities',
        ],
    ];

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
        // if no cart then retrieve empty cart object
        if ($cart instanceof CartModel) {
            $cart = $this->loadItems($cart);

            $options = $this->getShopOptions();

            $cart->setSortOrder($options->getProductsOrderCol());
        } else {
            $cart = $this->getModel();
        }

        $cart->setAutoIncrementQuantity(
            $this->getCartOptions()->isAutoIncrementCart()
        );
        
        $this->setCart($cart);
        $this->calculateTotals();
        $this->isInitialized = true;
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
     * clears shopping cart of all items
     * @param bool $restoreStock
     */
    public function clear($restoreStock = true)
    {
        $model = $this->getCart();

        if ($restoreStock) {
            $argv = compact('model');
            $argv = $this->prepareEventArguments($argv);

            $this->getEventManager()->trigger('stock.restore.one', $this, $argv);
        }

        $model->clear();
        $this->delete($model->getCartId());
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
            $this->setContainer(new Container($this->serviceAlias));
        }
        
        return $this->container;
    }

    /**
     * Persist the cart data in the session and in
     * the database, then set a cookie for persistence after
     * session has been expired.
     * @param CartItem $item
     * @return mixed|void
     */
    public function persist(LineInterface $item)
    {
        $cart = $this->getCart();
        $cart->setDateModified();

        if (null === $cart->getVerifyId()) {
            $cart->setExpires($this->getCartCookieService()->getCookieConfig()->getExpiry())
                ->setVerifyId($this->getCartCookieService()->setCartVerifierCookie());
        }
        
        $cartId = $this->save($cart);

        if (null === $cart->getCartId()) {
            $cart->setCartId($cartId);
        }
        
        /* @var $cartItem CartItem */
        foreach ($cart as $cartItem) {
            if (null === $cartItem->getCartId()) {
                $cartItem->setCartId($cart->getCartId());
            }

            $this->getRelatedService($this->lineService)->save($cartItem);
        }

        $this->getContainer()->offsetSet('cartId', $cart->getCartId());
    }

    /**
     * @return CartModel
     */
    public function getCart()
    {
        return $this->getOrderModel();
    }

    /**
     *
     * @param CartModel|null $cart
     * @return $this
     */
    public function setCart($cart = null)
    {
        return $this->setOrderModel($cart);
    }

    /**
     * Set the shipping cost
     *
     * @param null $countryId
     * @param bool $shippingOff
     * @return $this
     */
    public function setShippingCost($countryId = null, $shippingOff = false)
    {
        if (!$shippingOff && null === $countryId) {
            $countryId = $this->getContainer()->offsetGet('countryId');
        }

        parent::setShippingCost($countryId);
        return $this;
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

        $models = $cartMapper->getExpiredCarts($expiryDate);

        if ($models->count() == 0) {
            return 0;
        }

        /* @var $cart CartModel */
        foreach ($models as $cart) {
            $this->loadCartItems($cart);
        }

        $argv = compact('models');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('stock.restore.many', $this, $argv);
        $ids = $argv['ids'];

        return $cartMapper->deleteCartsByIds($ids);

    }

    /**
     * @return \Shop\Options\CartOptions
     */
    public function getCartOptions()
    {
        return $this->getServiceLocator()->get('Shop\Options\Cart');
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
