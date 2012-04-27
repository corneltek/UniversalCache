CacheKit
========

CacheKit interface

    $c = new CacheKit(array('Apc','MemoryCache'));

    $c = new CacheKit;
    $memory = $c->createBackend( $memcache );
    $memory->set( 'foo' , '123' );
    $memory->get('foo');


FileSystemCache

    $serializer = new SerializerKit\Serializer('json');
    $cache = new CacheKit\FileSystemCache(array( 
        'expiry' => 30,
        'cache_dir' => 'cache',
        'serializer' => $serializer,
    ));
    $cache->clear();

    $url = 'foo_bar';
    $html = 'test content';
    $cache->set( $url , $html );

    $cache->remove( $url );

    ok( null === $cache->get( $url ) );

    $cache->clear();

    ok( null === $cache->get( $url ) );

