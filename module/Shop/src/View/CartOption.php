<?php

namespace Shop\View;

use Common\View\AbstractViewHelper;
use Shop\ShopException;
use Shop\Options\CartOptions;

/**
 * Class CartOption
 *
 * @package Shop\View
 */
class CartOption extends AbstractViewHelper
{
    /**
     * @var CartOptions
     */
    protected $cartOptions;

    /**
     * @param null $key
     * @return mixed|CartOptions
     * @throws ShopException
     */
    public function __invoke($key=null)
    {
        if (!$this->cartOptions instanceof CartOptions) {
            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(CartOptions::class);
            $this->cartOptions = $service;
        }
        
        if (is_string($key) && isset($this->cartOptions->$key)) {
            return $this->cartOptions->$key;
        } else {
            throw new ShopException('option ' . $key . ' does not exist.');
        }
    }
}
