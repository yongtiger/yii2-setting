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

/**
 * @package yongtiger\setting
 */
class Module extends \yii\base\Module
{
    /**
     * @var string The controller namespace to use
     */
    public $controllerNamespace = 'yongtiger\setting\controllers';

    ///[1.2.0 (CHG# tableName)]
    /**
     * Table name of setting
     *
     * @var string
     */
    public $settingTableName = '{{%setting}}';

    ///[1.0.1 (i18n:public static function registerTranslation)]
    /**
     * Registers the translation files
     */
    public static function registerTranslations()
    {
        ///[i18n]
        ///if no setup the component i18n, use setup in this module.
        if (!isset(Yii::$app->i18n->translations['extensions/yongtiger/yii2-setting/*']) && !isset(Yii::$app->i18n->translations['extensions/yongtiger/yii2-setting'])) {
            Yii::$app->i18n->translations['extensions/yongtiger/yii2-setting/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@vendor/yongtiger/yii2-setting/src/messages',    ///default base path is '@vendor/yongtiger/yii2-setting/src/messages'
                'fileMap' => [
                    'extensions/yongtiger/yii2-setting/message' => 'message.php',  ///category in Module::t() is message
                ],
            ];
        }
    }

    /**
     * Translates a message. This is just a wrapper of Yii::t()
     *
     * @see Yii::t()
     *
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        static::registerTranslations(); ///[1.0.1 (i18n:public static function registerTranslation)]
        return Yii::t('extensions/yongtiger/yii2-setting/' . $category, $message, $params, $language);
    }
}
