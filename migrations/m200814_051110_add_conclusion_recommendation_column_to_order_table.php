<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order}}`.
 */
class m200814_051110_add_conclusion_recommendation_column_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'conclusion', $this->string());
        $this->addColumn('{{%order}}', 'recommendation', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'conclusion');
        $this->dropColumn('{{%order}}', 'recommendation');
    }
}
