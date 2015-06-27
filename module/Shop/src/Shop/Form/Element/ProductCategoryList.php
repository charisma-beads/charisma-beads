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

use UthandoCommon\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ProductCategoryList
 *
 * @package Shop\Form\Element
 * @method ServiceManager getServiceLocator()
 */
class ProductCategoryList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $emptyOption = '---Please select a category---';

    /**
     * @var bool
     */
    protected $addTop = false;

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($options['add_top'])) {
            $this->addTop = $options['add_top'];
        }
    }

    public function getValueOptions()
    {
        $options = ($this->valueOptions) ?: $this->getOptionList();
        return $options;
    }
    
    public function getOptionList()
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

        if ($this->isAddTop()) {
            $categoryOptions[0] = 'Top';
        }
         
        /* @var $cat \Shop\Model\Product\Category */
    	foreach($cats as $cat) {
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
        
        return $categoryOptions;
    }

    /**
     * @return boolean
     */
    public function isAddTop()
    {
        return $this->addTop;
    }

    /**
     * @param boolean $addTopOption
     * @return $this
     */
    public function setAddTop($addTopOption)
    {
        $this->addTop = $addTopOption;
        return $this;
    }
}
