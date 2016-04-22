<?php

class ApcCacheTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $cache = new UniversalCache\ApcCache('app_');
        $cache->set('key','val1');
        $cache->get('key');
    }
}

