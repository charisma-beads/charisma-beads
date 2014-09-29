<?php
namespace Shop\Mapper\Cart;

use UthandoCommon\Mapper\AbstractDbMapper;

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
}
