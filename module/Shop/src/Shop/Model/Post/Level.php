<?php
namespace Shop\Model\Post;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Level implements ModelInterface
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
	 */
	public function setPostLevel($postLevel)
	{
		$this->postLevel = $postLevel;
		return $this;
	}
}
