<?php
namespace Shop\Service\Order;

use UthandoCommon\Service\AbstractMapperService;

class Status extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopOrderStatus';

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
