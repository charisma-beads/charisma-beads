<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Option
 *
 * @package Shop\Mapper
 */
class ProductOptionMapper extends AbstractDbMapper
{
	protected $table = 'productOption';
	protected $primary = 'productOptionId';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getOptionsByProductId($id)
    {
        $id = (int) $id;

        $select = $this->getSelect();
        $select->where->equalTo('productId', $id);
        return $this->fetchResult($select);
    }
}
