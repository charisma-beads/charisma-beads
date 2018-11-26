<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use UthandoCommon\View\AbstractViewHelper;
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
