<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

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
        /* @var $categoryService \Shop\Service\Product\Category */
        $categoryService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopProductCategory');
        
        $categoryService->getMapper()
            ->setFetchEnabled(false)
            ->setFetchDisabled(true);
        $cats = $categoryService->fetchAll();
        
        $categoryOptions = [];
         
        /* @var $cat \Shop\Model\Product\Category */
    	foreach($cats as $cat) {
    		$indent = 'indent' . ($cat->getDepth() + 1);
    		$parent = ($cat->hasChildren() || $cat->getDepth() == 0) ? 'bold ' : '';
    		$categoryOptions[] = [
    			'label'	=> $cat->getCategory(),
    			'value'	=> $cat->getProductCategoryId(),
    			'attributes'	=> [
    				'class'	=> $parent,
					'style' => 'text-indent:' . $cat->getDepth() . 'em;',
    			],
    		];
    	}
        
        $this->setValueOptions($categoryOptions);
    }

}
