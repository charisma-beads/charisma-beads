<?php

namespace Shop\Form\Element;

use Shop\Service\ProductSizeService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ProductSizeList
 *
 * @package Shop\Form\Element
 */
class ProductSizeList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a size---';
    
    public function init()
    {
        $sizes = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(ProductSizeService::class)
            ->fetchAll('size');
        
    	$sizeOptions = [];
    	
    	/* @var $size \Shop\Model\ProductSizeModel */
    	foreach($sizes as $size) {
    		$sizeOptions[$size->getProductSizeId()] = $size->getSize(); 
    	}
        
        $this->setValueOptions($sizeOptions);
    }

}
