<?php

use Phpmig\Migration\Migration;

class ConfirmPerson extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('confirm_person');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('userId', 'integer', array('null' => false));
        $table->addColumn('trueName', 'string', array('length' => 64, 'comment' => '确认主管或同事姓名'));
        $table->addColumn('job', 'text', array('comment' => '工作单位及岗位职务'));
        $table->addColumn('phone', 'integer', array('comment' => '联系电话'));
        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('confirm_person');
    }
}
