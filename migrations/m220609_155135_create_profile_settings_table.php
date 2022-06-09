<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile_settings}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user_profile}}`
 */
class m220609_155135_create_profile_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile_settings}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(),
            'shown_name' => $this->integer()->defaultValue(0),
            'show_family_name' => $this->integer()->defaultValue(0),
            'status' => $this->string(255),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-profile_settings-profile_id}}',
            '{{%profile_settings}}',
            'profile_id'
        );

        // add foreign key for table `{{%user_profile}}`
        $this->addForeignKey(
            '{{%fk-profile_settings-profile_id}}',
            '{{%profile_settings}}',
            'profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user_profile}}`
        $this->dropForeignKey(
            '{{%fk-profile_settings-profile_id}}',
            '{{%profile_settings}}'
        );

        // drops index for column `profile_id`
        $this->dropIndex(
            '{{%idx-profile_settings-profile_id}}',
            '{{%profile_settings}}'
        );

        $this->dropTable('{{%profile_settings}}');
    }
}
