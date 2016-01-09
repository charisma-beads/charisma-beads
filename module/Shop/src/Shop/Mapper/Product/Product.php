<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Product;

use Shop\Model\Product\Product as ProductModel;
use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

/**
 * Class Product
 *
 * @package Shop\Mapper\Product
 */
class Product extends AbstractDbMapper
{
    protected $table = 'product';
    protected $primary = 'productId';
    protected $fetchEnabled = true;
    protected $fetchDisabled = false;

    /**
     * @param $ident
     * @return ProductModel|\UthandoCommon\Model\Model
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
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
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
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
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

        foreach ($search as $key => $value) {

            switch ($value['columns'][0]) {
                case 'productCategoryId':
                    if ($value['searchString']) {
                        $select->where->in('product.productCategoryId', (array)$value['searchString']);
                    }
                    unset($search[$key]);
                    break;
                case 'discontinued':
                    $select->where->equalTo('product.discontinued', (int)$value['searchString']);;
                    unset($search[$key]);
                    break;
                case 'disabled':
                    $enabled = ($value['searchString']) ? 0 : 1;
                    $select->where->equalTo('product.enabled', $enabled);
                    unset($search[$key]);
                    break;
            }
        }

        //\FB::info($this->getSqlString($select));

        return parent::search($search, $sort, $select);
    }

    /**
     * @param array $search
     * @param null $sort
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
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
