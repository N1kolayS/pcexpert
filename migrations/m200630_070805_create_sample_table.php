<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sample}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%brand}}`
 */
class m200630_070805_create_sample_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sample}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'name' => $this->string(),
        ]);

        // creates index for column `brand_id`
        $this->createIndex(
            '{{%idx-sample-brand_id}}',
            '{{%sample}}',
            'brand_id'
        );

        // add foreign key for table `{{%brand}}`
        $this->addForeignKey(
            '{{%fk-sample-brand_id}}',
            '{{%sample}}',
            'brand_id',
            '{{%brand}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%brand}}`
        $this->dropForeignKey(
            '{{%fk-sample-brand_id}}',
            '{{%sample}}'
        );

        // drops index for column `brand_id`
        $this->dropIndex(
            '{{%idx-sample-brand_id}}',
            '{{%sample}}'
        );

        $this->dropTable('{{%sample}}');
    }
}
