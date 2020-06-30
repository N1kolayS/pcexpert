<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m200630_070536_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->datetime(),
            'creator_id' => $this->integer()->notNull(),
            'fio' => $this->string(),
            'phone' => $this->string(),
            'status' => $this->integer()->defaultValue(0),
            'rating' => $this->integer(),
            'comment' => $this->text(),
            'legal' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `creator_id`
        $this->createIndex(
            '{{%idx-client-creator_id}}',
            '{{%client}}',
            'creator_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-client-creator_id}}',
            '{{%client}}',
            'creator_id',
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
            '{{%fk-client-creator_id}}',
            '{{%client}}'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            '{{%idx-client-creator_id}}',
            '{{%client}}'
        );

        $this->dropTable('{{%client}}');
    }
}
