<?php

class ApcCacheTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $cache = new CacheKit\ApcCache(array( 
            'namespace' => 'app_'
        ));
        ok($cache);
        $cache->set('key','val1');
        $cache->get('key');
    }
}

