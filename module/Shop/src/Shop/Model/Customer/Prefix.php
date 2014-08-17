<?php
namespace Shop\Model\Customer;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Prefix implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $prefixId;
    
    /**
     * @var string
     */
    protected $prefix;
    
	public function getPrefixId()
	{
		return $this->prefixId;
	}

	public function setPrefixId($prefixId)
	{
		$this->prefixId = $prefixId;
		return $this;
	}

	public function getPrefix()
	{
		return $this->prefix;
	}

	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
		return $this;
	}
}
