<?php

namespace Common\Mapper;

use Laminas\Db\Adapter\Adapter;


interface DbAdapterAwareInterface
{
    /**
     * @return Adapter
     */
    public function getAdapter();

    /**
     * @param Adapter $dbAdapter
     * @return $this
     */
    public function setDbAdapter(Adapter $dbAdapter);
}
