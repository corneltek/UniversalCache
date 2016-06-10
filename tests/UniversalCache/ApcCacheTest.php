<?php

class ApcCacheTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        if (version_compare(phpversion(),"5.5") > 0) {
            $this->markTestSkipped("apc test is only for php 5.3 and 5.4");
        }
        $cache = new UniversalCache\ApcCache('app_');
        $cache->set('key','val1');
        $cache->get('key');
    }
}

