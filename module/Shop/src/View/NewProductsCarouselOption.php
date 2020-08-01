<?php

namespace Shop\View;

use Common\View\AbstractViewHelper;
use Shop\ShopException;
use Shop\Options\NewProductsCarouselOptions;

/**
 * Class NewProductsCarouselOption
 *
 * @package Shop\View
 */
class NewProductsCarouselOption extends AbstractViewHelper
{
    /**
     * @var NewProductsCarouselOptions
     */
    protected $newProductsCarouselOptions;

    /**
     * @param null $key
     * @return mixed|NewProductsCarouselOption
     * @throws ShopException
     */
    public function __invoke($key=null)
    {
        if (!$this->newProductsCarouselOptions instanceof NewProductsCarouselOptions) {
            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(NewProductsCarouselOptions::class);
            $this->newProductsCarouselOptions = $service;
        }
        
        if (is_string($key) && isset($this->newProductsCarouselOptions->$key)) {
            return $this->newProductsCarouselOptions->$key;
        }

        return $this;
    }

    public function formatTitle()
    {
        $title = $this->newProductsCarouselOptions->getTitle();
        $title = explode(' ', $title);
        $title[0] = '<strong>' . $title[0] . '</strong>';
        $title = implode(' ', $title);

        return $title;
    }
}
