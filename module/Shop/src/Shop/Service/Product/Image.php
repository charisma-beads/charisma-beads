<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

class Image extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Product\Image';
    protected $form = 'Shop\Form\Product\Image';
    protected $inputFilter = 'Shop\InputFilter\Product\Image';

    protected $serviceAlias = 'ShopProductImage';
    
    /**
     * @var \Shop\Service\Product
     */
    protected $productService;
    
    public function search(array $post)
    {	 
    	$models = parent::search($post);
    	
    	foreach ($models as $model) {
    	    $this->populate($model, true);
    	}
    	
    	return $models;
    }
    
    /**
    *
    * @param \Shop\Model\Product\Image $model
    */
    public function populate($model, $children = false)
    {
        $allChildren = ($children === true) ? true : false;
        $children = (is_array($children)) ? $children : array();
        	
        if ($allChildren || in_array('product', $children)) {
            $model->setProduct(
                $this->getProductService()
                    ->getById($model->getProductId())
            );
        }
    }
    
    /**
     * @return \Shop\Service\Product
     */
    public function getProductService()
    {
    	if (!$this->productService) {
    		$sl = $this->getServiceLocator();
    		$this->productService = $sl->get('Shop\Service\Product');
    	}
    
    	return $this->productService;
    }
}
