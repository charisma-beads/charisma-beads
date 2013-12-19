<?php
namespace Shop\Hydrator\Stock;

use Application\Hydrator\AbstractHydrator;

class Status extends AbstractHydrator
{
    protected $prefix = 'stockStatus.';
    
	/**
	 * @param \Shop\Model\Stock\Status $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'stockStautsId'  => $object->getStockStautsId(),
            'stockStatus'    => $object->getStockStatus()
		);
	}
}
