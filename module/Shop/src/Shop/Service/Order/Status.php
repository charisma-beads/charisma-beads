<?php
namespace Shop\Service\Order;

use UthandoCommon\Service\AbstractService;

class Status extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Order\Status';
    protected $form = 'Shop\Form\Order\Status';
    protected $inputFilter = 'Shop\InputFilter\Order\Status';
    
    public function getStatusByName($status)
    {
        $status = (string) $status;
        return $this->getMapper()->getStatusByName($status);
    }
}
