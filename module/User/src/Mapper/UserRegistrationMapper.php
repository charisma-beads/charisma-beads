<?php

declare(strict_types=1);

namespace User\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Expression;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;

class UserRegistrationMapper extends AbstractDbMapper
{
    protected $table = 'userRegistration';
    protected $primary = 'userRegistrationId';

    /**
     * @param array $search
     * @param string $sort
     * @param Select $select
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {
        $select = $this->getSelect()
            ->join(
                'user',
                'userRegistration.userId=user.userId',
                [],
                Select::JOIN_LEFT
            );

        if (str_replace('-', '', $sort) == 'name') {
            if (strchr($sort, '-')) {
                $sort = ['-user.lastname', '-user.firstname'];
            } else {
                $sort = ['user.lastname', 'user.firstname'];
            }
        }

        return parent::search($search, $sort, $select);
    }

    public function deleteInvalidRegistrations()
    {
        //$expression = new Expression('dateCreated < (NOW() - INTERVAL 2 DAY)');
        $where = new Where();
        $where->lessThan('requestTime', new Expression('NOW() - INTERVAL 2 DAY'))
            ->and
            ->equalTo('responded', 0);
        return $this->delete($where);
    }
}
