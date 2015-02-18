<?php
namespace Shop\Controller\Product;

use Shop\ShopException;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class ProductOption extends AbstractCrudController
{
    protected $serviceName = 'ShopProductOption';
    protected $route = 'admin/shop/product/option';
    protected $paginate = false;

    public function optionListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Not Allowed');
        }

        $productId = $this->params()->fromPost('productId', 0);

        /* @var $service \Shop\Service\Product\Option */
        $service = $this->getService();

        $options = $service->getOptionsByProductId($productId);

        $viewModel = new ViewModel([
            'models' => $options,
            'productId' => $productId,
        ]);

        $viewModel->setTerminal(true);
        $viewModel->setTemplate('shop/product-option/list');

        return $viewModel;
    }
} 