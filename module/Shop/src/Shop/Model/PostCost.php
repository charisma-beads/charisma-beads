<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class PostCost extends AbstractModel
{
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
	 * @return number $postCostId
	 */
	public function getPostCostId ()
	{
		return $this->postCostId;
	}

	/**
	 * @param number $postCostId
	 */
	public function setPostCostId ($postCostId)
	{
		$this->postCostId = $postCostId;
		return $this;
	}

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
	 * @return number $postZoneId
	 */
	public function getPostZoneId ()
	{
		return $this->postZoneId;
	}

	/**
	 * @param number $postZoneId
	 */
	public function setPostZoneId ($postZoneId)
	{
		$this->postZoneId = $postZoneId;
		return $this;
	}

	/**
	 * @return number $cost
	 */
	public function getCost ()
	{
		return $this->cost;
	}

	/**
	 * @param number $cost
	 */
	public function setCost ($cost)
	{
		$this->cost = $cost;
		return $this;
	}

	/**
	 * @return boolean $vatInc
	 */
	public function getVatInc ()
	{
		return $this->vatInc;
	}

	/**
	 * @param boolean $vatInc
	 */
	public function setVatInc ($vatInc)
	{
		$this->vatInc = $vatInc;
		return $this;
	}
}
