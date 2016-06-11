<?php

class ApcCacheTest extends CacheTestCase
{
    public function setUp()
    {
        if (version_compare(phpversion(),"5.5") > 0) {
            $this->markTestSkipped("apc test is only for php 5.3 and 5.4");
        }
        if (!ini_get('apc.enabled')) {
            $this->markTestSkipped("apc.enabled must be true, see 'php --ri apuc'");
        }
        if (!ini_get('apc.enable_cli')) {
            $this->markTestSkipped("apc.enable_cli must be true, see 'php --ri apuc'");
        }
    }

    /**
     * @dataProvider cacheDataProvider
     */
    public function testSimple($key, $val)
    {
        $cache = new UniversalCache\ApcCache('app_');
        $cache->set($key, $val);
        $this->assertSame($val, $cache->get($key));
        $cache->remove($key);
    }
    


}

