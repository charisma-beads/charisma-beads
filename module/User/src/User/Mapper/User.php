<?php
namespace User\Mapper;

use Application\Mapper\AbstractMapper;

class User extends AbstractMapper
{ 
	protected $table = 'user';
	protected $primary = 'userId';
	protected $model= 'User\Model\User';
	protected $hydrator = 'User\Hydrator\User';
	
	public function getById($id)
	{
		$this->getResultSet()->getHydrator()->emptyPassword();
		return parent::getById($id);
	}
    
    public function getUserByEmail($email, $ignore=null)
    {
        $select = $this->getSelect()
        	->where(array('email' => $email));
        $rowset = $this->fetchResult($select);
        $row = $rowset->current();
        
        return $row;
    }
    
    public function fetchAllUsers(array $post)
    {
    	$this->getResultSet()->getHydrator()->emptyPassword();
    	
    	$count = (isset($post['count'])) ? (int) $post['count'] : null;
    	$email = (isset($post['email'])) ? (string) $post['email'] : '';
    	$user = (isset($post['user'])) ? (string) $post['user'] : '';
    	$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
    	$page = (isset($post['page'])) ? (int) $post['page'] : null;
    	 
    	$select = $this->getSelect();
    
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
