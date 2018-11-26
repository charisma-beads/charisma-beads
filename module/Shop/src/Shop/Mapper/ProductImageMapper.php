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

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

/**
 * Class Image
 *
 * @package Shop\Mapper
 */
class ProductImageMapper extends AbstractDbMapper
{
	protected $table = 'productImage';
	protected $primary = 'productImageId';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getImagesByProductId($id)
    {
        $id = (int) $id;

        $select = $this->getSelect();
        $select->where->equalTo('productId', $id);
        return $this->fetchResult($select);
    }

    /**
     * @param array $ids
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
	public function getImagesByCategoryIds(array $ids)
	{
		$select = $this->getSql()->select();
		$select->from($this->table)
		->join(
			'product',
			'productImage.productId=product.productId',
			array(),
			Select::JOIN_INNER
		);
		
		$select->where->in('productCategoryId', $ids);
		
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
	    $select = $this->getSql()->select();
	    $select->from($this->table)
        ->join(
            'product',
            'productImage.productId=product.productId',
            array(),
            Select::JOIN_INNER     
	    );
	    
	    return parent::search($search, $sort, $select);
	}
}
