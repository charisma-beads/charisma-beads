<?php

namespace Navigation\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class Page extends AbstractEntity
{   
	/**
	 * @var int
	 */
	protected $pageId;
	
	/**
	 * @var int
	 */
	protected $menuId;
	
	/**
	 * @var string
	 */
	protected $label;
	
	/**
	 * @var string
	 */
	protected $params;
	
	/**
	 * @var string
	 */
	protected $route;
	
	/**
	 * @var string
	 */
	protected $uri;
	
	/**
	 * @var string
	 */
	protected $resource;
	
	/**
	 * @var int
	 */
	protected $visible;
	
	/**
	 * @var int
	 */
	protected $lft;
	
	/**
	 * @var int
	 */
	protected $rgt;
	
	/**
	 * @var int
	 */
	protected $depth;
	
	protected $inputFilterClass = 'Navigation\InputFilter\Page';
	
	public function exchangeArray(array $data)
	{
		$this->setPageId($data['pageId'])
			->setMenuId($data['menuId'])
			->setLabel($data['lable'])
			->setParams($data['params'])
			->setRoute($data['route'])
			->setUri($data['uri'])
			->setResource($data['resource'])
			->setVisible($data['visible'])
			->setLft($data['lft'])
			->setRgt($data['rgt']);
		
		if (isset($data['depth'])) {
			$this->setDepth($data['depth']);
		}
	}
	
	public function getArrayCopy($addDepth=false)
	{
		$data = array(
			'pageId'	=> $this->getPageId(),
			'menuId'	=> $this->getMenuId(),
			'label'		=> $this->getLabel(),
			'params'	=> $this->getParams(),
			'route'		=> $this->getRoute(),
			'uri'		=> $this->getUri(),
			'resource'	=> $this->getResource(),
			'visible'	=> $this->getVisible(),
			'lft'		=> $this->getLft(),
			'rgt'		=> $this->getRgt()
		);
		
		if (true === $addDepth) {
			$data['depth'] = $this->getDepth();
		}
		
		return $data;
	}

	/**
	 * @return the $pageId
	 */
	public function getPageId()
	{
		return $this->pageId;
	}

	/**
	 * @param number $pageId
	 */
	public function setPageId($pageId)
	{
		$this->pageId = $pageId;
		return $this;
	}

	/**
	 * @return the $menuId
	 */
	public function getMenuId()
	{
		return $this->menuId;
	}

	/**
	 * @param number $menuId
	 */
	public function setMenuId($menuId)
	{
		$this->menuId = $menuId;
		return $this;
	}

	/**
	 * @return the $label
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
		return $this;
	}

	/**
	 * @return the $params
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * @param string $params
	 */
	public function setParams($params)
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * @return the $route
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * @param string $route
	 */
	public function setRoute($route)
	{
		$this->route = $route;
		return $this;
	}

	/**
	 * @return the $uri
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * @param string $uri
	 */
	public function setUri($uri)
	{
		$this->uri = $uri;
		return $this;
	}

	/**
	 * @return the $resource
	 */
	public function getResource()
	{
		return $this->resource;
	}

	/**
	 * @param string $resource
	 */
	public function setResource($resource)
	{
		$this->resource = $resource;
		return $this;
	}

	/**
	 * @return the $visible
	 */
	public function getVisible()
	{
		return $this->visible;
	}

	/**
	 * @param number $visible
	 */
	public function setVisible($visible)
	{
		$this->visible = $visible;
		return $this;
	}

	/**
	 * @return the $lft
	 */
	public function getLft()
	{
		return $this->lft;
	}

	/**
	 * @param number $lft
	 */
	public function setLft($lft)
	{
		$this->lft = $lft;
		return $this;
	}

	/**
	 * @return the $rgt
	 */
	public function getRgt()
	{
		return $this->rgt;
	}

	/**
	 * @param number $rgt
	 */
	public function setRgt($rgt)
	{
		$this->rgt = $rgt;
		return $this;
	}
	
	/**
	 * @param number $depth
	 */
	public function getDepth()
	{
		return $this->depth;
	}
	
	/**
	 * @param number $depth
	 * @return \Navigation\Model\Entity\Page
	 */
	public function setDepth($depth)
	{
		$this->depth = $depth;
		return $this;
	}

	public function isVisible()
    {
        return ($this->getVisible()) ? 'Yes' : 'No';
    }
    
    public function getRouteLabel()
    {
    	return ($this->route == '0') ? 'Category Heading' : $this->route;
    }
}
