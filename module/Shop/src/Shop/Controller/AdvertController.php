<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Shop\Service\AdvertService;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

/**
 * Class Advert
 *
 * @package Shop\Controller
 */
class AdvertController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'advert'];
    protected $serviceName = AdvertService::class;
    protected $route = 'admin/shop/advert';
    
    public function statsAction()
    {
        $data = $this->getService()->getStats();
        
        $viewModel = new ViewModel([
            'stats' => $data,
        ]);
        $viewModel->setTerminal(true);

        return $viewModel;
    }
}