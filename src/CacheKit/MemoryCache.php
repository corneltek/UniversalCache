<?php
namespace CacheKit;

class MemoryCache
    implements CacheInterface
{
    private $_cache = array();

    function get($key)
    {
        if( isset($this->_cache[ $key ] ) )
            return $this->_cache[ $key ];
    }

    function set($key,$value,$ttl = 0)
    {
        $this->_cache[ $key ] = $value;
    }

    function __set($key,$value)
    {
        $this->set($key,$value);
    }

    function __get($key)
    {
        return $this->get($key);
    }

    function remove($key)
    {
        unset( $this->_cache[ $key ] );
    }

    function clear()
    {
        $this->_cache = array();
    }

    static function getInstance()
    {
        static $instance;
        return $instance ? $instance : $instance = new static;
    }

}
