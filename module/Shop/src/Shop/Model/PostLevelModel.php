<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Level
 *
 * @package Shop\Model
 */
class PostLevelModel implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $postLevelId;
    
    /**
     * @var float
     */
    protected $postLevel;
    
	/**
	 * @return number $postLevelId
	 */
	public function getPostLevelId()
	{
		return $this->postLevelId;
	}

    /**
     * @param number $postLevelId
     * @return PostLevelModel
     */
	public function setPostLevelId($postLevelId)
	{
		$this->postLevelId = $postLevelId;
		return $this;
	}

	/**
	 * @return number $postLevel
	 */
	public function getPostLevel()
	{
		return $this->postLevel;
	}

    /**
     * @param number $postLevel
     * @return PostLevelModel
     */
	public function setPostLevel($postLevel)
	{
		$this->postLevel = $postLevel;
		return $this;
	}
}
