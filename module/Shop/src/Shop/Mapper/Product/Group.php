<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Where;

/**
 * Class Group
 *
 * @package Shop\Mapper\Product
 */
class Group extends AbstractDbMapper
{
    protected $table = 'productGroup';
    protected $primary = 'productGroupId';
    
    public function updateGroupProductPrices($group, $price)
    {
        $group = (int) $group;
        $price = (float) $price;
         
        $where = new Where();
        $where->equalTo('productGroupId', $group);
         
        $this->update(['price' => $price], $where, 'product');
         
    }
}
