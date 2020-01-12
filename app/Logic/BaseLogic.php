<?php

namespace App\Logic;


class BaseLogic
{
    /**
     *
     * Instances of the derived classes.
     * @var array
     */
    protected static $instances = array();
    /**
     * Get instance of the derived class.
     * @param bool $singleton 是否获取单件,默认 true.
     * @return static
     */
    public static function instance($singleton = true)
    {
        $className = get_called_class();
        if (!$singleton) {
            return new $className;
        }
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className;
        }
        return self::$instances[$className];
    }
}