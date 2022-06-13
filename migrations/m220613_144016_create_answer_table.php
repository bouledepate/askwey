<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%question}}`
 * - `{{%user}}`
 */
class m220613_144016_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer(),
            'description' => $this->string()->notNull(),
            'author_id' => $this->integer()->null(),
            'state' => $this->integer()->defaultValue(1),
            'is_anonymous' => $this->integer()->defaultValue(0),
            'is_public' => $this->integer()->defaultValue(0),
            'date_create' => $this->timestamp(),
        ]);

        // creates index for column `question_id`
        $this->createIndex(
            '{{%idx-answer-question_id}}',
            '{{%answer}}',
            'question_id'
        );

        // add foreign key for table `{{%question}}`
        $this->addForeignKey(
            '{{%fk-answer-question_id}}',
            '{{%answer}}',
            'question_id',
            '{{%question}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-answer-author_id}}',
            '{{%answer}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-answer-author_id}}',
            '{{%answer}}',
            'author_id',
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
        // drops foreign key for table `{{%question}}`
        $this->dropForeignKey(
            '{{%fk-answer-question_id}}',
            '{{%answer}}'
        );

        // drops index for column `question_id`
        $this->dropIndex(
            '{{%idx-answer-question_id}}',
            '{{%answer}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-answer-author_id}}',
            '{{%answer}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-answer-author_id}}',
            '{{%answer}}'
        );

        $this->dropTable('{{%answer}}');
    }
}
