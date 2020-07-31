<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Hit
 *
 * @package Shop\Mapper
 */
class AdvertHitMapper extends AbstractDbMapper
{
    protected $table = 'advertHit';
    protected $primary = 'advertHitId';
}
