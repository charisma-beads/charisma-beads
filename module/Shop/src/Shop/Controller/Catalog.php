<?php
namespace Shop\Controller;

use Shop\ShopException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Catalog extends AbstractActionController
{
    /**
     *
     * @var \Shop\Service\Product
     */
    protected $productService;

    /**
     *
     * @var \Shop\Service\ProductCategory
     */
    protected $productCategoryService;

    /**
     *
     * @var \Shop\Options\ShopOptions;
     */
    protected $shopOptions;

    public function indexAction()
    {
        $ident = $this->params()->fromRoute('categoryIdent', 0);
        $page = $this->params()->fromRoute('page', 1);
        
        $category = $this->getProductCategoryService()->getCategoryByIdent($ident);
        
        // make more gracefull with setExceptionMessages trait.
        if (! $category) {
            throw new ShopException('Unknown category ' . $ident);
        }
        
        $products = $this->getProductService()
            ->usePaginator([
            'limit' => $this->getShopOptions()->getProductsPerPage(),
            'page' => $page
        ])->getProductsByCategory($category->getIdent());
        
        return new ViewModel([
            'bread' => $this->getBreadcrumb($category->getProductCategoryId()),
            'category' => $category,
            'products' => $products
        ]);
    }

    public function viewAction()
    {
        $product = $this->getProductService()->getProductByIdent($this->params('productIdent', 0));

        if (!$product) {
            return $this->redirect()->toRoute('shop');
        }

        if (null === $product) {
            throw new ShopException('Unknown product' . $this->params('productIdent'));
        }
        
        return new ViewModel([
            'bread' => $this->getBreadcrumb($product->getProductCategory()),
            'product' => $product,
        ]);
    }

    public function searchAction()
    {
        $page = $this->params()->fromPost('page', 1);
        
        $sl = $this->getServiceLocator();
        
        $form = $sl->get('FormElementManager')->get('ShopCatalogSearch');
        $inputFilter = $sl->get('InputFilterManager')->get('ShopCatalogSearch');
        $form->setInputFilter($inputFilter);
        $form->setData($this->params()->fromPost());
        $form->isValid();

        $this->layout()->setVariable('searchData', $form->getData());
        
        $products = $this->getProductService()
            ->usePaginator([
            'limit' => $this->getShopOptions()->getProductsPerPage(),
            'page' => $page
        ])->searchProducts($form->getData());
        
        $viewModel = new ViewModel([
            'products' => $products,
        ]);

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }
        
        return $viewModel;
    }

    public function getBreadcrumb($category)
    {
        return $this->getProductCategoryService()->getParentCategories($category);
    }

    /**
     *
     * @return \Shop\Options\ShopOptions;
     */
    protected function getShopOptions()
    {
        if (! $this->shopOptions) {
            $sl = $this->getServiceLocator();
            $this->shopOptions = $sl->get('Shop\Options\Shop');
        }
        
        return $this->shopOptions;
    }

    /**
     *
     * @return \Shop\Service\Product\Product
     */
    protected function getProductService()
    {
        if (! $this->productService) {
            $sl = $this->getServiceLocator();
            $this->productService = $sl->get('Shop\Service\Product');
        }
        
        return $this->productService;
    }

    /**
     *
     * @return \Shop\Service\Product\Category
     */
    protected function getProductCategoryService()
    {
        if (! $this->productCategoryService) {
            $sl = $this->getServiceLocator();
            $this->productCategoryService = $sl->get('Shop\Service\Product\Category');
        }
        
        return $this->productCategoryService;
    }
}
