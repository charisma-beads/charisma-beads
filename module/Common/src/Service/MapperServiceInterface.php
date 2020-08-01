<?php

namespace Common\Service;

use Common\Mapper\MapperInterface;
use Common\Model\ModelInterface;
use Laminas\Form\Form;


interface MapperServiceInterface
{
    /**
     * return one or more records from database by id
     *
     * @param $id
     * @param $col
     * @return array|mixed|ModelInterface
     */
    public function getById($id, $col);

    /**
     * fetch all records form database
     *
     * @param null|string $sort
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function fetchAll($sort = null);

    /**
     * basic search on database
     *
     * @param array $post
     * @return \Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator|\Laminas\Db\ResultSet\HydratingResultSet
     */
    public function search(array $post);

    /**
     * prepare and return form
     *
     * @param array $post
     * @param \Laminas\Form\Form $form
     * @return int|Form
     */
    public function add(array $post, Form $form = null);

    /**
     * prepare data to be updated and saved into database.
     *
     * @param ModelInterface $model
     * @param array $post
     * @param Form $form
     * @return int results from self::save()
     */
    public function edit(ModelInterface $model, array $post, Form $form = null);

    /**
     * updates a row if id is supplied else insert a new row
     *
     * @param array|ModelInterface $data
     * @throws ServiceException
     * @return int $results number of rows affected or insertId
     */
    public function save($data);

    /**
     * delete row from database
     *
     * @param int $id
     * @return int $result number of rows affected
     */
    public function delete($id);

    /**
     * Gets mapper class
     *
     * @param string $mapperClass
     * @param array $options
     * @return MapperInterface
     */
    public function getMapper($mapperClass = null, array $options = []);

    /**
     * Sets mapper class.
     *
     * @param string $mapperClass
     * @param array $options
     * @return $this
     */
    public function setMapper($mapperClass, array $options = []);

    /**
     * @param array $options
     * @return mixed
     */
    public function usePaginator($options = []);
}
