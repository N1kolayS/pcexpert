<?php

use yii\db\Migration;

/**
 * Class m200802_064253_rename_complect_column_in_order_table
 */
class m200802_064253_rename_complect_column_in_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('order', 'complect', 'kit');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('order', 'kit', 'complect');

    }


}
