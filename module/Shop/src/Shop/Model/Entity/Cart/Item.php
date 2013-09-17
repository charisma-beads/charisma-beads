<?php
namespace Shop\Model\Entity\Cart;

use Shop\Model\Entity\Product;
use Shop\Service\Taxation;

class Item
{
	public $productId;
	public $name;
	public $price;
	public $taxable;
	public $discountPercent;
	public $qty;
	public $taxCodeId;
	
	public function __construct(Product $product, $qty)
	{
		$this->productId        = (int) $product->productId;
		$this->name             = $product->name;
		$this->price            = (float) $product->price;
		$this->taxable          = $product->taxable;
		$this->discountPercent  = (int) $product->discountPercent;
		$this->qty              = (int) $qty;
		$this->taxCodeId		= (int) $product->taxCodeId; 
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
