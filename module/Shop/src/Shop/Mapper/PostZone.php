<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class PostZone extends AbstractMapper
{
    protected $table = 'postZone';
    protected $primary = 'postZoneId';
    protected $model = 'Shop\Model\PostZone';
    protected $hydrator = 'Shop\Hydrator\PostZone';
}
