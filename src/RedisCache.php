<?php

namespace UniversalCache;

use Redis;

class RedisCache implements Cacher
{
    protected $conn;

    public function __construct(Redis $conn)
    {
        $this->conn = $conn;
    }

    public function get($key)
    {
        return $this->conn->get($key);
    }

    public function set($key, $val, $ttl = null)
    {
        $this->conn->set($key, $val, $ttl);
    }

    public function remove($key)
    {
        $this->conn->delete($key);
    }

    /**
     * clear() invoke flushDb method on redis connection.
     */
    public function clear()
    {
        $this->conn->flushDb();
    }
}
