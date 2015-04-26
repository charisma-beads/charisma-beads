<?php
namespace Shop\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class Advert extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'advert'];
    protected $serviceName = 'ShopAdvert';
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