<?php

namespace Shop\View;

use Shop\Options\ShopOptions;
use Common\View\AbstractViewHelper;

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
            ->get(ShopOptions::class);
        
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
