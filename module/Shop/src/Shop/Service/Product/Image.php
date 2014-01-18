<?php
namespace Shop\Service\Product;

use Application\Service\AbstractService;

class Image extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\ProductImage';
    protected $form = 'Shop\Form\ProductImage';
    protected $inputFilter = 'Shop\InputFilter\ProductImage';
    
    /**
     * @var \Shop\Service\Product
     */
    protected $productService;
    
    public function search(array $post)
    {	 
    	$models = parent::search($post);
    	
    	foreach ($models as $model) {
    	    $this->populate($model);
    	}
    	
    	return $models;
    }
    
    /**
    *
    * @param \Shop\Model\Product\Image $model
    */
    public function populate($model, $children = false)
    {
    	$model->setRelationalModel($this->getProductService()->getById($model->getProductId()));
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
