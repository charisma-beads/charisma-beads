<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model\Post;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Zone
 *
 * @package Shop\Model\Post
 */
class Zone implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $postZoneId;
    
    /**
     * @var int
     */
    protected $taxCodeId;
    
    /**
     * @var string
     */
    protected $zone;
    
	/**
	 * @return number $postZoneId
	 */
	public function getPostZoneId()
	{
		return $this->postZoneId;
	}

	/**
	 * @param number $postZoneId
	 */
	public function setPostZoneId($postZoneId)
	{
		$this->postZoneId = $postZoneId;
		return $this;
	}

	/**
	 * @return number $taxCodeId
	 */
	public function getTaxCodeId()
	{
		return $this->taxCodeId;
	}

	/**
	 * @param number $taxCodeId
	 */
	public function setTaxCodeId($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

	/**
	 * @return string $zone
	 */
	public function getZone()
	{
		return $this->zone;
	}

	/**
	 * @param string $zone
	 */
	public function setZone($zone)
	{
		$this->zone = $zone;
		return $this;
	}
}
