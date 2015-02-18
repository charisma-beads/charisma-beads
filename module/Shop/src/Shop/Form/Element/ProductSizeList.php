<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ProductSizeList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a size---';
    
    public function init()
    {
        $sizes = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopProductSize')
            ->fetchAll();
        
    	$sizeOptions = [];
    	
    	/* @var $size \Shop\Model\Product\Size */
    	foreach($sizes as $size) {
    		$sizeOptions[$size->getProductSizeId()] = $size->getSize(); 
    	}
        
        $this->setValueOptions($sizeOptions);
    }

}
