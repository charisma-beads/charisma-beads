<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Shop for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ShopController extends AbstractController
{
	/**
	 * @var \Shop\Service\ProductCategory
	 */
	protected $productCategoryService;
	
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function shopFrontAction()
    {
    	$cats = $this->getProductCategoryService()->fetchAll(true);
    	
    	return new ViewModel(array(
			'cats' => $cats
    	));
    }
    
    /**
     * @return \Shop\Service\ProductCategory
     */
    protected function getProductCategoryService()
    {
    	if (!$this->productCategoryService) {
    		$sl = $this->getServiceLocator();
    		$this->productCategoryService = $sl->get('Shop\Service\ProductCategory');
    	}
    
    	return $this->productCategoryService;
    }
}
