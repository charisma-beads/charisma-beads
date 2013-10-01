<?php
namespace Application\Mapper;

class Session extends AbstractMapper
{
	protected $table = 'session';
	protected $primary = 'id';
	protected $model = 'Application\Model\Session';
	protected $hydrator = 'Application\Hydrator\Session';
	
	public function fetchAllSessions(array $post)
	{
		$count = (isset($post['count'])) ? (int) $post['count'] : null;
		$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
		$page = (isset($post['page'])) ? (int) $post['page'] : null;
	
		$select = $this->getSelect();
	
		$select = $this->setSortOrder($select, $sort);
		 
		if (null === $page) {
    		return $this->fetchResult($select);
    	} else {
    		return $this->paginate($select, $page, $count);
    	}
	}
}
