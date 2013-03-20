<?php


namespace UniversalCache;
use PHPUnit_Framework_TestCase;

class UniversalCacheTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $c = new UniversalCache;
        ok( $c );

        $memory = $c->createBackend( 'MemoryCache' );
        ok( $memory );

        $memory->set( 'foo' , '123' );

        ok( $memory->get('foo') );
    }
}



