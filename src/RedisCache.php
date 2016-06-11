<?php
/*
 * This file is part of the UniversalCache package.
 *
 * (c) Yo-An Lin <yoanlin93@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */


namespace UniversalCache;

use Redis;

class RedisCache implements Cache
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
