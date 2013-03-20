UniversalCache
========
Generic cache interface for PHP.

### UniversalCache Interface

```php
$c = new UniversalCache;
$memory = $c->createBackend( 'MemoryCache' );

$c->set( 'foo' , 123 );

$memory->set( 'foo' , '123' );
$val = $memory->get('foo');
```

### ApcCache Interface

```php
$cache = new UniversalCache\ApcCache(array( 
    'namespace' => 'app_',
    'default_expiry' => 3600,
));
$cache->set($name,$val);
$val = $cache->get($name);
$cache->remove($name);
```


### FileSystemCache

```
$serializer = new SerializerKit\Serializer('json');
$cache = new UniversalCache\FileSystemCache(array( 
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
```

