<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class ProductImage extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\ProductImage';
    protected $form = '';
    protected $inputFilter = '';
    
    public function searchImages(array $post)
    {
    	$image = (isset($post['image'])) ? (string) $post['image'] : '';
    	$product = (isset($post['product'])) ? (string) $post['product'] : '';
    	$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
    	 
    	return $this->getMapper()->searchImages($image, $product, $sort);
    }
}
