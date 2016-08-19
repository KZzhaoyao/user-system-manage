<?php

use Phpmig\Migration\Migration;

class OtherInfo extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('other_info');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('userId', 'integer', array('null' => false));
        $table->addColumn('reward', 'text', array('comment' => '所受培训及所具有证书'));
        $table->addColumn('selfAssessment', 'text', array('comment' => '自我评价'));
        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('other_info');
    }
}
