<?php
namespace Shop\Mapper\Advert;

use UthandoCommon\Mapper\AbstractDbMapper;

class Advert extends AbstractDbMapper
{
    protected $table = 'advert';
    protected $primary = 'advertId';
}

