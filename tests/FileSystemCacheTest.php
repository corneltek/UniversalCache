<?php
use UniversalCache\FileSystemCache;

class FileSystemCacheTest extends CacheTestCase
{

    /**
     * @dataProvider cacheDataProvider
     */
    public function testSimple($key, $val)
    {
        $cache = new UniversalCache\FileSystemCache('cache', array( 
           'expiry' => 30,
        ));
        $cache->set($key, $val);
        $this->assertSame($val, $cache->get($key));
        $cache->clear();
    }
}

