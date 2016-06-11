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
use ReflectionClass;
use Exception;


/**
 * UniversalCache class provides an interface to operate data on different 
 * cache backend,
 * you may put the fastest cache backend to the first position, so that you can 
 * fetch the cache very quickly.
 *
 *
 * e.g.,
 *
 *    use UniversalCache;
 *    $cache = new UniversalCache(array( 
 *      new ApcCache(array( 'namespace' => 'app_' )),
 *      new FileSystemCache(array( 'cache_dir' => ... ))
 *    ));
 *    $cache->set('key', 'value');
 *    $value = $cache->get('key');
 *
 */

class UniversalCache 
{
    private $backends = array();

    public function __construct($backends)
    {
        $this->backends = (array)$backends;
    }

    public function addBackend( $backend )
    {
        $this->backends[] = $backend;
    }

    public function get( $key )
    {
        foreach( $this->backends as $b ) {
            if( ($value = $b->get( $key )) !== false ) {
                return $value;
            }
        }
    }

    public function set( $key , $value , $ttl = 1000 ) 
    {
        foreach( $this->backends as $b ) {
            $b->set( $key , $value , $ttl );
        }
    }

    public function remove($key)
    {
        foreach( $this->backends as $b ) {
            $b->remove( $key );
        }
    }

    public function clear()
    {
        foreach( $this->backends as $b ) {
            $b->clear();
        }
    }

    public function getBackends()
    {
        return $this->backends;
    }

    public static function create()
    {
        $args = func_get_args();
        $class = array_shift( $args );
        $backendClass = '\\UniversalCache\\' . $class;
        $rc = new ReflectionClass($backendClass);
        $b = $rc->newInstanceArgs($args);

        // $b = call_user_func_array( array($backendClass,'new') , $args );
        // $b = new $backendClass( $args );
        return $b;
    }

}
