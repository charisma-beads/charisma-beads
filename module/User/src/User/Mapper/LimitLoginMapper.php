<?php

declare(strict_types=1);

namespace User\Mapper;

use Common\Mapper\AbstractDbMapper;
use User\Model\LimitLoginModel;

class LimitLoginMapper extends AbstractDbMapper
{
    protected $table = 'limit_login';
    protected $primary = 'id';

    public function getLoginByIp(string $ip): LimitLoginModel
    {
        $select = $this->getSelect();
        $select->where->equalTo('ip', $ip);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current() ?: new LimitLoginModel();

        return $row;
    }
}
