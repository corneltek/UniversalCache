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
    public $namespace = '';

    public $defaultExpiry = 0;

    function __construct( $options = array() )
    {
        if( isset($options['namespace']) )
            $this->namespace = $options['namespace'];
        if( isset($options['default_expiry'] ) )
            $this->defaultExpiry = $options['default_expiry'];
    }

    function get($key)
    {
        return apc_fetch( $this->namespace . ':' . $key );
    }

    function set($key,$value,$ttl = null)
    {
        if( null === $ttl && $this->defaultExpiry )
            $ttl = $this->defaultExpiry;
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

    static function getInstance()
    {
        static $instance;
        return $instance ? $instance : $instance = new static;
    }

}


