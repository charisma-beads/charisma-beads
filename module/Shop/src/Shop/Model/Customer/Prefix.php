<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model\Customer;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Prefix
 *
 * @package Shop\Model\Customer
 */
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
