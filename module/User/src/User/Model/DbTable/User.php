<?php
namespace User\Model\DbTable;

use Application\Model\DbTable\AbstractTable;

class UserTable extends AbstractTable
{ 
	protected $table = 'user';
	protected $primary = 'userId';
	protected $rowClass = 'User\Model\Entity\UserEntity';
    
    public function getUserByEmail($email, $ignore)
    {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        return $row;
    }
}