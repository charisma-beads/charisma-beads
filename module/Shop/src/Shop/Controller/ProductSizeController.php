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


use Shop\Service\ProductSizeService;
use Shop\ShopException;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

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