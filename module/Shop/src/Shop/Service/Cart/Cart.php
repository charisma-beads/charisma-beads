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
use Shop\Model\Product\Option as ProductOption;
use Shop\Model\Product\Product as ProductModel;
use Shop\Model\Order\LineInterface;
use Shop\Options\CartCookieOptions;
use Shop\Service\Cart\Cookie as CartCookie;
use Shop\Service\Product\Product as ProductService;
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
     * @throws \UthandoCommon\Service\ServiceException
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

    public function setMessages($message)
    {
        $messages = $this->getContainer()->offsetGet('messages') ?? [];
        $messages[] = $message;
        $this->getContainer()->offsetSet('messages', $messages);
    }

    public function getMessages()
    {
        $messages = $this->getContainer()->offsetGet('messages');
        $this->getContainer()->offsetSet('messages', []);
        return $messages;
    }

    /**
     * Adds items contained with the order collection
     *
     * @param ProductModel $product
     * @param array $post
     * @return LineInterface|bool
     * @throws CollectionException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function addItem(ProductModel $product, $post)
    {
        $qty = $post['qty'];

        if ($qty <= 0 || $product->inStock() === false || $product->isDiscontinued() === true || $product->isEnabled() === false) {
            return false;
        }

        $productClone = clone $product;

        $productId = $productClone->getProductId();
        $optionId = (isset($post['ProductOptionList'])) ? (int) substr(strrchr($post['ProductOptionList'], "-"), 1) : null;

        $productOption = ($optionId) ? $product->getProductOption($optionId) : null;

        if ($productOption instanceof ProductOption) {
            $productClone->setPostUnitId($productOption->getPostUnitId())
                ->setPostUnit($productOption->getPostUnit())
                ->setPrice($productOption->getPrice(false))
                ->setDiscountPercent($productOption->getDiscountPercent());
            $productId = $productId . '-' . $optionId;
        }

        $model = $this->getOrderModel();
        $lineModel = $model->getEntityClass();

        /** @var $line LineInterface */
        $line = ($model->offsetExists($productId)) ? $model->offsetGet($productId) : new $lineModel();

        if ($model->isAutoIncrementQuantity()) {
            $qty = $qty + $line->getQuantity();
        }

        $argv = compact('product', 'qty', 'line');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('cart.stock.check', $this, $argv);

        $qty = $argv['qty'];

        if ($argv['message']) {
            $this->setMessages($argv['message']);
        }

        if (0 == $qty) {
            $this->removeItem($line->getId());
            return false;
        }

        $line->setPrice($productClone->getPrice())
            ->setQuantity($qty)
            ->setTax($productClone->getTaxCode()->getTaxRate()->getTaxRate())
            ->setMetadata($this->getProductMetaData($productClone, $optionId))
            ->setParentId($model->getId());

        $model->offsetSet($productId, $line);

        $this->persist($line);

        //$this->getEventManager()->trigger('stock.save', $this, $argv);

        return $line;
    }

    /**
     * Updates order items.
     *
     * @param array $items
     * @throws CollectionException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function updateItem(array $items)
    {
        $orderModel = $this->getOrderModel();

        foreach ($items as $lineItemId => $qty) {

            $line = $orderModel->getLineById($lineItemId);

            if (!$line || $qty < 0) continue;

            if ($qty == 0) {
                $this->removeItem($lineItemId);
            } else {

                /* @var $productService ProductService */
                $productService = $this->getService('ShopProduct');
                $product = $productService->getById($line->getMetadata()->getProductId());

                $argv = compact('product', 'qty', 'line');
                $argv = $this->prepareEventArguments($argv);

                $this->getEventManager()->trigger('cart.stock.check', $this, $argv);

                $qty = $argv['qty'];

                if ($argv['message']) {
                    $this->setMessages($argv['message']);
                }

                $line->setQuantity($qty);

                $offsetKey = $line->getMetadata()->getProductId();

                // check for option
                if ($line->getMetadata()->getOption() instanceof ProductOption) {
                    $offsetKey = join('-', [
                        $offsetKey,
                        $line->getMetadata()->getOption()->getProductOptionId()
                    ]);
                }

                $orderModel->offsetSet($offsetKey, $line);

                //$this->getEventManager()->trigger('stock.save', $this, $argv);
            }
        }

        $this->persist();
    }

    public function checkStock()
    {
        $cart = $this->getOrderModel();

        /** @var CartItem $line */
        foreach ($cart as $line) {
            /* @var $productService ProductService */
            $productService = $this->getService('ShopProduct');
            $product = $productService->getById($line->getMetadata()->getProductId());

            // if product is non stock item go to next item
            if ($product->getQuantity() < 0) continue;

            if ($product->getQuantity() < $line->getQuantity()) {
                $this->setMessages(
                    sprintf(
                        'You asked for %s x %s, only %s are available. Your request has been reduced by %s',
                        $line->getQuantity(),
                        $product->getSku(),
                        $product->getQuantity(),
                        $line->getQuantity() - $product->getQuantity()
                    )
                );
                $line->setQuantity($product->getQuantity());
            }

            $offsetKey = $line->getMetadata()->getProductId();

            // check for option
            if ($line->getMetadata()->getOption() instanceof ProductOption) {
                $offsetKey = join('-', [
                    $offsetKey,
                    $line->getMetadata()->getOption()->getProductOptionId()
                ]);
            }

            $cart->offsetSet($offsetKey, $line);
        }

        $this->persist();
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

        /*if ($restoreStock) {
            $argv = compact('model');
            $argv = $this->prepareEventArguments($argv);

            $this->getEventManager()->trigger('stock.restore.one', $this, $argv);
        }*/

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
     *
     * @param LineInterface $item
     * @return mixed|void
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function persist(LineInterface $item = null)
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

        $ids = [];

        /* @var $cart CartModel */
        foreach ($models as $cart) {
            //$this->loadItems($cart);
            $ids[] = $cart->getId();
        }

        /*$argv = compact('models');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('stock.restore.many', $this, $argv);
        $ids = $argv['ids'];*/

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
