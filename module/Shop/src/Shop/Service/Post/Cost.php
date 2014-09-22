<?php

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Cost extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopPostCost';

    /**
     * @var array
     */
    protected $referenceMap = [
        'postLevel' => [
            'refCol'    => 'postLevelId',
            'service'   => 'Shop\Service\Post\Level',
        ],
        'postZone'  => [
            'refCol'    => 'postZoneId',
            'service'   => 'Shop\Service\Post\Zone',
        ],
    ];

    /**
     * @param array $post
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
	public function search(array $post)
	{
		$costs = parent::search($post);

        /* @var $cost \Shop\Model\Post\Cost */
		foreach ($costs as $cost) {
			$this->populate($cost, true);
		}
	
		return $costs;
	}
}
