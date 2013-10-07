<?php
namespace Shop\Model;

use Shop\Model\Product;
use Shop\Service\Taxation;

class CartItem
{
	public $productId;
	public $category;
	public $name;
	public $description;
	public $price;
	public $taxable;
	public $discountPercent;
	public $qty;
	public $taxCodeId;
	
	public function init(Product $product, $qty)
	{
		$this->productId        	= (int) $product->getProductId();
		$this->name             	= $product->getName();
		$this->description			= $product->getShortDescription();
		$this->price            	= (float) $product->getPrice();
		$this->taxable          	= $product->getTaxable();
		$this->discountPercent  	= (int) $product->getDiscountPercent();
		$this->qty              	= (int) $qty;
		$this->taxCodeId			= (int) $product->getTaxCodeId(); 
	}
	
	public function getLineCost()
	{
		$price = $this->price;
	
		if (0 !== $this->discountPercent) {
			$discounted = ($price*$this->discountPercent)/100;
			$price = round($price - $discounted, 2);
		}
	
		if ('Yes' === $this->taxable) {
			$taxService = new Taxation($this->taxCodeId);
			$price = $taxService->addTax($price);
		}
	
		return $price * $this->qty;
	}
}
