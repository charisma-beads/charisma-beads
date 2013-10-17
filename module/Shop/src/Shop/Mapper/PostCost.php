<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class PostCost extends AbstractMapper
{
    protected $table = 'postCost';
    protected $primary = 'postCostId';
    protected $model = 'Shop\Model\PostCost';
    protected $hydrator = 'Shop\Hydrator\PostCost';
}
