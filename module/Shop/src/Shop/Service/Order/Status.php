<?php
namespace Shop\Service\Order;

use UthandoCommon\Service\AbstractMapperService;

class Status extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Order\Status';
    protected $form = 'Shop\Form\Order\Status';
    protected $inputFilter = 'Shop\InputFilter\Order\Status';

    protected $serviceAlias = 'ShopOrderStatus';
    
    public function getStatusByName($status)
    {
        $status = (string) $status;
        return $this->getMapper()->getStatusByName($status);
    }
}
