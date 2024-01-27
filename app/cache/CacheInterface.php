<?php

namespace app\cache;

interface CacheInterface
{
    public static function getInstance();

    public function set($key, $value, $seconds = 300);
    public function has($key);
    public function get($key);
    public function remove($key);
    public function clearExpired();
    public function clearAll();
}
