<?php
namespace Shop\View;

use UthandoCommon\View\AbstractViewHelper;
use Shop\ShopException;
use Shop\Options\ShopOptions;

class ShopOption extends AbstractViewHelper
{
    /**
     * @var ShopOptions
     */
    protected $shopOptions;

    /**
     * @param null $key
     * @return $this|Config|string
     */
    public function __invoke($key=null)
    {
        if (!$this->shopOptions instanceof ShopOptions) {
            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('Shop\Options\Shop');
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
