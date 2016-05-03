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
            'calendar_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('access');
    }
}
