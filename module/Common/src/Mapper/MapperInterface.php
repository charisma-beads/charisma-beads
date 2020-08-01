<?php

namespace Common\Mapper;

use Common\Model\ModelAwareInterface;
use Laminas\Hydrator\HydratorAwareInterface;


interface MapperInterface extends HydratorAwareInterface, ModelAwareInterface
{
    /**
     * @param $id
     * @param null $col
     * @return mixed
     */
    public function getById($id, $col = null);

    /**
     * @param null|string $sort
     * @return mixed
     */
    public function fetchAll($sort = null);

    /**
     * @param array $search
     * @param $sort
     * @param null $select
     * @return mixed
     */
    public function search(array $search, $sort, $select = null);

    /**
     * @param array $data
     * @param null $table
     * @return mixed
     */
    public function insert(array $data, $table = null);

    /**
     * @param array $data
     * @param $where
     * @param null $table
     * @return mixed
     */
    public function update(array $data, $where, $table = null);

    /**
     * @param $where
     * @param null $table
     * @return mixed
     */
    public function delete($where, $table = null);

    /**
     * @return mixed
     */
    public function getPrimaryKey();

    /**
     * @return mixed
     */
    public function getTable();

    /**
     * @return bool
     */
    public function usePaginator();

    /**
     * @param bool $use
     * @return $this
     */
    public function setUsePaginator($use);

    /**
     * @return array
     */
    public function getPaginatorOptions();

    /**
     * @param array $paginatorOptions
     * @return $this
     */
    public function setPaginatorOptions(array $paginatorOptions);

    /**
     * @param $select
     * @param mixed $resultSet
     * @return mixed
     */
    public function paginate($select, $resultSet = null);
}
