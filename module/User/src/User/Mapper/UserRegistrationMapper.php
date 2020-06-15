<?php

declare(strict_types=1);

namespace User\Mapper;

use Common\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

class UserRegistrationMapper extends AbstractDbMapper
{
    protected $table = 'userRegistration';
    protected $primary = 'userRegistrationId';

    /**
     * @param array $search
     * @param string $sort
     * @param Select $select
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
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
}
