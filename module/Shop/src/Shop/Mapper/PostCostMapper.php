<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Select;

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
