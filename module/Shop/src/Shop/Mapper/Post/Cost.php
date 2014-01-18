<?php
namespace Shop\Mapper\Post;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Cost extends AbstractMapper
{
    protected $table = 'postCost';
    protected $primary = 'postCostId';
    protected $model = 'Shop\Model\Post\Cost';
    protected $hydrator = 'Shop\Hydrator\Post\Cost';
    
    public function search(array $search, $sort, Select $select = null)
    {
    	$select = $this->getSql()->select($this->table);
    	
    	$select->join(
	    	'postLevel',
	    	'postCost.postLevelId=postLevel.postLevelId',
	    	array('postLevel'),
	    	Select::JOIN_INNER
	    )
	    ->join(
	    	'postZone',
	    	'postCost.postZoneId=postZone.postZoneId',
	    	array('zone'),
	    	Select::JOIN_LEFT
	    );
    	 
    	return parent::search($search, $sort, $select);
    }
}
