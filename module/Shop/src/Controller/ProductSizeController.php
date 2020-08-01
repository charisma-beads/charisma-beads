<?php

namespace Shop\Controller;


use Shop\Service\ProductSizeService;
use Shop\ShopException;
use Common\Controller\AbstractCrudController;
use Laminas\View\Model\ViewModel;

/**
 * Class ProductSize
 *
 * @package Shop\Controller
 */
class ProductSizeController extends AbstractCrudController
{
    protected $serviceName = ProductSizeService::class;
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