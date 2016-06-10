<?php
use UniversalCache\FileSystemCache;

class FileSystemCacheTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $cache = new UniversalCache\FileSystemCache('cache', array( 
           'expiry' => 30,
        ));

        $url = 'http://google.com';
        $cache->set( $url , $html = 'blah' );
        $html2 = $cache->get( $url );

        is( $html , $html2 );
        $cache->remove( $url );
        ok( null === $cache->get( $url ) );

        $cache->clear();
    }
}

