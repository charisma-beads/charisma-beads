<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Prefix
 *
 * @package Shop\Model
 */
class CustomerPrefixModel implements ModelInterface
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
