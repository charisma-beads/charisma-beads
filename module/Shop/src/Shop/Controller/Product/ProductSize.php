<?php

namespace Shop\Controller\Product;

use Shop\ShopException;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class ProductSize extends AbstractCrudController
{
    protected $serviceName = 'ShopProductSize';
    protected $route = 'admin/shop/product/size';

    public function sizeListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Not Allowed');
        }

        $sizes = $this->getService()->fetchAll();

        $viewModel = new ViewModel([
            'models' => $sizes,
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }
} 