<?php
/*
 * This file is part of the CacheKit package.
 *
 * (c) Yo-An Lin <cornelius.howl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
namespace CacheKit;

class ApcCache
    implements CacheInterface
{
    public $namespace;

    function __construct( $namespace = '' )
    {
        $this->namespace = $namespace;
    }

    function get($key)
    {
        return apc_fetch( $this->namespace . ':' . $key );
    }

    function set($key,$value,$ttl = 0)
    {
        apc_store( $this->namespace . ':' . $key , $value , $ttl );
    }

    function remove($key)
    {
        apc_delete( $this->namespace . ':' . $key );
    }

    function clear()
    {
        apc_clear_cache();
    }
}


