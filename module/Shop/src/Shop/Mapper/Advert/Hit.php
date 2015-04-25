<?php
namespace Shop\Mapper\Advert;

use UthandoCommon\Mapper\AbstractDbMapper;

class Hit extends AbstractDbMapper
{
    protected $table = 'advertHit';
    protected $primary = 'advertHitId';
}
