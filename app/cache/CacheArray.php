<?php

namespace app\cache;

class CacheArray implements CacheInterface
{
    private static $instance;
    private $cache = [];

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new CacheArray();
        }

        return self::$instance;
    }

    public function set($key, $value, $seconds = 300)
    {
        $expiration_time = time() + $seconds;
        $this->cache[$key] = ["value" => $value, "expiration" => $expiration_time];
    }

    public function has($key)
    {
        return isset($this->cache[$key]) && $this->cache[$key]["expiration"] > time();
    }

    public function get($key)
    {
        if ($this->has($key)) {
            return $this->cache[$key]["value"];
        }

        unset($this->cache[$key]);
        return null;
    }

    public function remove($key)
    {
        unset($this->cache[$key]);
    }

    public function clearExpired()
    {
        foreach ($this->cache as $key => $item) {
            if ($item["expiration"] <= time()) {
                unset($this->cache[$key]);
            }
        }
    }

    public function clearAll()
    {
        foreach ($this->cache as $key => $item) {
            unset($this->cache[$key]);
        }
    }
}
