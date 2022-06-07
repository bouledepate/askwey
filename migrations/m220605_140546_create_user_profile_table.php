<?php

namespace migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220605_140546_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'preferred_name' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'family_name' => $this->string(),
            'birthday' => $this->date(),
            'avatar' => $this->string(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_profile-user_id}}',
            '{{%user_profile}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_profile-user_id}}',
            '{{%user_profile}}',
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
            '{{%fk-user_profile-user_id}}',
            '{{%user_profile}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_profile-user_id}}',
            '{{%user_profile}}'
        );

        $this->dropTable('{{%user_profile}}');
    }
}
