<?php

namespace Shop\Service;

use Shop\Hydrator\OrderStatusHydrator;
use Shop\Mapper\OrderStatusMapper;
use Shop\Model\OrderStatusModel;
use Common\Service\AbstractMapperService;

/**
 * Class Status
 *
 * @package Shop\Service
 */
class OrderStatusService extends AbstractMapperService
{
    protected $hydrator     = OrderStatusHydrator::class;
    protected $mapper       = OrderStatusMapper::class;
    protected $model        = OrderStatusModel::class;
    
    protected $tags = [
        'order-status',
    ];

    /**
     * @param string $status
     * @return array|\ArrayObject|null|object
     */
    public function getStatusByName($status)
    {
        $status = (string) $status;
        /* @var $mapper \Shop\Mapper\OrderStatusMapper */
        $mapper = $this->getMapper();

        return $mapper->getStatusByName($status);
    }
}
