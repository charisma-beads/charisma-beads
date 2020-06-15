<?php

declare(strict_types=1);

namespace User\Mapper;

use User\Hydrator\UserHydrator;
use Common\Mapper\AbstractDbMapper;
use User\Model\UserModel as UserModel;
use Zend\Db\Sql\Select;

class UserMapper extends AbstractDbMapper
{
    protected $table = 'user';
    protected $primary = 'userId';

    /**
     * @param int $id
     * @param null $col
     * @return array|UserModel
     */
    public function getById($id, $col = null)
    {
        /* @var $hydrator UserHydrator */
        $hydrator = $this->getResultSet()->getHydrator();
        $hydrator->emptyPassword();
        return parent::getById($id);
    }

    public function getAdminUserByEmail(string $email, ?string $ignore, bool $emptyPassword, bool $activeOnly): ?UserModel
    {
        if ($emptyPassword) {
            /* @var $hydrator UserHydrator */
            $hydrator = $this->getResultSet()->getHydrator();
            $hydrator->emptyPassword();
        }

        $select = $this->getSelect();

        $select->where
            ->equalTo('email', $email)
            ->and
            ->equalTo('role', 'admin');

        if ($ignore) {
            $select->where->notEqualTo('email', $ignore);
        }

        if ($activeOnly) {
            $select->where->equalTo('active', 1);
        }

        $rowSet = $this->fetchResult($select);
        $row    = $rowSet->current() ?: new UserModel();

        return $row;
    }

    public function getUserByEmail(string $email, ?string $ignore, bool $emptyPassword, bool $activeOnly): UserModel
    {
        if ($emptyPassword) {
            /* @var $hydrator UserHydrator */
            $hydrator = $this->getResultSet()->getHydrator();
            $hydrator->emptyPassword();
        }

        $select = $this->getSelect()
            ->where(['email' => $email]);

        if ($ignore) {
            $select->where->notEqualTo('email', $ignore);
        }

        if ($activeOnly) {
            $select->where->equalTo('active', 1);
        }

        $rowSet = $this->fetchResult($select);
        $row    = $rowSet->current() ?: new UserModel();

        return $row;
    }

    /**
     * @param array $search
     * @param string $sort
     * @param Select $select
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {
        if (str_replace('-', '', $sort) == 'name') {
            if (strchr($sort, '-')) {
                $sort = ['-lastname', '-firstname'];
            } else {
                $sort = ['lastname', 'firstname'];
            }
        }

        return parent::search($search, $sort, $select);
    }
}
