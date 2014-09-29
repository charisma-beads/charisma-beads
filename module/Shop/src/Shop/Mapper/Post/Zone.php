<?php
namespace Shop\Mapper\Post;

use UthandoCommon\Mapper\AbstractDbMapper;

class Zone extends AbstractDbMapper
{
    protected $table = 'postZone';
    protected $primary = 'postZoneId';
}
