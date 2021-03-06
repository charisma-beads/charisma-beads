<?php

namespace Shop\Mapper;

use Shop\Model\ProductModel as ProductModel;
use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Expression;
use Laminas\Db\Sql\Select;

/**
 * Class Product
 *
 * @package Shop\Mapper
 */
class ProductMapper extends AbstractDbMapper
{
    protected $table = 'product';
    protected $primary = 'productId';
    protected $fetchEnabled = true;
    protected $fetchDisabled = false;

    /**
     * @param $ident
     * @return ProductModel|\Common\Model\Model
     */
    public function getProductByIdent($ident)
    {
        $ident = (string)$ident;
        $select = $this->getSelect()->where(['ident' => $ident]);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }

    /**
     * @param $id
     * @return null|ProductModel
     */
    public function getFullProductById($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('product.productId', $id);

        $select = $this->setFilter($select);

        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }

    /**
     * @param Select $select
     * @return Select
     */
    public function setFilter(Select $select)
    {
        if ($this->getFetchEnabled()) {
            $select->where->equalTo('product.enabled', 1);
        }

        if (!$this->getFetchDisabled()) {
            $select->where->equalTo('product.discontinued', 0);
        }

        return $select;
    }

    /**
     * @return bool
     */
	public function getFetchEnabled()
    {
        return $this->fetchEnabled;
    }

    /**
     * @param $fetchEnabled
     * @return $this
     */
	public function setFetchEnabled($fetchEnabled)
    {
        $this->fetchEnabled = $fetchEnabled;
        return $this;
    }

    /**
     * @return bool
     */
	public function getFetchDisabled()
    {
        return $this->fetchDisabled;
    }

    /**
     * @param $fetchDisabled
     * @return $this
     */
	public function setFetchDisabled($fetchDisabled)
    {
        $this->fetchDisabled = $fetchDisabled;
        return $this;
    }

    /**
     * @param array $categoryId
     * @param null $order
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getProductsByCategory(array $categoryId, $order = null)
    {
        $select = $this->getSelect();
        $select->join(
            'productCategory',
            'product.productCategoryId=productCategory.productCategoryId',
            array(),
            Select::JOIN_LEFT
        );

        $select->where->in('product.productCategoryId', $categoryId);

        $select = $this->setFilter($select);

        if ($order) {
            $select = $this->setSortOrder($select, $order);
        }

        return $this->fetchResult($select);
    }

    /**
     * @param array $search
     * @param string $sort
     * @param null $select
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
	public function search(array $search, $sort, $select = null)
    {
        $select = $this->getSelect();
        $select->join(
            'productCategory',
            'product.productCategoryId=productCategory.productCategoryId',
            array(),
            Select::JOIN_LEFT
        )
            ->join(
                'productGroup',
                'product.productGroupId=productGroup.productGroupId',
                array(),
                Select::JOIN_LEFT
            )
            ->join(
                'productSize',
                'product.productSizeId=productSize.productSizeId',
                array(),
                Select::JOIN_LEFT
            );

        $disabled = 0;
        $discontinued = 0;

        foreach ($search as $key => $value) {

            switch ($value['columns'][0]) {
                case 'productCategoryId':
                    if ($value['searchString']) {
                        $select->where->in('product.productCategoryId', (array)$value['searchString']);
                    }
                    unset($search[$key]);
                    break;
                case 'discontinued':
                    $discontinued = (int) $value['searchString'];
                    unset($search[$key]);
                    break;
                case 'disabled':
                    $disabled = (int) $value['searchString'];
                    unset($search[$key]);
                    break;
            }
        }

        if ($discontinued == 1 && $disabled == 1) {
            $where = $select->where->nest();
            $where->equalTo('product.enabled', 0);
            $where->or->equalTo('product.discontinued', 1);
            $where->unnest();
        } elseif ($discontinued == 1 && $disabled == 0) {
            $select->where->equalTo('product.discontinued', 1);
        } elseif ($discontinued == 0 && $disabled == 1) {
            $select->where->equalTo('product.enabled', 0);
            $select->where->equalTo('product.discontinued', 0);
        } else {
            $select->where->equalTo('product.enabled', 1);
            $select->where->equalTo('product.discontinued', 0);
        }

        //\FB::info($this->getSqlString($select));

        return parent::search($search, $sort, $select);
    }

    /**
     * @param array $search
     * @param null $sort
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
	public function searchProducts(array $search, $sort = null)
    {
        $select = $this->getSelect();
        $select->join(
            'productCategory',
            'product.productCategoryId=productCategory.productCategoryId',
            array(),
            Select::JOIN_LEFT
        )->join(
            'postUnit',
            'product.postUnitId=postUnit.postUnitId',
            array(),
            Select::JOIN_LEFT
        )->join(
            'productSize',
            'product.productSizeId=productSize.productSizeId',
            array(),
            Select::JOIN_LEFT
        );

        $select = $this->setFilter($select);

        //\FB::info($this->getSqlString($select));

        return parent::search($search, $sort, $select);
    }

    /**
     * @param int $limit
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getLatestProducts($limit = 10)
    {
        $select = $this->getSelect();
        $select = $this->setLimit($select, $limit, 0);
        $select = $this->setSortOrder($select, '-dateCreated');

        $select = $this->setFilter($select);

        return $this->fetchResult($select);
    }

    /**
     * @param $id
     * @return array|\ArrayObject|null|ProductModel
     */
    public function getPreviousProduct($id)
    {
        $whereSelect = $this->getSql()->select();
        $whereSelect->from($this->getTable())
            ->columns([
                'productId' => new Expression('MAX(productId)')
            ])->where->lessThan('productId' , $id);

        $select = $this->getSelect();
        $select->where(['productId' => $whereSelect]);

        $result = $this->fetchResult($select);
        $row = $result->current();

        return $row;
    }

    /**
     * @param $id
     * @return array|\ArrayObject|null|ProductModel
     */
    public function getNextProduct($id)
    {
        $whereSelect = $this->getSql()->select();
        $whereSelect->from($this->getTable())
            ->columns([
                'productId' => new Expression('MIN(productId)')
            ])->where->greaterThan('productId' , $id);

        $select = $this->getSelect();
        $select->where(['productId' => $whereSelect]);

        $result = $this->fetchResult($select);
        $row = $result->current();

        return $row;
    }
}
