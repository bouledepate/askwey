<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m220612_150817_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull(),
            'author_id' => $this->integer()->null(),
            'member_id' => $this->integer()->null(),
            'state' => $this->integer()->defaultValue(1),
            'is_anonymous' => $this->integer()->defaultValue(0),
            'date_create' => $this->timestamp(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-question-author_id}}',
            '{{%question}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-question-author_id}}',
            '{{%question}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `member_id`
        $this->createIndex(
            '{{%idx-question-member_id}}',
            '{{%question}}',
            'member_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-question-member_id}}',
            '{{%question}}',
            'member_id',
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
            '{{%fk-question-author_id}}',
            '{{%question}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-question-author_id}}',
            '{{%question}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-question-member_id}}',
            '{{%question}}'
        );

        // drops index for column `member_id`
        $this->dropIndex(
            '{{%idx-question-member_id}}',
            '{{%question}}'
        );

        $this->dropTable('{{%question}}');
    }
}
