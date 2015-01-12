<?php
namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class ProductImage extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'productImageId');
	protected $serviceName = 'ShopProductImage';
	protected $route = 'admin/shop/product/image';
    protected $paginate = false;

    public function imageListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Not Allowed');
        }

        $productId = $this->params()->fromPost('productId', 0);

        /* @var $service \Shop\Service\Product\Image */
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
