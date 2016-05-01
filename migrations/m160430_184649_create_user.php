<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160430_184649_create_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(45)->notNull(),
            'surname' => $this->string(45)->notNull(),
            'password' => $this->string(255)->notNull(),
            'salt' => $this->string(255)->notNull(),
            'access_token' => $this->string(255),
            'create_date' => $this->dateTime()->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
