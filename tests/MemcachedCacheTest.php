<?php
use UniversalCache\MemcachedCache;

class MemcachedCacheTest extends CacheTestCase
{
    /**
     * @dataProvider cacheDataProvider
     */
    public function testSimple($key, $val)
    {
        $cache = new MemcachedCache(['servers' => [['localhost', 11211]]]);
        $cache->set($key, $val);
        $this->assertSame($val, $cache->get($key));
    }
}
