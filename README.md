UniversalCache
========

[![Build Status](https://travis-ci.org/corneltek/UniversalCache.svg?branch=master)](https://travis-ci.org/corneltek/UniversalCache)
[![Latest Stable Version](https://poser.pugx.org/corneltek/universal-cache/v/stable)](https://packagist.org/packages/corneltek/universal-cache)
[![Total Downloads](https://poser.pugx.org/corneltek/universal-cache/downloads)](https://packagist.org/packages/corneltek/universal-cache)

A Generic Cache Interface for PHP.


## DESCRIPTION

This package was inspired by a Perl module - Cache::Cascade.

> In a multiprocess, and especially a multiserver application caching is a very effective means of improving results.

> The tradeoff of increasing the scale of the caching is in added complexity. For example, caching in a FastMmap based storage is much slower than using a memory based cache, because pages must be locked to ensure that no corruption will happen. Likewise Memcached is even more overhead than FastMmap because it is network bound, and uses blocking IO (on the client side).

> This module attempts to make a transparent cascade of caches using several backends.

> The idea is to search from the cheapest backend to the most expensive, and depending on the options also cache results in the cheaper backends.

> The benefits of using a cascade are that if the chance of a hit is much higher in a slow cache, but checking a cheap cache is negligible in comparison, we may already have the result we want in the cheap cache. Configure your expiration policy so that there is approximately an order of magnitude better probability of cache hits (bigger cache) for each level of the cascade.



### UniversalCache Interface

UniversalCache class provides an interface to operate on different cache backend,
you may put the fastest cache backend to the first position, so that 
you can fetch the cache very quickly.

```php
use UniversalCache\UniversalCache;
use UniversalCache\ApcuCache;
use UniversalCache\FileSystemCache;

$cache = new UniversalCache(array( 
    new ApcuCache(array( 'namespace' => 'app_' )),
    new FileSystemCache(array( 'cache_dir' => ... ))
));
$cache->set('key', 'value');
$value = $cache->get('key');
```

### ApcuCache

```php
$cache = new UniversalCache\ApcuCache(array( 
    'namespace' => 'app_',
    'default_expiry' => 3600,
));
$cache->set($name,$val);
$val = $cache->get($name);
$cache->remove($name);
```

### MemoryCache

```php
$cache = new UniversalCache\MemoryCache;
$cache->set($name,$val);
$val = $cache->get($name);
$cache->remove($name);
```

### MemcacheCache

```php
$cache = new UniversalCache\MemcacheCache(array( 
    'servers' => [ ['localhost', 123123], ['server2',123123] ]
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


Hacking
===========

    composer install --prefer-source
    phpunit

