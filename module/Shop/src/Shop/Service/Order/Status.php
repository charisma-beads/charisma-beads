<?php
namespace Shop\Service\Order;

use Application\Service\AbstractService;

class Status extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\OrderStatus';
    protected $form = 'Shop\Form\OrderStatus';
    protected $inputFilter = 'Shop\InputFilter\OrderStatus';
    
    public function getStatusByName($status)
    {
        $status = (string) $status;
        return $this->getMapper()->getStatusByName($status);
    }
}
