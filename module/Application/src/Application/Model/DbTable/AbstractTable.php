<?php

namespace Application\Model\DbTable;

use Application\Mapper\DbAdapterAwareInterface;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;

use FB;

class AbstractTable implements DbAdapterAwareInterface
{
    /**
     * @var TableGateway
     */
	protected $tableGateway;
	
	/**
	 * Name of table
	 * 
	 * @var string
	 */
	protected $table;
	
	/**
	 * name of primary column
	 * 
	 * @var string
	 */
	protected $primary;
	
	/**
	 * name of entity class
	 * 
	 * @var string
	 */
	protected $rowClass;
	
	/**
	 * @var Sql
	 */
	protected $sql;
	
	protected $dbAdapter;
	
	protected $hydrator;
	
	/**
	 * gets the resultSet
	 * 
	 * @return \Zend\Db\ResultSet\HydratingResultSet
	 */
	protected function getResultSet()
	{
		$resultSetPrototype = new HydratingResultSet();
		$resultSetPrototype->setHydrator(new ObjectProperty());
		$resultSetPrototype->setObjectPrototype(new $this->rowClass());
		
		return $resultSetPrototype;
	}
	
	/**
	 * Gets one row by its id
	 * 
	 * @param int $id
	 * @return \Application\Model\Entity\AbstractEntity
	 */
	public function getById($id)
	{
		$id = (int) $id;
		$rowset = $this->getTablegateway()->select(array($this->primary => $id));
		$row = $rowset->current();
		return $row;
	}
	
	/**
	 * Fetches all rows from database table.
	 * 
	 * @return ResultSet
	 */
	public function fetchAll()
	{
		$resultSet = $this->getTablegateway()->select();
		\FB::info($resultSet, __METHOD__);
		return $resultSet;
	}
	
	/**
	 * Updates a database row by its id.
	 * 
	 * @param int $id
	 * @param array $data
	 * @return Ambigous <number, \Zend\Db\TableGateway\mixed>
	 */
	public function update($id, $data)
	{
		return $this->getTablegateway()->update($data, array($this->primary => $id));
	}
	
	/**
	 * Inserts a new row into database returns insertId
	 * 
	 * @param array $data
	 * @return int
	 */
	public function insert($data)
	{
		return $this->getTablegateway()->insert($data);
	}
	
	/**
	 * Deletes a row in the database
	 * 
	 * @param int $id
	 */
	public function delete($id)
	{
		return $this->getTablegateway()->delete(array($this->primary => $id));
	}
	
	/**
	 * Paginates the resultset
	 * 
	 * @param ResultSet $resultSet
	 * @param int $page
	 * @param int $limit
	 * @return \Zend\Paginator\Paginator
	 */
	public function paginate(Select $select, $page, $limit)
	{
		$adapter = new DbSelect($select, $this->sql, $this->getTablegateway()->getResultSetPrototype());	
		$paginator = new Paginator($adapter);
		
		$paginator->setItemCountPerPage($limit)
			->setCurrentPageNumber($page)
			->setPageRange(5);
		
		FB::info($paginator, __METHOD__);
		
		return $paginator;
	}
	
	/**
	 * Fetches the result of select from database
	 *
	 * @param Select $select
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	protected function fetchResult(Select $select)
	{
		// we have to set up a new result set otherwise
		// the table class will only retrive the last query
		$resultSet = $this->getResultSet();
		
		$statement = $this->getSql()->prepareStatementForSqlObject($select);
		$result = $statement->execute();
		
		$resultSet->initialize($result);
		
		FB::info($resultSet, __METHOD__);
		
		return $resultSet;
	}
	
	/**
	 * Sets database query limit
	 * 
	 * @param Select $select
	 * @param int $count
	 * @param int $offset
	 * @return Select
	 */
	public function setLimit(Select $select, $count, $offset)
	{
		if ($count === null) {
			return $select;
		}
		
		return $select->limit($count, $offset);
	}
	
	/**
	 * Sets sort order of database query
	 * 
	 * @param Select $select
	 * @param string $sort
	 * @return Select
	 */
	public function setSortOrder(Select $select, $sort)
	{
		if ($sort === '' || null === $sort) {
			return $select;
		}
		
		$sort = (array) $sort;
		
		$order = array();
		
		foreach ($sort as $column) {
			if (strchr($column,'-')) {
				$column = substr($column, 1, strlen($column));
				$direction = 'DESC';
			} else {
				$direction = 'ASC';
			}
			$order[] = $column. ' ' . $direction;
		}
	
		return $select->order($order);
	}
	
	protected function getSql()
	{
		if (!$this->sql) {
			$this->sql = new Sql($this->getDbAdapter());
		}
		
		return $this->sql;
	}
	
	protected function getTableGateway()
	{
		if (!$this->tableGateway) {
			$this->tableGateway = new TableGateway($this->table, $this->getDbAdapter(), null, $this->getResultSet());
		}
		
		return $this->tableGateway;
	}
	
	public function getDbAdapter()
	{
		return $this->dbAdapter;
	}

	
	public function setDbAdapter(DbAdapter $dbAdapter)
	{
		$this->dbAdapter = $dbAdapter;
		return $this;	
	}
}
