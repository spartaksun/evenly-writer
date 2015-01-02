<?php

class ConfigLoader
{

    private static $_config;

    public static function load($key)
    {
        if (empty(self::$_config)) {
            self::$_config = include('config.php');
            self::validateConfig();
        }
        return isset(self::$_config[$key]) ? self::$_config[$key] : array();
    }

    private function validateConfig()
    {
        if (
            !is_array(self::$_config) ||
            empty(self::$_config['writer']) ||
            empty(self::$_config['db']) ||
            empty(self::$_config['folders'])
        ) {
            throw new WriterException('Invalid config');
        }
    }
}