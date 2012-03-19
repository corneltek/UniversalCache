<?php
namespace CacheKit;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class FileSystemCache
 implements CacheInterface
{
    public $expiry; // seconds

    public $filenameBuilder;

    function __construct($options = array() )
    {
        if( isset($options['expiry']) )
            $this->expiry = $options['expiry'];

        if( isset($options['cache_dir']) )
            $this->cacheDir = $options['cache_dir'];
        else
            $this->cacheDir = 'cache';

        if( ! file_exists($this->cacheDir) )
            mkdir($this->cacheDir, 0755, true );


        $this->filenameBuilder = function($key) {
            return preg_replace('#\W+#','_',$key);
        };
    }

    function _getCacheFilepath($key)
    {
        $filename = call_user_func($this->filenameBuilder,$key);
        return $this->cacheDir . DIRECTORY_SEPARATOR . $filename;
    }

    function get($key) 
    {
        $path = $this->_getCacheFilepath($key);

        if( ! file_exists($path) )
            return null;

        // is expired ?
        if( $this->expiry && (time() - filemtime($path)) > $this->expiry ) {
            return null;
        }
        return file_get_contents($path);
    }

    function set($key,$value,$ttl = 0) 
    {
        $path = $this->_getCacheFilepath($key);
        return file_put_contents($path, $value) !== false;
    }

    function remove($key) 
    {
        $path = $this->_getCacheFilepath($key);
        if( file_exists($path) )
            unlink( $path );
    }

    function clear() {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->cacheDir),
                                                RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $path) {
            if( $path->isFile() ) {
                unlink( $path->__toString() );
            }
        }
    }
}





