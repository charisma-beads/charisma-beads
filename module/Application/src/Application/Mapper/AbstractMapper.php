<?php
namespace Application\Mapper;

use Application\Model\AbstractModel;
use Application\Mapper\DbAdapterAwareInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AbstractMapper implements DbAdapterAwareInterface
{
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
	 * name of model class
	 *
	 * @var string
	 */
	protected $model;
	
	/**
	 * @var Sql
	 */
	protected $sql;
	
	/**
	 * @var Adapter
	 */
	protected $dbAdapter;
	
	/**
	 * @var string
	 */
	protected $hydrator;
	
	/**
	 * @var bool
	 */
	protected $useModelRelationships = false;
	
	/**
	 * @var HydratingResultSet
	 */
	protected $resultSetProtype;
	
	/**
	 * @var boolean
	 */
	protected $usePaginator;
	
	/**
	 * @var array
	 */
	protected $paginatorOptions;
	
	/**
	 * return an instance of Select
	 * 
	 * @param string $tableName
	 * @return \Zend\Db\Sql\Select
	 */
	public function getSelect($tableName=null)
	{
		return $this->getSql()->select($tableName ?: $this->table);
	}
	
	/**
	 * gets the resultSet
	 *
	 * @return \Zend\Db\ResultSet\HydratingResultSet
	 */
	protected function getResultSet()
	{
		if (!$this->resultSetProtype instanceof HydratingResultSet) {
			$resultSetPrototype = new HydratingResultSet();
			$resultSetPrototype->setHydrator($this->getHydrator());
			$resultSetPrototype->setObjectPrototype(new $this->model());
			$this->resultSetProtype = $resultSetPrototype;
		}
	
		return clone $this->resultSetProtype;
	}
	
	/**
	 * Gets one row by its id
	 *
	 * @param int $id
	 * @return \Application\Mapper\AbstractModel
	 */
	public function getById($id)
	{
		$select = $this->getSelect()->where(array($this->primary => $id));
		$rowset = $this->fetchResult($select);
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
		$select = $this->getSelect();
		$resultSet = $this->fetchResult($select);
		
		return $resultSet;
	}
	
	/**
	 * Updates a database row by its id.
	 *
	 * @param int $id
	 * @param array $data
	 * @return int number of affected rows
	 */
	public function update($id, $data)
	{
		$sql = $this->getSql();
		$update = $sql->update($this->table);
	
		$update->set($data)
			->where(array($this->primary => $id));
	
		$statement = $sql->prepareStatementForSqlObject($update);
	
		return $statement->execute();
	}
	
	/**
	 * Inserts a new row into database returns insertId
	 *
	 * @param array $data
	 * @return int|null
	 */
	public function insert($data)
	{
		$sql = $this->getSql();
		$insert = $sql->insert($this->table);
	
		$insert->values($data);
	
		$statement = $sql->prepareStatementForSqlObject($insert);
		$result = $statement->execute();
	
		return $result->getGeneratedValue();
	}
	
	/**
	 * Deletes a row in the database
	 *
	 * @param int $id
	 */
	public function delete($id)
	{
		$sql = $this->getSql();
		$delete = $sql->delete($this->table);
	
		$delete->where(array($this->primary => $id));
	
		$statement = $sql->prepareStatementForSqlObject($delete);
	
		return $statement->execute();
	}
	
	public function usePaginator(array $paginatorOptions = array())
	{
		$this->usePaginator = true;
		$this->paginatorOptions = $paginatorOptions;
		return $this;
	}
	
	public function getPaginatorOptions()
	{
		return $this->paginatorOptions;
	}

	public function setPaginatorOptions($paginatorOptions)
	{
		$this->paginatorOptions = $paginatorOptions;
		return $this;
	}

	/**
	 * Paginates the resultset
	 *
	 * @param ResultSet $resultSet
	 * @param int $page
	 * @param int $limit
	 * @return \Zend\Paginator\Paginator
	 */
	public function paginate(Select $select, $resultSet=null)
	{
		$resultSet = $resultSet ?: $this->getResultSet();
		$adapter = new DbSelect($select, $this->getDbAdapter(), $resultSet);
		$paginator = new Paginator($adapter);
		
		$options = $this->getPaginatorOptions();
		
		if (isset($options['limit'])) {
		    $paginator->setItemCountPerPage($options['limit']);
		}
		
		if (isset($options['page'])) {
		    $paginator->setCurrentPageNumber($options['page']);
		}
	
		$paginator->setPageRange(5);
	
		return $paginator;
	}
	
	/**
	 * Fetches the result of select from database
	 *
	 * @param Select $select
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	protected function fetchResult(Select $select, $resultSet=null)
	{
		$resultSet = $resultSet ?: $this->getResultSet();
		$resultSet->buffer();
		
		if($this->usePaginator) {
			$this->usePaginator = false;
			$resultSet = $this->paginate($select, $resultSet);
		} else {
            $statement = $this->getSql()->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            $resultSet->initialize($result);
		}
	
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
	
	public function extract($dataOrModel, HydratorInterface $hydrator = null)
	{
		if (is_array($dataOrModel)) {
			return $dataOrModel;
		}
		if (!$dataOrModel instanceOf AbstractModel) {
			throw new \InvalidArgumentException('need nstance of AbstractModel got: ' . getType($dataOrModel));
		}
		$hydrator = $hydrator ?: $this->getHydrator();
		return $hydrator->extract($dataOrModel);
	}
	
	/**
	 * @return ClassMethods
	 */
	public function getHydrator()
	{
		if (is_string($this->hydrator) && class_exists($this->hydrator)) {
			return new $this->hydrator($this->useModelRelationships);
		} else {
			return new ClassMethods();
		}
	}
	
	/**
	 * @param bool $bool
	 */
	public function useModelRelationships($bool)
	{
	    $this->useModelRelationships = (bool) $bool;
	}
	
	/**
	 * @return model
	 */
	public function getModel(array $data = null)
	{
		if (is_string($this->model) && class_exists($this->model)) {
			if ($data) {
				$hydrator = $this->getHydrator();
				return $hydrator->hydrate($data, new $this->model);
			}
			return new $this->model;
		}else{
			throw new \RuntimeException('could not instantiate model - ' . $this->model);
		}
	}
	
	/**
	 * @return Sql
	 */
	protected function getSql()
	{
		if (!$this->sql) {
			$this->sql = new Sql($this->getDbAdapter());
		}
	
		return $this->sql;
	}
	
	/**
	 * @return dbAdapter
	 */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

    /**
	 * @param $dbAdapter
	 * @return self
	 */
    public function setDbAdapter(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }
    
    /**
     * @return $primary
     */
    public function getPrimaryKey()
    {
    	return $this->primary;
    }
}
