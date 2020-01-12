<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $guarded = [];
    public $timestamps = false;

    /**
     * Description:  获取表名
     * Author: hp <xcf-hp@foxmail.com>
     * Updater:
     * @return string
     */
    public static function tableName(){
        return self::instance()->getTable();
    }

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