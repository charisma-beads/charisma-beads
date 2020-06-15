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
 * Class Unit
 *
 * @package Shop\Model
 */
class PostUnitModel implements ModelInterface
{
    use Model;
    
	/**
	 * @var int
	 */
	protected $postUnitId;
	
	/**
	 * @var float
	 */
	protected $postUnit;

    /**
     * @return int
     */
    public function getPostUnitId()
	{
		return $this->postUnitId;
	}

    /**
     * @param $postUnitId
     * @return $this
     */
    public function setPostUnitId($postUnitId)
	{
		$this->postUnitId = $postUnitId;
		return $this;
	}

    /**
     * @return float
     */
    public function getPostUnit()
	{
		return $this->postUnit;
	}

    /**
     * @param $postUnit
     * @return $this
     */
    public function setPostUnit($postUnit)
	{
		$this->postUnit = $postUnit;
		return $this;
	}
}
