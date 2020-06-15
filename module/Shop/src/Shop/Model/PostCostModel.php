<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Cost
 *
 * @package Shop\Model
 */
class PostCostModel implements ModelInterface
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
     * @var PostLevelModel
     */
    protected $postLevel;
    
    /**
     * @var PostZoneModel
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
     * @return PostCostModel
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
     * @return PostCostModel
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
     * @return PostCostModel
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
     * @return PostCostModel
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
     * @return PostCostModel
     */
	public function setVatInc($vatInc)
	{
		$this->vatInc = $vatInc;
		return $this;
	}
	
	/**
	 * @return PostLevelModel
	 */
	public function getPostLevel()
    {
        return $this->postLevel;
    }

    /**
     * @param PostLevelModel $postLevel
     * @return PostCostModel
     */
	public function setPostLevel(PostLevelModel $postLevel)
    {
        $this->postLevel = $postLevel;
        return $this;
    }

    /**
     * @return PostZoneModel
     */
	public function getPostZone()
    {
        return $this->postZone;
    }

    /**
     * @param PostZoneModel $postZone
     * @return PostCostModel
     */
	public function setPostZone(PostZoneModel $postZone)
    {
        $this->postZone = $postZone;
        return $this;
    }

}
