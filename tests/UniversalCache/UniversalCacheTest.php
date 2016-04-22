<?php
use UniversalCache\UniversalCache;

class UniversalCacheTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $memory = UniversalCache::create('MemoryCache');
        $memory->set( 'foo' , '123' );
        $this->assertEquals('123',$memory->get('foo'));

        $c = new UniversalCache(array($memory));
        $this->assertEquals('123',$c->get('foo'));
    }
}



