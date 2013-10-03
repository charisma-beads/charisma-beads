<?php

namespace Article\Model\Entity;

use Application\Model\Entity\AbstractEntity;

class Article extends AbstractEntity
{
	/**
	 * @var int
	 */
	protected $articleId;
	
	/**
	 * @var string
	 */
	protected $title;
	
	/**
	 * @var string
	 */
	protected $slug;
	
	/**
	 * @var string
	 */
	protected $content;
	
	/**
	 * @var string
	 */
	protected $description;
	
	/**
	 * @var string
	 */
	protected $keywords;
	
	/**
	 * @var int
	 */
	protected $pageHits;
	
	/**
	 * @var string
	 */
	protected $dateCreated;
	
	/**
	 * @var string
	 */
	protected $dateModified;
	
	protected $inputFilterClass = 'Article\InputFilter\Article';
	
	public function exchangeArray(array $data)
	{
		$this->setArticleId($data['articleId'])
			->setTitle($data['title'])
			->setSlug($data['slug'])
			->setContent($data['content'])
			->setDescription($data['description'])
			->setKeywords($data['keywords'])
			->setPageHits($data['pageHits'])
			->setDateCreated($data['dateCreated'])
			->setDateModified($data['dateModified']);
		return $this;
	}

	public function getArrayCopy()
	{
		return array(
			'articleId'		=> $this->getArticleId(),
			'title'			=> $this->getTitle(),
			'slug'			=> $this->getSlug(),
			'content'		=> $this->getContent(),
			'description'	=> $this->getDescription(),
			'keywords'		=> $this->getKeywords(),
			'pageHits'		=> $this->getPageHits(),
			'dateCreated'	=> $this->getDateCreated(),
			'dateModified'	=> $this->getDateModified()
		);
	}
	
	/**
	 * @return the $articleId
	 */
	public function getArticleId()
	{
		return $this->articleId;
	}

	/**
	 * @param number $articleId
	 */
	public function setArticleId($articleId)
	{
		$this->articleId = $articleId;
		return $this;
	}

	/**
	 * @return the $title
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return the $slug
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * @param string $slug
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;
		return $this;
	}

	/**
	 * @return the $content
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

	/**
	 * @return the $description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return the $keywords
	 */
	public function getKeywords()
	{
		return $this->keywords;
	}

	/**
	 * @param string $keywords
	 */
	public function setKeywords($keywords)
	{
		$this->keywords = $keywords;
		return $this;
	}

	/**
	 * @return the $pageHits
	 */
	public function getPageHits()
	{
		return $this->pageHits;
	}

	/**
	 * @param number $pageHits
	 */
	public function setPageHits($pageHits)
	{
		$this->pageHits = $pageHits;
		return $this;
	}

	/**
	 * @return the $dateCreated
	 */
	public function getDateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @param string $dateCreated
	 */
	public function setDateCreated($dateCreated)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}

	/**
	 * @return the $dateModified
	 */
	public function getDateModified()
	{
		return $this->dateModified;
	}

	/**
	 * @param string $dateModified
	 */
	public function setDateModified($dateModified)
	{
		$this->dateModified = $dateModified;
		return $this;
	}
}
