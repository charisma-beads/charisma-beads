<?php
namespace Shop\Service\Product;

use Application\Service\AbstractService;

class Image extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Product\Image';
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
