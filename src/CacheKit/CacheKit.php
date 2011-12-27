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


class CacheKit 
{
    public $backends = array();

    function __construct( $backends = array() )
    {
        $this->backends = $backends;
    }

    function addBackend( $backend )
    {
        $this->backends[] = $backend;
    }

    function get( $key )
    {
        foreach( $this->backends as $b ) {
            if( ($value = $b->get( $key )) !== false ) {
                return $value;
            }
        }
    }

    function set( $key , $value , $ttl = 1000 ) 
    {
        foreach( $this->backends as $b ) {
            $b->set( $key , $value , $ttl );
        }
    }

    function remove($key)
    {
        foreach( $this->backends as $b ) {
            $b->remove( $key );
        }
    }

    function clear()
    {
        foreach( $this->backends as $b ) {
            $b->clear();
        }
    }

    function getBackends()
    {
        return $this->backends;
    }

}
