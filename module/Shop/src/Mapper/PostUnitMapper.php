<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Unit
 *
 * @package Shop\Mapper
 */
class PostUnitMapper extends AbstractDbMapper
{
	protected $table = 'postUnit';
	protected $primary = 'postUnitId';
}
