<?php
namespace Shop\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Product extends Form implements ServiceLocatorAwareInterface
{	
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $this->add(array(
        	'name'	=> 'productId',
        	'type'	=> 'hidden',
        ));
        
        $this->add(array(
        	'name'			=> 'ident',
        	'type'			=> 'text',
        	'attributes'	=> array(
        		'placehoder'		=> 'Ident:',
        		'autofocus'			=> true,
        		'autocapitalize'	=> 'off'
        	),
        	'options'		=> array(
        		'label'			=> 'Ident:',
        		'help-inline'	=> 'If you leave this blank the the product name and short description will be used for the ident.'
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'name',
        	'type'			=> 'text',
        	'attributes'	=> array(
        		'placeholder'	=> 'Product Name:',
        		'autofocus'		=> true,
        	),
        	'options'		=> array(
        		'label'		=> 'Product Name/Number:',
        		'required'	=> true,
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'price',
        	'type'			=> 'number',
        	'attributes'	=> array(
        		'placeholder'	=> 'Price:',
        		'autofocus'		=> true,
        		'step'			=> '0.01'
        	),
        	'options'		=> array(
        		'label'			=> 'Price:',
        		'required'		=> true,
        		'help-inline'	=> 'Do not include the currency sign or commas.',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'description',
        	'type'			=> 'textarea',
        	'attributes'	=> array(
        		'placeholder'	=> 'Product Description:',
        		'autofocus'		=> true,	
        	),
        	'options'		=> array(
        		'label'		=> 'Description:',
        		'required'	=> true,
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'shortDescription',
        	'type'			=> 'text',
        	'attributes'	=> array(
        		'placeholder'	=> 'Short Description:',
        		'autofocus'		=> true,
        	),
        	'options'		=> array(
        		'label'		=> 'Short Description:',
        		'required'	=> true,
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'quantity',
        	'type'			=> 'number',
        	'attributes'	=> array(
        		'autofocus'	=> true,
        		'min'		=> '-1',
        		'step'		=> '1',
        	),
        	'options'		=> array(
        		'label'	=> 'Quantity:',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'taxable',
        	'type'			=> 'checkbox',
        	'options'		=> array(
        		'label'			=> 'Taxable:',
        		'required' 		=> true,
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'addPostage',
        	'type'			=> 'checkbox',
        	'options'		=> array(
        		'label'			=> 'Add Postage:',
        		'required' 		=> true,
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'discountPercent',
        	'type'			=> 'number',
        	'attributes'	=> array(
        		'autofocus'	=> true,
        		'min'		=> '0.00',
        		'max'		=> '100.00',
        		'step'		=> '0.01',
        	),
        	'options'		=> array(
        		'label'			=> 'Product Discount:',
        		'help-inline'	=> 'Do not include the % sign.'
        	)
        ));
        
        $this->add(array(
        	'name'			=> 'enabled',
        	'type'			=> 'checkbox',
        	'options'		=> array(
        		'label'			=> 'Enabled:',
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        		'required' 		=> true,
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'discontinued',
        	'type'			=> 'checkbox',
        	'options'		=> array(
        		'label'			=> 'Discontinued:',
        		'required' 		=> true,
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'vatInc',
        	'type'			=> 'checkbox',
        	'options'		=> array(
        		'label'			=> 'Vat Included:',
        		'required' 		=> true,
        		'use_hidden_element' => true,
        		'checked_value' => '1',
        		'unchecked_value' => '0',
        	),
        ));
    		
    	$this->add(array(
    		'name'		=> 'productCategoryId',
    		'type'		=> 'select',
    		'options'	=> array(
    			'label'			=> 'Category:',
    			'required'		=> true,
    			'empty_option'	=> '---Please select a category---',
    			'value_options'	=> $this->getCategoryList(),
    		),
    	));
    	
    	$this->add(array(
    		'name'		=> 'productSizeId',
    		'type'		=> 'select',
    		'options'	=> array(
    			'label'			=> 'Size:',
    			'required'		=> true,
    			'empty_option'	=> '---Please select a size---',
    			'value_options'	=> $this->getSizeList(),
    		),
    	));
    	
    	$this->add(array(
    		'name'		=> 'postUnitId',
    		'type'		=> 'select',
    		'options'	=> array(
    			'label'			=> 'Weight:',
    			'required'		=> true,
    			'empty_option'	=> '---Please select a weight---',
    			'value_options'	=> $this->getPostUnitList(),
    		),
    	));
    	
    	$this->add(array(
    		'name'		=> 'productGroupId',
    		'type'		=> 'select',
    		'options'	=> array(
    			'label'			=> 'Price Group:',
    			'required'		=> true,
    			'empty_option'	=> '--Please select a price group---',
    			'value_options'	=> $this->getGroupPriceList(),
    		),
    	));
    	
    	$this->add(array(
    		'name'		=> 'taxCodeId',
    		'type'		=> 'select',
    		'options'	=> array(
    			'label'			=> 'Tax Code:',
    			'required'		=> true,
    			'empty_option'	=> '---Please select a tax code---',
    			'value_options'	=> $this->getTaxCodeList(),
    		),
    	));
    }
    
    protected function getCategoryList()
    {
    	$cats = $this->getCategoryService()->fetchAll();
    	$categoryOptions = array();
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
    	
    	return $categoryOptions;
    }
    
    protected function getGroupPriceList()
    {
    	$groups = $this->getGroupPriceService()->fetchAll();
    	$groupPriceOptions = array('0' => 'None');
    	
    	/* @var $group \Shop\Model\Product\GroupPrice */
    	foreach($groups as $group) {
    		$groupPriceOptions[$group->getProductGroupId()] = $group->getGroup() . ' - ' . $group->getPrice();
    	}
    	
    	return $groupPriceOptions;
    }
    
    protected function getPostUnitList()
    {
    	$postUnits = $this->getPostUnitService()->fetchAll();
    	$postUnitOptions = array();
    	
    	/* @var $postUnit \Shop\Model\Post\Unit */
    	foreach($postUnits as $postUnit) {
    		$postUnitOptions[$postUnit->getPostUnitId()] = $postUnit->getPostUnit();
    	}
    	
    	return $postUnitOptions;
    }
    
    protected function getSizeList()
    {
    	$sizes = $this->getSizeService()->fetchAll();
    	$sizeOptions = array();
    	
    	/* @var $size \Shop\Model\Product\Size */
    	foreach($sizes as $size) {
    		$sizeOptions[$size->getProductSizeId()] = $size->getSize(); 
    	}
    	
    	return $sizeOptions;
    }
    
    protected function getTaxCodeList()
    {
    	$taxCodes = $this->getTaxCodeService()->fetchAll();
    	$taxCodeOptions = array();
    	
    	/* @var $taxCode \Shop\Model\Tax\Code */
    	foreach($taxCodes as $taxCode) {
    		$taxCodeOptions[$taxCode->getTaxCodeId()] = $taxCode->getTaxCode() . ' - ' . $taxCode->getDescription();
    	}
    	
    	return $taxCodeOptions;
    }
    
    /**
     * @return \Shop\Service\Product\Category
     */
    public function getCategoryService()
    {
    	return $this->getServiceLocator()->get('Shop\Service\ProductCategory');
    }
    
    /**
     * @return \Shop\Service\Product\GroupPrice
     */
	public function getGroupPriceService()
	{
		return $this->getServiceLocator()->get('Shop\Service\ProductGroupPrice');
	}
	
    /**
     * @return Shop\Service\Post\Unit
     */
	public function getPostUnitService()
	{
		return $this->getServiceLocator()->get('Shop\Service\PostUnit');
	}
	    
    /**
     * @return \Shop\Service\Product\Size
     */
	public function getSizeService()
	{
		return $this->getServiceLocator()->get('Shop\Service\ProductSize');
	}
	
	/**
	 * @return \Shop\Service\Tax\Code
	 */
	public function getTaxCodeService()
	{
		return $this->getServiceLocator()->get('Shop\Service\TaxCode');
	}
}
