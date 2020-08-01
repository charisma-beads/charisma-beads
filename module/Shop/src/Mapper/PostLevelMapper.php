<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Level
 *
 * @package Shop\Mapper
 */
class PostLevelMapper extends AbstractDbMapper
{
    protected $table = 'postLevel';
    protected $primary = 'postLevelId';
}
