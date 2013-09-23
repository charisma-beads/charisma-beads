<?php
namespace User\Model\DbTable;

use Application\Model\DbTable\AbstractTable;

class User extends AbstractTable
{ 
	protected $table = 'user';
	protected $primary = 'userId';
	protected $rowClass = 'User\Model\Entity\User';
    
    public function getUserByEmail($email, $ignore=null)
    {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        return $row;
    }
    
    public function fetchAllUsers(array $post)
    {
    	$count = (isset($post['count'])) ? (int) $post['count'] : null;
    	$email = (isset($post['email'])) ? (string) $post['email'] : '';
    	$user = (isset($post['user'])) ? (string) $post['user'] : '';
    	$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
    	$page = (isset($post['page'])) ? (int) $post['page'] : null;
    	 
    	$select = $this->sql->select();
    	$select->from($this->table);
    
    	if (!$user == '') {
    		if (substr($user, 0, 1) == '=') {
    			$id = (int) substr($user, 1);
    			$select->where->equalTo('userId', $id);
    		} else {
    			$searchTerms = explode(' ', $user);
    			$where = $select->where->nest();
    			
    			foreach ($searchTerms as $value) {
    				$where->like('firstname', '%'.$value.'%')
    					->or
    					->like('lastname',  '%'.$value.'%');
    			}
    			
    			$where->unnest();
    		}
    	}
    
    	if (!$email == '') {
    		$select->where
    		->nest()
    		->like('email', '%'.$email.'%')
    		->unnest();
    	}
    	
    	if (str_replace('-', '', $sort) == 'name') {
    		if (strchr($sort,'-')) {
    			$sort = array('-lastname', '-firstname');
    		} else {
    			$sort = array('lastname', 'firstname');
    		}
    	}
    
    	$select = $this->setSortOrder($select, $sort);
    	
    	if (null === $page) {
    		return $this->fetchResult($select);
    	} else {
    		return $this->paginate($select, $page, $count);
    	}
    }
}
