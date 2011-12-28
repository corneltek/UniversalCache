<?php
namespace CacheKit;

class MemoryCache
    extends CacheInterface
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

    function remove($key)
    {
        unset( $this->_cache[ $key ];
    }

    function clear()
    {
        $this->_cache = array();
    }
}
