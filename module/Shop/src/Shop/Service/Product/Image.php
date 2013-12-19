<?php
namespace Shop\Service\Product;

use Application\Service\AbstractService;

class Image extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\ProductImage';
    protected $form = '';
    protected $inputFilter = '';
    
    /**
     * @var \Shop\Service\Product
     */
    protected $productService;
    
    public function searchImages(array $post)
    {
    	$image = (isset($post['image'])) ? (string) $post['image'] : '';
    	$product = (isset($post['product'])) ? (string) $post['product'] : '';
    	$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
    	 
    	$images = $this->getMapper()->searchImages($image, $product, $sort);
    	
    	foreach ($images as $image) {
    	    $this->populate($image);
    	}
    	
    	return $images;
    }
    
    /**
    *
    * @param \Shop\Model\Product\Image $image
    */
    public function populate($image)
    {
    	$image->setRelationalModel($this->getProductService()->getById($image->getProductId()));
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
