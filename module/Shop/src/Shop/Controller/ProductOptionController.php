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

use Shop\Service\ProductOptionService;
use Shop\ShopException;
use Common\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

/**
 * Class ProductOption
 *
 * @package Shop\Controller
 */
class ProductOptionController extends AbstractCrudController
{
    protected $serviceName = ProductOptionService::class;
    protected $route = 'admin/shop/product/option';
    protected $paginate = false;

    public function optionListAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Not Allowed');
        }

        $productId = $this->params()->fromPost('productId', 0);

        /* @var $service \Shop\Service\ProductOptionService */
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