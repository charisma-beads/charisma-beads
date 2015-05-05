<?php
namespace Shop\View;

use UthandoCommon\View\AbstractViewHelper;
use Shop\ShopException;
use Shop\Options\CheckoutOptions;

class CheckoutOption extends AbstractViewHelper
{
    /**
     * @var CheckoutOptions
     */
    protected $checkoutOptions;

    /**
     * @param null $key
     * @return $this|Config|string
     */
    public function __invoke($key=null)
    {
        if (!$this->checkoutOptions instanceof CheckoutOptions) {
            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('Shop\Options\Checkout');
            $this->checkoutOptions = $service;
        }
        
        if (is_string($key) && isset($this->checkoutOptions->$key)) {
            return $this->checkoutOptions->$key;
        } else {
            throw new ShopException('option ' . $key . ' does not exist.');
        }

        return $this->checkoutOptions;
    }
}
