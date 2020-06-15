<?php

namespace SessionManager\Session\SaveHandler;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
use Zend\Session\SaveHandler\DbTableGateway as ZendDbTableGateway;

class DbTableGateway extends ZendDbTableGateway
{
    /**
     * Garbage Collection
     * Only delete sessions that have expired.
     *
     * @param int $maxlifetime
     * @return true
     */
    public function gc($maxlifetime)
    {
        $platform = $this->tableGateway->getAdapter()->getPlatform();

        $where = new Where();
        $where->lessThan(
            $this->options->getModifiedColumn(),
            new Expression('(' . time() . ' - ' . $platform->quoteIdentifier($this->options->getLifetimeColumn()) . ')')
        );

        $rows = $this->tableGateway->select($where);

        $ids = [];

        /* @var \SessionManager\Model\SessionModel $row */
        foreach ($rows as $row) {
            $ids[] = $row->{$this->options->getIdColumn()};
        }

        if (count($ids) > 0) {
            $where = new Where();
            $result = (bool) $this->tableGateway->delete(
                $where->in($this->options->getIdColumn(), $ids)
            );
        } else {
            $result = false;
        }

        return $result;
    }
}
