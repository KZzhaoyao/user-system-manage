<?php

use Phpmig\Migration\Migration;

class EduExperience extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('edu_experience');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('userId', 'integer', array('null' => false));
        $table->addColumn('startTime', 'integer', array('default' => 0, 'comment' => '开始时间'));
        $table->addColumn('endTime', 'integer', array('default' => 0, 'comment' => '结束时间'));
        $table->addColumn('schoolName', 'string', array('length' => 64, 'comment' => '院校名称'));
        $table->addColumn('profession', 'string', array('length' => 64, 'comment' => '所学专业'));
        $table->addColumn('position', 'string', array('length' => 64, 'comment' => '担任职务'));
        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('edu_experience');
    }
}
