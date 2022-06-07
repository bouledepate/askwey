<?php

namespace migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_security}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220605_140214_create_user_security_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_security}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'password_hash' => $this->string()->notNull(),
            'access_token' => $this->string(),
            'auth_key' => $this->string(),
        ]);

        // creates index for column `userId`
        $this->createIndex(
            '{{%idx-user_security-user_id}}',
            '{{%user_security}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_security-user_id}}',
            '{{%user_security}}',
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
            '{{%fk-user_security-user_id}}',
            '{{%user_security}}'
        );

        // drops index for column `userId`
        $this->dropIndex(
            '{{%idx-user_security-user_id}}',
            '{{%user_security}}'
        );

        $this->dropTable('{{%user_security}}');
    }
}
