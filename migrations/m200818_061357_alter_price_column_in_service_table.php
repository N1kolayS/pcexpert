<?php

use yii\db\Migration;

/**
 * Class m200818_061357_alter_price_column_in_service_table
 */
class m200818_061357_alter_price_column_in_service_table extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('{{%service}}', 'price', $this->decimal(10,2));
    }

    public function down()
    {
        echo "m200818_061357_alter_price_column_in_service_table cannot be reverted.\n";

        return false;
    }

}
