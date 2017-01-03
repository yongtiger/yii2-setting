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

namespace yongtiger\setting\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yongtiger\setting\models\SettingModel;
use yongtiger\setting\Module;
use yii\base\Model;

/**
 * SettingsController implements ONLY the UPDATE actions for Setting model. Other CRUD actions are not needed. 
 * You have to manually insert and delete data through the migration.
 *
 * @package yongtiger\setting
 */
class DefaultController extends Controller
{
    /**
     * Defines the controller behaviors
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Updates all settings in the specified category.
     *
     * ///[Yii2 setting:tabular-input]
     * @see http://www.yiiframework.com/doc-2.0/guide-input-tabular-input.html
     *
     * @param string $category
     * @return mixed
     */
    public function actionUpdate($category)
    {
        ///using indexBy() when retrieving models from the database to populate an array indexed by models primary keys. These will be later used to identify form fields.
        $settings = SettingModel::find()->where(['category' => $category])->indexBy('id')->all();

        ///Model::loadMultiple() fills multiple models with the form data coming from POST and Model::validateMultiple() validates all models at once.
        if (Model::loadMultiple($settings, Yii::$app->request->post()) && Model::validateMultiple($settings)) {

            foreach ($settings as $setting) {

                ///[Yii2 setting:multiple-select]Convert the multi-select setting value (not a string, but an array) to JSON string before saving. 
                ///because the array of multi-select values will not contain sub-array (only string or integer), so you can use json_encode converted to JSON string, e.g '["firstname","lastname","age"]'
                ///@see http://www.cnblogs.com/xmphoenix/archive/2011/05/26/2057963.html
                if(in_array($setting['input'], [SettingModel::INPUT_CHECKBOXLIST, SettingModel::INPUT_LISTBOX_MULTIPLE, SettingModel::INPUT_DROPDOWNLIST_MULTIPLE])){
                    $setting->value = json_encode($setting['value']);
                }

                $setting->save(false);  ///passing false as a parameter to save() to not run validation twice
            }

            Yii::$app->session->setFlash('success', Module::t('setting', 'Update succeed.'));
            return $this->refresh();
        }

        return $this->render('update', ['categories' => SettingModel::findAllCategories(), 'category' => $category, 'settings' => $settings]);
    }
}
