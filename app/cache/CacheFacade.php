<?php

namespace app\cache;

class CacheFacade
{
    private static $instance;
    private static $cacheType = 'array';

    public static function setCacheType($cacheType)
    {
        self::$cacheType = $cacheType;
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = self::createInstance();
        }

        return self::$instance;
    }

    private static function createInstance()
    {
        switch (strtolower(self::$cacheType)) {
            case 'array':
                return CacheArray::getInstance();
        }
    }
}
