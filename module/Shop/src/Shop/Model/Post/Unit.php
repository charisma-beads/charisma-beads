<?php
namespace Shop\Model\Post;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Unit implements ModelInterface
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
