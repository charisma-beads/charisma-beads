<?php
namespace Shop\Mapper\Post;

use Application\Mapper\AbstractMapper;

class Zone extends AbstractMapper
{
    protected $table = 'postZone';
    protected $primary = 'postZoneId';
    protected $model = 'Shop\Model\Post\Zone';
    protected $hydrator = 'Shop\Hydrator\Post\Zone';
}
