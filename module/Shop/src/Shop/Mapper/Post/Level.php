<?php
namespace Shop\Mapper\Post;

use UthandoCommon\Mapper\AbstractDbMapper;

class Level extends AbstractDbMapper
{
    protected $table = 'postLevel';
    protected $primary = 'postLevelId';
}
