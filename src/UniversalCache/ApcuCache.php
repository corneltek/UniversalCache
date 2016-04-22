<?php
/*
 * This file is part of the UniversalCache package.
 *
 * (c) Yo-An Lin <cornelius.howl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
namespace UniversalCache;

class ApcuCache
{
    public $namespace = '';

    public $defaultExpiry = 0;

    public function __construct($namespace, $defaultExpiry = 0) {
    {
        $this->namespace = $namespace;
        $this->defaultExpiry = $defaultExpiry;
    }

    public function get($key)
    {
        return apcu_fetch( $this->namespace . ':' . $key );
    }

    public function set($key,$value,$ttl = null)
    {
        if( null === $ttl && $this->defaultExpiry )
            $ttl = $this->defaultExpiry;
        apcu_store( $this->namespace . ':' . $key , $value , $ttl );
    }

    public function remove($key)
    {
        apcu_delete( $this->namespace . ':' . $key );
    }

    public function clear()
    {
        apcu_clear_cache();
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name,$value)
    {
        $this->set($name,$value);
    }

    static function getInstance()
    {
        static $instance;
        return $instance ? $instance : $instance = new static;
    }

}


