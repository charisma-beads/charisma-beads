<?php
namespace Article\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;

class Article extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
		
		return $this;
	}

	/**
	 * @param \Article\Model\Article
	 * @return array
	 */
	public function extract($object) 
	{
		return array(
			'articleId'		=> $object->getArticleId(),
			'title'			=> $object->getTitle(),
			'slug'			=> $object->getSlug(),
			'content'		=> $object->getContent(),
			'description'	=> $object->getDescription(),
			'keywords'		=> $object->getKeywords(),
			'pageHits'		=> $object->getPageHits(),
			'dateCreated'	=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'	=> $this->extractValue('dateModified', $object->getDateModified()),
		);
	}
}
