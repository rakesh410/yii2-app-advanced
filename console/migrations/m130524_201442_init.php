<?php

use yii\db\Migration;
use common\models\User;
use common\models\Admin;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
		
        $this->batchInsert('{{%user}}', ['id', 'username', 'password_hash', 'email', 'status', 'created_at', 'updated_at'], [
            [1, 'user', Yii::$app->security->generatePasswordHash('user'), 'user@example.com', User::STATUS_ACTIVE, time(), time()],
        ]);
        $this->batchInsert('{{%admin}}', ['id', 'username', 'password_hash', 'email', 'status', 'created_at', 'updated_at'], [
            [1, 'admin', Yii::$app->security->generatePasswordHash('admin'), 'admin@example.com', Admin::STATUS_ACTIVE, time(), time()],
        ]);
        
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%admin}}');
    }
}
