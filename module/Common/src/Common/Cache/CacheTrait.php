<?php

declare(strict_types=1);

namespace Common\Cache;

use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Zend\Cache\Storage\TaggableInterface;

/**
 * Class CacheTrait
 *
 * @package Common\Cache
 */
trait CacheTrait
{
    protected $cache;

    protected $useCache = true;

    protected $tags = [];

    public function getCacheItem(string $id)
    {
        if (!$this->isUseCache()) return null;

        $id = $this->getCacheKey($id);

        return $this->getCache()->getItem($id);
    }

    public function setCacheItem(string $id, $item): self
    {
        if (!$this->isUseCache()) return $this;

        $id = $this->getCacheKey($id);
        $cache = $this->getCache();

        $cache->setItem($id, $item);

        if ($this->tags && $cache instanceof TaggableInterface) {
            $cache->setTags($id, $this->tags);
        }

        return $this;
    }

    public function removeCacheItem(string $id)
    {
        if (!$this->isUseCache()) return null;

        $id = $this->getCacheKey($id);
        $cache = $this->getCache();

        $this->clearCacheTags();

        return $cache->removeItem($id);
    }

    public function clearCacheTags()
    {
        $cache = $this->getCache();

        if ($this->tags && $cache instanceof TaggableInterface) {
            $cache->clearByTags($this->tags, true);
        }
    }

    public function getCacheKey(string $id): string
    {
        $key = str_replace('\\', '-', get_class($this)) . '-' . md5($id);
        return $key;
    }

    public function getCache(): ?AbstractAdapter
    {
        return $this->cache;
    }

    public function setCache(AbstractAdapter $cache): CacheStorageAwareInterface
    {
        $this->cache = $cache;
        return $this;
    }

    public function isUseCache(): bool
    {
        return ($this->cache instanceof AbstractAdapter) ? $this->useCache : false;
    }

    public function setUseCache(bool $useCache): CacheStorageAwareInterface
    {
        $this->useCache = $useCache;
        return $this;
    }
}
