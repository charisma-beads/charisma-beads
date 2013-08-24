<?php

namespace Article\Model\DbTable;

use Application\Model\DbTable\AbstractTable;

class ArticleTable extends AbstractTable
{
	protected $table = 'article';
	protected $primary = 'articleId';
	protected $rowClass = 'Article\Model\Entity\ArticleEntity';
	
	public function getArticleBySlug($slug)
	{
		$rowset = $this->tableGateway->select(array('slug' => $slug));
		$row = $rowset->current();
		return $row;
	}
}