<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ProductCategoryList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a category---';
    
    public function init()
    {
        $cats = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopProductCategory')
            ->fetchAll();
        
        $categoryOptions = [];
        $parent = 0;
         
        /* @var $cat \Shop\Model\Product\Category */
        foreach($cats as $cat) {
        
        	if (0 == $cat->getDepth()) {
        		$parent = $cat->getProductCategoryId();
        		$categoryOptions[$parent]['options'][$cat->getProductCategoryId()] = $cat->getCategory();
        		$categoryOptions[$parent]['label'] = $cat->getCategory();
        	} else {
        		$categoryOptions[$parent]['options'][$cat->getProductCategoryId()] = $cat->getCategory();
        	}
        }
        
        $this->setValueOptions($categoryOptions);
    }

}
