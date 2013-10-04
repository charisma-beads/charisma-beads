<?php

namespace Article\Mapper;

use Application\Mapper\AbstractMapper;

class Article extends AbstractMapper
{
	protected $table = 'article';
	protected $primary = 'articleId';
	protected $model = 'Article\Model\Article';
	protected $hydrator = 'Article\Hydrator\Article';
	
	public function getArticleBySlug($slug)
	{
		$select = $this->getSelect()->where(array('slug' => $slug));
		$rowset = $this->fetchResult($select);
		$row = $rowset->current();
		return $row;
	}
}