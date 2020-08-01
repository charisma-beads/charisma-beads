<?php

namespace Shop\Controller;

use Shop\Service\ProductImageService;
use Common\Controller\AbstractCrudController;
use Laminas\View\Model\ViewModel;
use Shop\ShopException;

/**
 * Class ProductImage
 *
 * @package Shop\Controller
 */
class ProductImageController extends AbstractCrudController
{
	protected $controllerSearchOverrides = array('sort' => 'productImageId');
	protected $serviceName = ProductImageService::class;
	protected $route = 'admin/shop/product/image';
    protected $paginate = false;

    public function imageListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Not Allowed');
        }

        $productId = $this->params()->fromPost('productId', 0);

        /* @var $service \Shop\Service\ProductImageService */
        $service = $this->getService();

        $options = $service->getImagesByProductId($productId);

        $viewModel = new ViewModel([
            'models' => $options,
            'productId' => $productId,
        ]);

        $viewModel->setTerminal(true);
        $viewModel->setTemplate('shop/product-image/list');

        return $viewModel;
    }
	
}
