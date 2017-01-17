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

/**
 * Class Alert
 *
 * @package Shop\View
 */
class Alert extends AbstractViewHelper
{
    /**
     * @var \Shop\Options\ShopOptions
     */
    protected $shopOptions;
    
    public function __invoke()
    {
        $this->shopOptions = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Shop\Options\Shop');
        
        return $this->renderAlert();
    }
    
    public function renderAlert()
    {
       $enabled = (bool) $this->shopOptions->getAlert();
       
       if (true === $enabled) {
           $alertHelper = $this->view->plugin('alert');
           $message = $this->shopOptions->getAlertText();
           return $alertHelper($message, ['class' => 'alert-info']);
       }
       
       return '';
    }
}
