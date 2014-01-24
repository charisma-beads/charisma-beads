<?php
namespace User\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

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
    	$this->getResultSet()->getHydrator()->emptyPassword();
        $select = $this->getSelect()
        	->where(array('email' => $email));
        
        if ($ignore) {
        	$select->where->notEqualTo('email', $ignore);
        }
        
        $rowset = $this->fetchResult($select);
        $row = $rowset->current();
        
        return $row;
    }
    
    public function search(array $search, $sort, Select $select = null)
    {	
    	if (str_replace('-', '', $sort) == 'name') {
    		if (strchr($sort,'-')) {
    			$sort = array('-lastname', '-firstname');
    		} else {
    			$sort = array('lastname', 'firstname');
    		}
    	}
    
    	return parent::search($search, $sort, $select);
    }
}
