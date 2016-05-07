<?php

use yii\db\Migration;

/**
 * Handles the creation for table `access`.
 */
class m160503_180103_create_access extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('access', [
            'id' => $this->primaryKey(),
            'user_owner' => $this->integer()->notNull(),
            'user_guest' => $this->integer()->notNull(),
            'date' => $this->date(),
        ]);

        $this->addForeignKey(
            'fk-access-user_owner',
            'access',
            'user_owner',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-access-user_guest',
            'access',
            'user_guest',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-access-user_guest',
            'access'
        );

        $this->dropForeignKey(
            'fk-access-user_owner',
            'access'
        );

        $this->dropTable('access');
    }
}
