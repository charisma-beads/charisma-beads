<?php
namespace Article\Hydrator;

use Application\Hydrator\AbstractHydrator;

class Article extends AbstractHydrator
{
	public function __construct()
	{
		parent::__construct();
		
		return $this;
	}

	/**
	 * @param \Article\Model\Article
	 * @return array
	 */
	public function extract($object) 
	{
		return array(
			
		);
	}
}