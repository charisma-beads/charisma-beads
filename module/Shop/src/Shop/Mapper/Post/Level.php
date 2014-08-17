<?php
namespace Shop\Mapper\Post;

use UthandoCommon\Mapper\AbstractMapper;

class Level extends AbstractMapper
{
    protected $table = 'postLevel';
    protected $primary = 'postLevelId';
    protected $model = 'Shop\Model\Post\Level';
    protected $hydrator = 'Shop\Hydrator\Post\Level';
    
}
