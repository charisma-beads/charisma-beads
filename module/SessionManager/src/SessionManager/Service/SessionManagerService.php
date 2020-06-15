<?php

namespace SessionManager\Service;

use Common\Service\AbstractMapperService;
use SessionManager\Hydrator\SessionHydrator;
use SessionManager\Mapper\SessionMapper;
use SessionManager\Model\SessionModel;

class SessionManagerService extends AbstractMapperService
{
    protected $hydrator     = SessionHydrator::class;
    protected $mapper       = SessionMapper::class;
    protected $model        = SessionModel::class;

    /**
     * @var bool
     */
    protected $useCache = false;

    public function getById($id, $col = null)
    {
        $id = (string) $id;
        return $this->getMapper()->getById($id);
    }

    public function gc()
    {
        return $this->getMapper()->gc();
    }
}
