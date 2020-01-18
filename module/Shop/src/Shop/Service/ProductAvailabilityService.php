<?php


namespace Shop\Service;


use Shop\Hydrator\ProductAvailabilityHydrator;
use Shop\Mapper\ProductAvailabilityMapper;
use Shop\Model\ProductAvailabilityModel;

class ProductAvailabilityService
{
    protected $hydrator     = ProductAvailabilityHydrator::class;
    protected $mapper       = ProductAvailabilityMapper::class;
    protected $model        = ProductAvailabilityModel::class;
}