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
