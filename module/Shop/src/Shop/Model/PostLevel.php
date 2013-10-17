<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class PostLevel extends AbstractModel
{
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
	public function getPostLevelId ()
	{
		return $this->postLevelId;
	}

	/**
	 * @param number $postLevelId
	 */
	public function setPostLevelId ($postLevelId)
	{
		$this->postLevelId = $postLevelId;
		return $this;
	}

	/**
	 * @return number $postLevel
	 */
	public function getPostLevel ()
	{
		return $this->postLevel;
	}

	/**
	 * @param number $postLevel
	 */
	public function setPostLevel ($postLevel)
	{
		$this->postLevel = $postLevel;
		return $this;
	}
}
