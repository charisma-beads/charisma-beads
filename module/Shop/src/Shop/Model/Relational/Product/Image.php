<?php
namespace Shop\Model\Relational\Product;

use Shop\Model\Product\Image as Base;

class Image extends Base
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
