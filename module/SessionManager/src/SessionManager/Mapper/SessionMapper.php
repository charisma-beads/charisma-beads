<?php

namespace SessionManager\Mapper;

use Common\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;

class SessionMapper extends AbstractDbMapper
{
    protected $table = 'session';
    protected $primary = 'id';

    public function gc()
    {
        $adapterPlatform = $this->getAdapter()->getPlatform();
        $expression = new Expression(
            time() . ' - ' . $adapterPlatform->quoteIdentifier('lifetime')
        );
        $where = new Where();
        $where->lessThan('modified', $expression);


        return $this->delete($where);
    }
}
