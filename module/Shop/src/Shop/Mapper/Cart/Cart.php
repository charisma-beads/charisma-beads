<?php
namespace Shop\Mapper\Cart;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Where;

class Cart extends AbstractDbMapper
{
    protected $table = 'cart';
    protected $primary = 'cartId';

    /**
     * @param $id
     * @return \Shop\Model\Cart\Cart|null
     */
    public function getCartById($id)
    {
        $select = $this->getSelect()->where(['cartId' => $id]);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();

        return $row;
    }
    
    /**
     * @param string $verifier
     * @return \Shop\Model\Cart\Cart
     */
    public function getCartByVerifier($verifier)
    {
        $select = $this->getSelect();
        $select->where->equalTo('verifyId', $verifier);
        
        $resultSet = $this->fetchResult($select);
        
        return $resultSet->current();
    }

    /**
     * @param $time
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getExpiredCarts($time)
    {
        $select = $this->getSelect();
        $select->where->lessThan('dateModified', $time);

        return $this->fetchResult($select);
    }

    /**
     * @param array $ids
     * @return int
     */
    public function deleteCartsByIds(array $ids)
    {
        $where = new Where();
        $where->in('cartId', $ids);
        return $this->delete($where);
    }
}
