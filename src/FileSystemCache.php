<?php

namespace UniversalCache;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class FileSystemCache implements Cacher
{
    public $expiry; // seconds

    public $filenameBuilder;

    protected $serializer;

    public $cacheDir;

    public $umask = 0777;

    public function __construct($cacheDir, array $options = array())
    {
        $this->cacheDir = $cacheDir;
        if (isset($options['expiry'])) {
            $this->expiry = $options['expiry'];
        }
        if (isset($options['serializer'])) {
            $this->serializer = $options['serializer'];
        }
        $this->filenameBuilder = function ($key) {
            return preg_replace('#\W+#', '_', $key);
        };
    }

    private function _getCacheFilepath($key)
    {
        $filename = preg_replace('#\W+#', '_', $key);
        $fregdir = $this->cacheDir.DIRECTORY_SEPARATOR.crc32($key);
        if (!file_exists($fregdir)) {
            mkdir($fregdir, $this->umask, true);
        }

        return $fregdir.DIRECTORY_SEPARATOR.$filename;
    }

    private function _decodeFile($file)
    {
        $content = file_get_contents($file);
        if ($this->serializer) {
            return $this->serializer->decode($content);
        }

        return unserialize($content);
    }

    private function _encodeFile($file, $data)
    {
        $content = null;
        if ($this->serializer) {
            $content = $this->serializer->encode($data);
        } else {
            $content = serialize($data);
        }

        return file_put_contents($file, $content);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $val)
    {
        return $this->set($key, $val);
    }

    public function get($key)
    {
        $path = $this->_getCacheFilepath($key);

        if (!file_exists($path)) {
            return;
        }

        // is expired ?
        if ($this->expiry && (time() - filemtime($path)) > $this->expiry) {
            return;
        }

        return $this->_decodeFile($path);
    }

    public function set($key, $value, $ttl = 0)
    {
        if ($path = $this->_getCacheFilepath($key)) {
            return $this->_encodeFile($path, $value) !== false;
        }
    }

    public function remove($key)
    {
        if ($path = $this->_getCacheFilepath($key)) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public function clear()
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->cacheDir),
                                                RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $path) {
            if ($path->isFile()) {
                unlink($path->__toString());
            }
        }
    }
}
