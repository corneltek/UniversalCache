<?php
use UniversalCache\UniversalCache;

class UniversalCacheTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $memory = UniversalCache::create('MemoryCache');
        ok( $memory );
        $memory->set( 'foo' , '123' );
        ok( $memory->get('foo') );

        $c = new UniversalCache(array($memory));
        ok( $c );
        ok( $c->get('foo') );
    }
}



