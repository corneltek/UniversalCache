UniversalCache
========

[![Build Status](https://travis-ci.org/corneltek/UniversalCache.svg?branch=master)](https://travis-ci.org/corneltek/UniversalCache)
[![Latest Stable Version](https://poser.pugx.org/corneltek/universal-cache/v/stable)](https://packagist.org/packages/corneltek/universal-cache)
[![Latest Unstable Version](https://poser.pugx.org/corneltek/universal-cache/v/unstable)](https://packagist.org/packages/corneltek/universal-cache)
[![Total Downloads](https://poser.pugx.org/corneltek/universal-cache/downloads)](https://packagist.org/packages/corneltek/universal-cache)
[![Monthly Downloads](https://poser.pugx.org/corneltek/universal-cache/d/monthly)](https://packagist.org/packages/corneltek/universal-cache)
[![License](https://poser.pugx.org/corneltek/universal-cache/license)](https://packagist.org/packages/corneltek/universal-cache)

A Generic PHP Cache Interface with Cascade Caching.

## DESCRIPTION

This package was inspired by a Perl module - Cache::Cascade.

> In a multiprocess, and especially a multiserver application caching is a very effective means of improving results.

> The tradeoff of increasing the scale of the caching is in added complexity. For example, caching in a FastMmap based storage is much slower than using a memory based cache, because pages must be locked to ensure that no corruption will happen. Likewise Memcached is even more overhead than FastMmap because it is network bound, and uses blocking IO (on the client side).

> This module attempts to make a transparent cascade of caches using several backends.

> The idea is to search from the cheapest backend to the most expensive, and depending on the options also cache results in the cheaper backends.

> The benefits of using a cascade are that if the chance of a hit is much higher in a slow cache, but checking a cheap cache is negligible in comparison, we may already have the result we want in the cheap cache. Configure your expiration policy so that there is approximately an order of magnitude better probability of cache hits (bigger cache) for each level of the cascade.


## INSTALL

    composer require corneltek/universal-cache

### UniversalCache

UniversalCache class provides a consistent interface to operate on different
cache backend, you may put the fastest cache backend on the first position, so
that you can fetch the cache very quickly when there is a fresh cache in the
fastest storage.

```php
use UniversalCache\ApcuCache;
use UniversalCache\FileSystemCache;
use UniversalCache\UniversalCache;

$cache = new UniversalCache([
    new ArrayCache, // Fetch cache without serialization if there is a request-wide cache exists.
    new ApcuCache('app_', 60), // Faster then file system cache.
    new FileSystemCache(__DIR__ . '/cache'),
]);
$cache->set('key', 'value');
$value = $cache->get('key');
```

### ApcuCache

```php
$cache = new UniversalCache\ApcuCache('app_', 3600); // 3600 = expiry time
$cache->set($name,$val);
$val = $cache->get($name);
$cache->remove($name);
```

### ArrayCache

ArrayCache implements a pure php based cache, the cache is not persistent
between different request. However, it made the request-wide cache simple.

```php
$cache = new UniversalCache\ArrayCache;
$cache->set($name,$val);
$val = $cache->get($name);
$cache->remove($name);
```

### MemcacheCache

```php
$cache = new UniversalCache\MemcacheCache([
    'servers' => [['localhost', 123123], ['server2',123123] ]
]);
$cache->set($name,$val);
$val = $cache->get($name);
$cache->remove($name);
```

### RedisCache

```php
$cache = new UniversalCache\RedisCache($redisConnection);
$cache->set($name,$val);
$val = $cache->get($name);
$cache->remove($name);
```


### FileSystemCache

```php
$serializer = new SerializerKit\JsonSerializer();
$cache = new UniversalCache\FileSystemCache(__DIR__ . '/cache', [
    'expiry' => 30,
    'serializer' => $serializer,
]);
```



Hacking
===========

Install dependencies

    composer install --prefer-source

Install redis extension

    phpbrew ext install github:phpredis/phpredis php7

Install memcached extension

    phpbrew ext install github:php-memcached-dev/php-memcached php7 -- --disable-memcached-sasl

Install APCu extension

    phpbrew ext install github:krakjoe/apcu

Run tests

    phpunit


## LICENSE

This package is released under MIT license.
