<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Order;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Status
 *
 * @package Shop\Service\Order
 */
class Status extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopOrderStatus';
    
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
        /* @var $mapper \Shop\Mapper\Order\Status */
        $mapper = $this->getMapper();

        return $mapper->getStatusByName($status);
    }
}
