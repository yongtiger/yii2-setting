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

namespace yongtiger\setting\models;

use Yii;
use yii\db\ActiveRecord;
use yongtiger\setting\Module;

/**
 * This is the model class for table "setting".
 *
 * @property string $id
 * @property string $category
 * @property string $key
 * @property string $value
 * @property string $type
 * @property string $input
 * @property string $items
 * @property string $options
 * @property string $label_options
 * @property string $hint
 * @property string $hint_options


 */
class SettingModel extends ActiveRecord
{
    /**
     * Form input fields
     *
     * Taking into account the expansion of compatibility, using \kartik\widgets\ActiveForm naming.
     * @see http://demos.krajee.com/builder-details/form#settings
     */
    const INPUT_TEXTINPUT = 'textInput';
    const INPUT_TEXTAREA = 'textarea';

    const INPUT_RADIO = 'radio';
    const INPUT_RADIOLIST = 'radioList';

    const INPUT_CHECKBOX = 'checkbox';
    const INPUT_CHECKBOXLIST = 'checkboxList';          ///multiple-select

    const INPUT_LISTBOX = 'listBox';                    ///sub-array nested
    const INPUT_LISTBOX_MULTIPLE = 'multiselect';       ///multiple-select, sub-array nested

    const INPUT_DROPDOWNLIST = 'dropdownList';          ///sub-array nested
    const INPUT_DROPDOWNLIST_MULTIPLE = 'multiselect';  ///multiple-select, sub-array nested    ///same as INPUT_LISTBOX_MULTIPLE


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->controller->module->settingTableName;  ///[1.2.0 (CHG# tableName)]
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'safe'],    
        ];
    }

    /**
     * Find All Setting Categories
     *
     * @return array
     */
    public static function findAllCategories()
    {
        return static::find()->select('category')->groupBy('category')->orderBy('id')->all();
    }
}
