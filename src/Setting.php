<?php ///[Yii2 setting]

/**
 * Yii2 setting
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-setting
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2016 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\setting;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Setting
 *
 * Only for the frontend settings!
 * The first time to read settings, read the database settings table into the cache if the cache, and then read directly from the cache later.
 * To improve efficiency, use static array to storage settings.
 *
 * Note: If it needs to be run before the application instantiates initialization, you have to load cache and db with Yii::$container, not Yii::$app->cache.    ///???
 *
 * @package yongtiger\setting
 */
class Setting
{
    /**
     * Static array of setting
     *
     * @var null|array
     */
    public static $setting;

    /**
     * Enable cache or not
     *
     * @var bool
     */
    public static $enableCaching = true;

    /**
     * Table name of setting
     *
     * @var string
     */
    public static $tableName = '{{%setting}}';

    /**
     * Type setting of (string)
     */
    const TYPE_STRING = 'string';
    /**
     * Type setting of (integer)
     */
    const TYPE_INTEGER = 'integer';
    /**
     * Type setting of (float)
     */
    const TYPE_FLOAT = 'float';
    /**
     * Type setting of (boolean)
     */
    const TYPE_BOOLEAN = 'boolean';
    /**
     * Type setting of (array)
     */
    const TYPE_ARRAY = 'array';
    /**
     * Type setting of (object)
     */
    const TYPE_OBJECT = 'object';

    /**
     * Gets the setting value for the specified category and key
     *
     * @param string $category
     * @param string $key
     * @param string $default
     *
     * @return array
     */
    public static function get($category, $key, $default = null)
    {
        ///if self::$setting is null, indicates that the settings are not loaded. Then get self::$setting by calling static::loadSetting().
        ///if self::$setting is empty and not null, indicates that the settings have already been loaded, but no record in db.
        if (!isset(static::$setting)) {
            static::$setting = static::loadSetting();
        }

        ///determines whether the element specified in the array self :: $ setting exists.
        ///returns the element if it is present, otherwise returns the default.
        ///note: if self::$setting is null or empty array [], isset(static::$setting[$category][$key]) will return false.
        // return isset(static::$setting[$category][$key]) ? static::$setting[$category][$key] : $default;
        return isset(static::$setting[$category][$key]) ? static::convertType(static::$setting[$category][$key]['value'], static::$setting[$category][$key]['type']) : $default;
    }

    /**
     * Sets the setting value for the specified category and key
     *
     * @param string $category
     * @param string $key
     * @param mix $value
     */
    public static function set($category, $key, $value)
    {
        $type = static::getType($value);
        $value = static::convertValueToString($value);

        ///read from setting table
        ///if no setting record in db, return empty array [].
        $result = Yii::$app->db->createCommand("SELECT `id` FROM " . static::$tableName . " where `category`='$category' and `key`='$key'")->queryOne();

        if ($result) {
            Yii::$app->db->createCommand()->update(static::$tableName, [
                'category' => $category,
                'key' => $key,
                'value' => $value,
                'type' => $type,
            ], '`id` = ' . $result['id'])->execute();
        } else {
            Yii::$app->db->createCommand()->insert(static::$tableName, [
                'category' => $category,
                'key' => $key,
                'value' => $value,
                'type' => $type,
            ])->execute();
        }

        ///if self::$enableCaching is true, and Yii::$app->cache is an instance object, and 
        ///if there is a setting value in the cache, then clear it.
        if (static::$enableCaching && is_object(Yii::$app->cache) &&
            ($setting = Yii::$app->cache->get('setting')) !== false) {
            Yii::$app->cache->delete('setting');    ///???need to clear cache in both frontend and backend!!!
        }
    }

    /**
     * Loads setting
     *
     * @return array
     *
     * If the cache is set, it is loaded from the cache, otherwise loaded from the database.
     * if no setting record in db, return empty array [].
     */
    public static function loadSetting()
    {
        ///if self::$enableCaching is true, and Yii::$app->cache is an instance object, then save setting to cache.
        ///if there is a setting value in the cache, that is means Yii::$app->cache->get('setting') is not false, then return it.
        if (static::$enableCaching && is_object(Yii::$app->cache) &&
            ($setting = Yii::$app->cache->get('setting')) !== false) {
            return $setting;
        }

        ///read from setting table
        ///if no setting record in db, return empty array [].
        $result = Yii::$app->db->createCommand('SELECT `category`, `key`, `value`, `type` FROM ' . static::$tableName)->queryAll();

        ///convert query result, that is array [['category'=>'c', 'key'=>'k', 'value'=>'v'], ...], into a setting array [['c']['k']=>v, ...].
        // $setting = ArrayHelper::map($result, 'key', 'value', 'category');
        ///convert query result, that is array[['category'=>'c', 'key'=>'k', 'value'=>'v', 'type'=>'k'], ...], into a setting array [['c']['k']=>[v,t], ...]）
        $setting = ArrayHelper::map(
            $result,
            'key',
            function($element){
                return ['value'=>$element['value'], 'type'=>$element['type']];
            },
            'category'
        );

        ///if self::$enableCaching is true, and Yii::$app->cache is an instance object, then save setting to cache.
        if (static::$enableCaching && is_object(Yii::$app->cache)) {
            Yii::$app->cache->set('setting', $setting);  ///if no setting record in db, the content of cache file will be: 'a:2:{i:0;a:0:{}i:1;N;}'
        }

        return $setting;
    }

    /**
     * Converts a string type value to the given type
     *
     * @param string $value
     * @param int $type
     *
     * @return mixed|false
     */
    public static function convertType($value, $type = null) {
        if(!isset($type)) return $value;

        switch ($type){
        case static::TYPE_STRING:
            return $value;
        case static::TYPE_INTEGER:
            return (int)$value;
        case static::TYPE_FLOAT:
            return (float)$value;
        case static::TYPE_BOOLEAN:
            return (boolean)$value;
        case static::TYPE_ARRAY:
            return unserialize($value);
        case static::TYPE_OBJECT:
            return unserialize($value);
        default:
            return false;
        }
    }

    /**
     * Gets value type
     *
     * @param mix $value
     *
     * @return string|false
     */
    public static function getType($value) {
        if (is_string($value)) {
            return static::TYPE_STRING;
        } else if (is_integer($value)) {
            return static::TYPE_INTEGER;
        } else if (is_float($value)) {
            return static::TYPE_FLOAT;
        } else if (is_bool($value)) {
            return static::TYPE_BOOLEAN;
        } else if (is_array($value)) {
            return static::TYPE_ARRAY;
        } else if (is_object($value)) {
            return static::TYPE_OBJECT;
        } else {
            return false;
        }
    }

    /**
     * Converts given value to string
     *
     * @param mix $value
     *
     * @return string|false
     */
    public static function convertValueToString($value) {
        $type = getType($value);

        switch ($type){
        case static::TYPE_STRING:
            return $value;
        case static::TYPE_INTEGER:
            return (string)$value;
        case static::TYPE_FLOAT:
            return (string)$value;
        case static::TYPE_BOOLEAN:
            return (string)$value;
        case static::TYPE_ARRAY:
            return serialize($value);
        case static::TYPE_OBJECT:
            return serialize($value);
        default:
            return false;
        }
    }
}
