<?php

use yii\db\Schema;
use yii\db\Migration;

class m140712_123329_widget_carousel extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%widget_carousel}}', [
            'id' => Schema::TYPE_PK,
            'alias' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' DEFAULT 0'
        ], $tableOptions);

        $this->insert('{{%widget_carousel}}', [
           'id'=>1,
            'alias'=>'index',
            'status'=>\common\models\WidgetCarousel::STATUS_ACTIVE
        ]);

        $this->createTable('{{%widget_carousel_item}}', [
            'id' => Schema::TYPE_PK,
            'carousel_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'path'=>Schema::TYPE_STRING . '(1024) NOT NULL',
            'url' => Schema::TYPE_STRING . '(1024) ',
            'caption' => Schema::TYPE_STRING . '(1024) ',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'order' => Schema::TYPE_INTEGER . ' DEFAULT 0'
        ]);

        $this->insert('{{%widget_carousel_item}}', [
            'carousel_id'=>1,
            'path'=>'/img/yii2-starter-kit.gif',
            'url'=>'/',
            'status'=>1
        ]);

        $this->createIndex('idx_carousel_id', '{{%widget_carousel_item}}', 'carousel_id');
        $this->addForeignKey('fk_item_carousel', '{{%widget_carousel_item}}', 'carousel_id', '{{%widget_carousel}}', 'id', 'cascade', 'cascade');

    }


    public function safeDown()
    {
        $this->dropForeignKey('fk_item_carousel', '{{%widget_carousel_item}}');
        $this->dropTable('{{%widget_carousel_item}}');
        $this->dropTable('{{%widget_carousel}}');
    }
}
