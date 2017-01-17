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
use Shop\Model\Post\Level;
use Shop\Model\Post\Zone;

/**
 * Class Cost
 *
 * @package Shop\Model\Post
 */
class Cost implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $postCostId;
    
    /**
     * @var int
     */
    protected $postLevelId;
    
    /**
     * @var int
     */
    protected $postZoneId;
    
    /**
     * @var float
     */
    protected $cost;
    
    /**
     * @var bool
     */
    protected $vatInc;
    
    /**
     * @var Level
     */
    protected $postLevel;
    
    /**
     * @var Zone
     */
    protected $postZone;
    
	/**
	 * @return number $postCostId
	 */
	public function getPostCostId()
	{
		return $this->postCostId;
	}

	/**
	 * @param number $postCostId
	 */
	public function setPostCostId($postCostId)
	{
		$this->postCostId = $postCostId;
		return $this;
	}

	/**
	 * @return number $postLevelId
	 */
	public function getPostLevelId()
	{
		return $this->postLevelId;
	}

	/**
	 * @param number $postLevelId
	 */
	public function setPostLevelId($postLevelId)
	{
		$this->postLevelId = $postLevelId;
		return $this;
	}

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
	 * @return number $cost
	 */
	public function getCost()
	{
		return $this->cost;
	}

	/**
	 * @param number $cost
	 */
	public function setCost($cost)
	{
		$this->cost = $cost;
		return $this;
	}

	/**
	 * @return boolean $vatInc
	 */
	public function getVatInc()
	{
		return $this->vatInc;
	}

	/**
	 * @param boolean $vatInc
	 */
	public function setVatInc($vatInc)
	{
		$this->vatInc = $vatInc;
		return $this;
	}
	
	/**
	 * @return \Shop\Model\Post\Level
	 */
	public function getPostLevel()
    {
        return $this->postLevel;
    }

    /**
     * @param Level $postLevel
     * @return \Shop\Model\Post\Cost
     */
	public function setPostLevel(Level $postLevel)
    {
        $this->postLevel = $postLevel;
        return $this;
    }

    /**
     * @return \Shop\Model\Post\Zone
     */
	public function getPostZone()
    {
        return $this->postZone;
    }

    /**
     * @param Zone $postZone
     * @return \Shop\Model\Post\Cost
     */
	public function setPostZone(Zone $postZone)
    {
        $this->postZone = $postZone;
        return $this;
    }

}
