<?php
use UniversalCache\MemcachedCache;

class MemcachedCacheTest extends PHPUnit_Framework_TestCase
{
    public function cacheDataProvider()
    {
        return array(
            array('key','value'),
            array('key', 1),
            array('key', 1.05),
            array('key', array(0,1,2,3)),
        );
    }

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
