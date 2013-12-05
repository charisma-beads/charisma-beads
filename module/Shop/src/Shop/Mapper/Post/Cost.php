<?php
namespace Shop\Mapper\Post;

use Application\Mapper\AbstractMapper;

class Cost extends AbstractMapper
{
    protected $table = 'postCost';
    protected $primary = 'postCostId';
    protected $model = 'Shop\Model\Post\Cost';
    protected $hydrator = 'Shop\Hydrator\Post\Cost';
}
