<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class PostLevel extends AbstractMapper
{
    protected $table = 'postLevel';
    protected $primary = 'postLevelId';
    protected $model = 'Shop\Model\PostLevel';
    protected $hydrator = 'Shop\Hydrator\PostLevel';
}
