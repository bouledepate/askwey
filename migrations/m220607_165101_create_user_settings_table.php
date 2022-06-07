<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_settings}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220607_165101_create_user_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_settings}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
            'is_readonly' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_settings-user_id}}',
            '{{%user_settings}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_settings-user_id}}',
            '{{%user_settings}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_settings-user_id}}',
            '{{%user_settings}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_settings-user_id}}',
            '{{%user_settings}}'
        );

        $this->dropTable('{{%user_settings}}');
    }
}
