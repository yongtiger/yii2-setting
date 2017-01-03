<?php

use yii\db\Migration;

class m161231_211442_create_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'category' => 'varchar(255) COLLATE utf8_unicode_ci NOT NULL',
            'key' => 'varchar(255) COLLATE utf8_unicode_ci NOT NULL',
            'value' => 'text COLLATE utf8_unicode_ci',
            'type' => "varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'string'",
            'input' => "varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'textInput'",
            'items' => 'varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL',
            'options' => 'varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL',
            'label_options' => 'varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL',
            'hint' => 'varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL',
            'hint_options' => 'varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL',
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `unique-category-key` (`category`,`key`) USING BTREE',
        ], $tableOptions);

        ///Demo data
        $this->insert('{{%setting}}',['id'=>'1','category'=>'site','key'=>'name','value'=>'My Application','type'=>'string','input'=>'textInput','items'=>null,'options'=>'','label_options'=>'','hint'=>'Setup your <b>site name</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'2','category'=>'site','key'=>'url','value'=>'http://www.brainbook.cc','type'=>'string','input'=>'textarea','items'=>null,'options'=>'','label_options'=>'','hint'=>'Setup your <b>URL</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'3','category'=>'user','key'=>'age','value'=>'18','type'=>'integer','input'=>'textInput','items'=>null,'options'=>'','label_options'=>'','hint'=>'Setup your <b>age</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'4','category'=>'user','key'=>'married','value'=>'1','type'=>'boolean','input'=>'checkbox','items'=>null,'options'=>'{"prompt":"Han"}','label_options'=>'','hint'=>'Setup your <b>married</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'5','category'=>'user','key'=>'height','value'=>'178.5','type'=>'float','input'=>'textInput','items'=>null,'options'=>'','label_options'=>'','hint'=>'Setup your <b>height</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'6','category'=>'user','key'=>'profile1','value'=>'["age",1]','type'=>'array','input'=>'radioList','items'=>'','options'=>'','label_options'=>'','hint'=>'Setup your <b>profile1</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'7','category'=>'user','key'=>'profile2','value'=>'["name",1,["age",1]]','type'=>'array','input'=>'multiselect','items'=>'','options'=>'{"prompt":"Han"}','label_options'=>'','hint'=>'Setup your <b>profile2</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'8','category'=>'user','key'=>'profile3','value'=>'["name",1,["age",{"0":1,"age":18}]]','type'=>'array','input'=>'textInput','items'=>'','options'=>'','label_options'=>'','hint'=>'Setup your <b>profile3</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'9','category'=>'user','key'=>'profile4','value'=>'{"0":1,"age":18}','type'=>'object','input'=>'radioList','items'=>'','options'=>'','label_options'=>'','hint'=>'Setup your <b>profile4</b>.','hint_options'=>'']);

        $this->insert('{{%setting}}',['id'=>'10','category'=>'user','key'=>'profile5','value'=>'{"0":1,"age":["name",1,["age",{"0":1,"age":18}]]}','type'=>'object','input'=>'multiselect','items'=>'','options'=>'{"prompt":"Han"}','label_options'=>'','hint'=>'Setup your <b>profile5</b>.','hint_options'=>'']);

    }

    public function down()
    {
        $this->dropTable('{{%setting}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
