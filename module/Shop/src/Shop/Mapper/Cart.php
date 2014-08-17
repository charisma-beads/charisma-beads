<?php
namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractMapper;

class Cart extends AbstractMapper
{
    protected $table = 'cart';
    protected $primary = 'cartId';
    protected $model = 'Shop\Model\Cart';
    protected $hydrator = 'Shop\Hydrator\Cart';
    
    /**
     * @param string $verifier
     * @return \Shop\Model\Cart
     */
    public function getCartByVerifier($verifier)
    {
        $select = $this->getSelect();
        $select->where->equalTo('verifyId', $verifier);
        
        $resultSet = $this->fetchResult($select);
        
        return $resultSet->current();
    }
}
