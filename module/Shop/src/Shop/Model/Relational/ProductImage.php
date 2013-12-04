<?php
namespace Shop\Model\Relational;

use Shop\Model\ProductImage as Base;

class ProductImage extends Base
{
    /**
     * @var string
     */
    protected $name;
    
	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

}
