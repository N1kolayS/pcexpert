<?php

use yii\db\Migration;

/**
 * Class m200802_081410_rename_master_column_in_order_table
 */
class m200802_081410_rename_master_column_in_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('order', 'master', 'master_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('order', 'master_id', 'master');
    }

}
