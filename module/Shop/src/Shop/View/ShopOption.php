<?php

namespace Shop\View;

use Common\View\AbstractViewHelper;
use Shop\ShopException;
use Shop\Options\ShopOptions;

/**
 * Class ShopOption
 *
 * @package Shop\View
 */
class ShopOption extends AbstractViewHelper
{
    /**
     * @var ShopOptions
     */
    protected $shopOptions;

    /**
     * @param null $key
     * @return mixed|ShopOptions
     * @throws ShopException
     */
    public function __invoke($key=null)
    {
        if (!$this->shopOptions instanceof ShopOptions) {
            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ShopOptions::class);
            $this->shopOptions = $service;
        }
        
        if (is_string($key) && isset($this->shopOptions->$key)) {
            return $this->shopOptions->$key;
        } else {
            throw new ShopException('option ' . $key . ' does not exist.');
        }

        return $this->shopOptions;
    }
}
