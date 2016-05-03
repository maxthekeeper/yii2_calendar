<?php

use yii\db\Migration;

/**
 * Handles the creation for table `calendar`.
 */
class m160503_120420_create_calendar extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('calendar', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'creator' => $this->integer()->notNull(),
            'date_create' => $this->timestamp()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('calendar');
    }
}
