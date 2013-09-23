<?php
namespace Article\Service\DbTable;

use Application\Service\AbstractDbTableFactory;

class ArticleFactory extends AbstractDbTableFactory
{

	protected function getName()
	{
		return 'Article\Model\DbTable\ArticleTable';
	}
}
