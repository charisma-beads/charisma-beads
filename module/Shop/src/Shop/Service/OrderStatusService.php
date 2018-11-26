<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Hydrator\OrderStatusHydrator;
use Shop\Mapper\OrderStatusMapper;
use Shop\Model\Order\Status;
use Shop\Model\OrderStatusModel;
use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Status
 *
 * @package Shop\Service
 */
class OrderStatusService extends AbstractMapperService
{
    protected $hydrator     = OrderStatusHydrator::class;
    protected $mapper       = OrderStatusMapper::class;
    protected $model        = Status::class;
    
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
