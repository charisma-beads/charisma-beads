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
 * Class Level
 *
 * @package Shop\Model\Post
 */
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
