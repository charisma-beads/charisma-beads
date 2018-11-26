<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Shop\Service\ProductImageService;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
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
