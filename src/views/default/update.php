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

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yongtiger\setting\models\SettingModel;
use yongtiger\setting\Module;
use yii\helpers\ArrayHelper;
?>

<h1><?= Html::encode($category) ?></h1>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php ///[tabular-input]
    ///@see http://www.yiiframework.com/doc-2.0/guide-input-tabular-input.html
    ///it is important to add a proper index to input name since that is how Model::loadMultiple() determines which model to fill with which values.
    foreach ($settings as $index => $setting) { ?>

        <div class="form-group">

        <?php

        ///$setting['items'], $setting['options'] and $setting['labeloptions'] are strings of JSON object, e.g '{"prompt":"(Please select ...)", "options":{"value":"disabled"}}'
        ///@see ///@see http://www.cnblogs.com/xmphoenix/archive/2011/05/26/2057963.html
        ///if not null or empty string, convert to array (can has sub-array nested).
        $setting['options'] = $setting['options'] ? ArrayHelper::toArray(json_decode($setting['options'])) : [];
        $setting['label_options'] = $setting['label_options'] ? ArrayHelper::toArray(json_decode($setting['label_options'])) : [];
        if(in_array($setting['input'], [SettingModel::INPUT_RADIOLIST, SettingModel::INPUT_CHECKBOXLIST, SettingModel::INPUT_LISTBOX, SettingModel::INPUT_LISTBOX_MULTIPLE, SettingModel::INPUT_DROPDOWNLIST, SettingModel::INPUT_DROPDOWNLIST_MULTIPLE])){
            $setting['items'] = $setting['items'] ? ArrayHelper::toArray(json_decode($setting['items'])) : [];
        }

        switch ($setting['input']) {
        case SettingModel::INPUT_TEXTAREA:
            $field = $form->field($setting, "[$index]value")->textarea($setting['options']);
            break;
        case SettingModel::INPUT_RADIO:
            ///@see http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#radio()-detail
            $field = $form->field($setting, "[$index]value")->radio($setting['options'], false);
            break;
        case SettingModel::INPUT_RADIOLIST:
            $field = $form->field($setting, "[$index]value")->radioList($setting['items'], $setting['options']);
            break;
         case SettingModel::INPUT_CHECKBOX:
            ///@see http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#checkbox()-detail
            $field = $form->field($setting, "[$index]value")->checkbox($setting['options'], false);
            break;
        case SettingModel::INPUT_CHECKBOXLIST:
            ///[Yii2 setting:multiple-select]
            $setting->value = json_decode($setting['value']);
            $field = $form->field($setting, "[$index]value")->checkboxList($setting['items'], $setting['options']);
            break;
        case SettingModel::INPUT_LISTBOX:                   ///sub-array nested
            $setting['options'] = array_merge(['prompt' => Module::t('message', 'Please select ...')], $setting['options']);
            $field = $form->field($setting, "[$index]value")->listBox($setting['items'], $setting['options']);
            break;
        case SettingModel::INPUT_LISTBOX_MULTIPLE:          ///sub-array nested
            ///[Yii2 setting:multiple-select]
            $setting->value = json_decode($setting['value']);
            $setting['options'] = array_merge(['prompt' => Module::t('message', 'Please select ...'), 'multiple' => 'true'], $setting['options']);
            $field = $form->field($setting, "[$index]value")->listBox($setting['items'], $setting['options']);
            break;
        case SettingModel::INPUT_DROPDOWNLIST:              ///sub-array nested
            $setting['options'] = array_merge(['prompt' => Module::t('message', 'Please select ...')], $setting['options']);
            $field = $form->field($setting, "[$index]value")->dropDownList($setting['items'], $setting['options']);
            break;
        case SettingModel::INPUT_DROPDOWNLIST_MULTIPLE:     ///sub-array nested    ///same as INPUT_LISTBOX_MULTIPLE
            ///[Yii2 setting:multiple-select]
            $setting->value = json_decode($setting['value']);
            $setting['options'] = array_merge(['prompt' => Module::t('message', 'Please select ...'), 'multiple' => 'true'], $setting['options']);
            $field = $form->field($setting, "[$index]value")->dropDownList($setting['items'], $setting['options']);
            break;
        default:
        case SettingModel::INPUT_TEXTINPUT:
            $field = $form->field($setting, "[$index]value")->textInput($setting['options']);
        }

        ///hint, label are not html-encoded, so support for HTML code
        echo $field->hint($setting['hint'])->label($setting->key, $setting->label_options); ?>

        </div>

    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton(Module::t('message', 'Update'),['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Module::t('message', 'Reset'),['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
