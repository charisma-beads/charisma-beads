<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

/**
 * Class Cost
 *
 * @package Shop\Mapper
 */
class PostCostMapper extends AbstractDbMapper
{
    protected $table = 'postCost';
    protected $primary = 'postCostId';
    
    public function search(array $search, $sort, $select = null)
    {
    	$select = $this->getSql()->select($this->table);
    	
    	$select->join(
	    	'postLevel',
	    	'postCost.postLevelId=postLevel.postLevelId',
	    	array(),
	    	Select::JOIN_INNER
	    )
	    ->join(
	    	'postZone',
	    	'postCost.postZoneId=postZone.postZoneId',
	    	array(),
	    	Select::JOIN_LEFT
	    );
    	 
    	return parent::search($search, $sort, $select);
    }
}
