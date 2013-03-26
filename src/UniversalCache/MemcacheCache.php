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
use Memcache;
use Exception;
use RuntimeException;

class MemcacheCache 
{
    private $handle;
    public $compress = false;

    /**
     * @param array $options 
     *
     *    servers [ ['localhost',65566], [...] ]
     */
    public function __construct($options = array() )
    {
        $this->handle = new Memcache;
        if ( isset($options['server']) ) {
            $server = $options['server'];
            if ( false === $this->handle->addServer( $server[0] , $server[1] ) ) {
                throw new RuntimeException("Could not add memcache server.");
            }
        }
        elseif ( isset($options['servers']) ) {
            $servers = $options['servers'];
            foreach( $servers as $server ) {
                if ( false === $this->handle->addServer( $server[0] , $server[1] ) ) {
                    throw new RuntimeException("Could not add memcache server.");
                }
            }
        }
    }

    public function getHandle()
    {
        return $this->handle;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key,$val)
    {
        return $this->set($key,$val);
    }

    public function set($key,$value,$ttl = 0)
    {
        $this->handle->set( $key , serialize( $value ) , $this->compress , $ttl );
    }

    public function get($key)
    {
        $v = $this->handle->get( $key );
        if ( $v ) {
            return unserialize($v);
        }
    }

    public function remove($key)
    {
        $this->handle->delete($key);
    }

    public function clear()
    {
        $this->handle->flush();
    }

    static function getInstance()
    {
        static $instance;
        return $instance ? $instance : $instance = new static;
    }

}

