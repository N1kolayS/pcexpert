<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%equipment}}`
 * - `{{%client}}`
 * - `{{%user}}`
 */
class m200630_115908_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->datetime(),
            'hired_at' => $this->datetime(),
            'closed_at' => $this->datetime(),
            'equipment_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'manager_id' => $this->integer()->notNull(),
            'master' => $this->integer(),
            'status' => $this->integer(),
            'placement' => $this->integer(),
            'problems' => $this->text(),
            'complect' => $this->string(),
            'prepayment' => $this->decimal(10,2),
            'cost' => $this->decimal(10,2),
            'comment' => $this->text(),
        ]);

        // creates index for column `equipment_id`
        $this->createIndex(
            '{{%idx-order-equipment_id}}',
            '{{%order}}',
            'equipment_id'
        );

        // add foreign key for table `{{%equipment}}`
        $this->addForeignKey(
            '{{%fk-order-equipment_id}}',
            '{{%order}}',
            'equipment_id',
            '{{%equipment}}',
            'id',
            'CASCADE'
        );

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-order-client_id}}',
            '{{%order}}',
            'client_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-order-client_id}}',
            '{{%order}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE'
        );

        // creates index for column `manager_id`
        $this->createIndex(
            '{{%idx-order-manager_id}}',
            '{{%order}}',
            'manager_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-order-manager_id}}',
            '{{%order}}',
            'manager_id',
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
        // drops foreign key for table `{{%equipment}}`
        $this->dropForeignKey(
            '{{%fk-order-equipment_id}}',
            '{{%order}}'
        );

        // drops index for column `equipment_id`
        $this->dropIndex(
            '{{%idx-order-equipment_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%client}}`
        $this->dropForeignKey(
            '{{%fk-order-client_id}}',
            '{{%order}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-order-client_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-order-manager_id}}',
            '{{%order}}'
        );

        // drops index for column `manager_id`
        $this->dropIndex(
            '{{%idx-order-manager_id}}',
            '{{%order}}'
        );

        $this->dropTable('{{%order}}');
    }
}
