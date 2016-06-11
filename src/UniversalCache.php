<?php
/*
 * This file is part of the UniversalCache package.
 *
 * (c) Yo-An Lin <yoanlin93@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */


namespace UniversalCache;

use Exception;

/**
 * UniversalCache class provides an interface to operate data on different 
 * cache backend,
 * you may put the fastest cache backend to the first position, so that you can 
 * fetch the cache very quickly.
 *
 *
 * e.g.,
 *
 *    use UniversalCache;
 *    $cache = new UniversalCache(array( 
 *      new ApcCache(array( 'namespace' => 'app_' )),
 *      new FileSystemCache(array( 'cache_dir' => ... ))
 *    ));
 *    $cache->set('key', 'value');
 *    $value = $cache->get('key');
 */
class UniversalCache
{
    private $backends = array();

    public function __construct(array $backends = array())
    {
        $this->backends = $backends;
    }

    public function addBackend(Cache $backend)
    {
        $this->backends[] = $backend;
    }

    /**
     * tryGet gets the cache from backend, if exception happens, 
     * it (could) log the exception and skip to the next cache backend.
     *
     * @param string $key
     */
    public function tryGet($key)
    {
        foreach ($this->backends as $b) {
            try {
                if (($value = $b->get($key)) !== false) {
                    return $value;
                }
            } catch (Exception $e) {
                // todo: shall we log this error?
                continue;
            }
        }

        return;
    }

    /**
     * Recursively get the value from backends when there is a cache.
     *
     * @param string $key
     */
    public function get($key)
    {
        foreach ($this->backends as $b) {
            if (($value = $b->get($key)) !== false) {
                return $value;
            }
        }

        return;
    }

    public function set($key, $value, $ttl = 1000)
    {
        foreach ($this->backends as $b) {
            $b->set($key, $value, $ttl);
        }
    }

    /**
     * Remove cache from every backend.
     *
     * @param string $key
     */
    public function remove($key)
    {
        foreach ($this->backends as $b) {
            $b->remove($key);
        }
    }

    /**
     * Clean up all caches from every backend.
     */
    public function clear()
    {
        foreach ($this->backends as $b) {
            $b->clear();
        }
    }

    public function getBackends()
    {
        return $this->backends;
    }
}
