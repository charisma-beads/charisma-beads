<?php

declare(strict_types=1);

namespace Common\Cache;

use Zend\Cache\Storage\Adapter\AbstractAdapter;

/**
 * Interface CacheStorageAwareInterface
 *
 * @package Common\Cache
 */
interface CacheStorageAwareInterface
{
    /**
     * @return mixed
     */
    public function getCache(): ?AbstractAdapter;

    /**
     * @param AbstractAdapter $cache
     * @return mixed
     */
    public function setCache(AbstractAdapter $cache);
}
