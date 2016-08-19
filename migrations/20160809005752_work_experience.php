<?php

use Phpmig\Migration\Migration;

class WorkExperience extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('work_experience');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('userId', 'integer', array('null' => false));
        $table->addColumn('startTime', 'integer', array('default' => 0, 'comment' => '开始时间'));
        $table->addColumn('endTime', 'integer', array('default' => 0, 'comment' => '结束时间'));
        $table->addColumn('company', 'string', array('length' => 64, 'comment' => '工作单位'));
        $table->addColumn('position', 'string', array('length' => 64, 'comment' => '岗位职务'));
        $table->addColumn('leaveReason', 'text', array('comment' => '离职原因'));
        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);

    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('work_experience');
    }
}
