<?php
namespace Shop\Mapper\Post;

use UthandoCommon\Mapper\AbstractMapper;

class Unit extends AbstractMapper
{
	protected $table = 'postUnit';
	protected $primary = 'postUnitId';
	protected $model = 'Shop\Model\Post\Unit';
	protected $hydrator = 'Shop\Hydrator\Post\Unit';
}
