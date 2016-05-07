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
            'date_event' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-calendar-creator',
            'calendar',
            'creator',
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
            'fk-calendar-creator',
            'calendar'
        );

        $this->dropTable('calendar');
    }
}
