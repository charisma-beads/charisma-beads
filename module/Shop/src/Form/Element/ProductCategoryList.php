<?php

namespace Shop\Form\Element;

use Shop\Service\ProductCategoryService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

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

        if (array_key_exists('empty_option', $options)) {
            $this->setEmptyOption($options['empty_option']);
        }
    }

    public function getValueOptions()
    {
        $options = ($this->valueOptions) ?: $this->getOptionList();
        return $options;
    }
    
    public function getOptionList()
    {
        /* @var $categoryService \Shop\Service\ProductCategoryService */
        $categoryService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(ProductCategoryService::class);
        
        $categoryService->getMapper()
            ->setFetchEnabled(false)
            ->setFetchDisabled(true);
        $cats = $categoryService->fetchAll();
        
        $categoryOptions = [];

        if ($this->isAddTop()) {
            $categoryOptions[0] = 'Top';
        }
         
        /* @var $cat \Shop\Model\ProductCategoryModel */
    	foreach($cats as $cat) {
            $ident = ($cat->getDepth() > 0) ? str_repeat('&nbsp;&nbsp;',($cat->getDepth())) . '&bull;&nbsp;' : '';
    		$categoryOptions[] = [
    			'label'	                => $ident . $cat->getCategory(),
    			'value'	                => $cat->getProductCategoryId(),
                'disable_html_escape'   => true,
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
