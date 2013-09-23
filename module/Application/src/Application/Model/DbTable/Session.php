<?php
namespace Application\Model\DbTable;

class Session extends AbstractTable
{
	protected $table = 'session';
	protected $primary = 'id';
	protected $rowClass = 'Application\Model\Entity\Session';
	
	/**
	 * Gets one row by its id
	 *
	 * @param int $id
	 * @return \Application\Model\Entity\Session
	 */
	public function getById($id)
	{
		$id = (string) $id;
		$rowset = $this->tableGateway->select(array($this->primary => $id));
		$row = $rowset->current();
		return $row;
	}
	
	public function fetchAllSessions(array $post)
	{
		$count = (isset($post['count'])) ? (int) $post['count'] : null;
		$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
		$page = (isset($post['page'])) ? (int) $post['page'] : null;
	
		$select = $this->sql->select();
		$select->from($this->table);
	
		$select = $this->setSortOrder($select, $sort);
		 
		if (null === $page) {
    		return $this->fetchResult($select);
    	} else {
    		return $this->paginate($select, $page, $count);
    	}
	}
}
