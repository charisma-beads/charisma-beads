<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\View;

use Shop\Form\CartAddFrom;
use Shop\Model\CartModel as CartModel;
use UthandoCommon\Service\ServiceManager;
use UthandoCommon\View\AbstractViewHelper;
use Zend\I18n\View\Helper\CurrencyFormat;
use Shop\Service\CartService;
use Zend\View\Model\ViewModel;

/**
 * Class Cart
 *
 * @package Shop\View
 */
class Cart extends AbstractViewHelper
{
    /**
     * @var \Shop\Service\CartService
     */
    protected $cartService;

    /**
     * @var CurrencyFormat
     */
    protected $currencyHelper;

    /**
     * @return $this
     */
    public function __invoke()
    {
        if (!$this->cartService instanceof CartService) {
            $this->cartService = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ServiceManager::class)
                ->get(CartService::class);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function countItems()
    {
        $count = 0;

        if ($this->getCart() instanceof CartModel) {
            $count = $this->getCart()
                ->count();
        }

        return $count;
    }

    /**
     * @return CartModel
     */
    public function getCart()
    {
        return $this->cartService->getCart();
    }

    /**
     * @param $template
     * @return string
     */
    public function getSummary($template)
    {
        $view = new ViewModel();
        $view->setTemplate($template);

        return $this->getView()->render($view);
    }

    /**
     * @param $item
     * @return string
     */
    public function getLineCost($item)
    {
        $amount = $this->cartService->getLineCost($item);
        //$amount = $priceTax['price'] + $priceTax['tax'];
        return $this->formatAmount($amount);
    }

    public function getLineTax($item)
    {
        $amount = $this->cartService->calculateTax($item);
        return $this->formatAmount($amount['tax']);
    }

    /**
     * @param $amount
     * @return string
     */
    public function formatAmount($amount)
    {
        $currency = $this->getCurrencyHelper();
        return $currency($amount);
    }

    /**
     * @return CurrencyFormat
     */
    protected function getCurrencyHelper()
    {
        if (!$this->currencyHelper instanceof CurrencyFormat) {
            $this->currencyHelper = $this->view->plugin('currencyFormat')
                ->setCurrencyCode("GBP")->setLocale("en_GB");
        }

        return $this->currencyHelper;
    }

    /**
     * @return string
     */
    public function getDiscount()
    {
        $amount = $this->getCart()->getDiscount();
        return $this->formatAmount(-$amount);
    }

    /**
     * @return string
     */
    public function getSubTotal()
    {
        $amount = $this->cartService->getSubTotal();
        return $this->formatAmount($amount);
    }

    /**
     * @return string
     */
    public function getTotal()
    {
        $amount = $this->cartService->getTotal();
        return $this->formatAmount($amount);
    }

    /**
     * @return string
     */
    public function getTaxTotal()
    {
        $tax = $this->cartService->getTaxTotal();
        return $this->formatAmount($tax);
    }

    /**
     * @param $countryId
     * @return string
     */
    public function getShippingTotal($countryId)
    {
        $this->cartService->setShippingCost($countryId);
        return $this->formatAmount($this->cartService->getShippingCost());
    }

    /**
     * @param $product
     * @return string
     */
    public function hasProductInCart($product)
    {
        $items = $this->getCart()->getEntities();
        $numItems = null;

        foreach ($items as $item) {
            if ($item->getMetaData()->getProductId() == $product->getProductId()) {
                $numItems += $item->getQuantity();
            }
        }

        if ($numItems) {
            return '&nbsp;(' . $numItems . ')';
        }

        return '';
    }

    /**
     * @param $product
     * @return CartAddFrom
     */
    public function addForm($product)
    {
        $fm = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('FormElementManager');
        $form = $fm->get(CartAddFrom::class);

        $form->setData(array(
            'productId' => $product->getProductId(),
            'returnTo' => $this->view->serverUrl(true)
        ));

        $form->setAttributes(array(
            'action' => $this->view->url('shop/cart', [
                'action' => 'add'
            ]),
            'class' => 'form-search'
        ));

        return $form;
    }

    /**
     * @return string|null
     */
    public function getVoucherCode()
    {
        $container = $this->cartService->getContainer();
        return $container->offsetGet('voucher');
    }
}
