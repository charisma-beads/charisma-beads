<?php
namespace Shop\Mapper\Post;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

class Cost extends AbstractDbMapper
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
