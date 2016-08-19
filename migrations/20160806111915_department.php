<?php

use Phpmig\Migration\Migration;

class Department extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('department');
        $table->addColumn('id','integer',array('autoincrement' => true));
        $table->addColumn('name', 'string', array('length' => 10, 'comment' => '部门名称'));
        $table->addColumn('amount', 'integer', array('comment' => '部门人数'));
        $table->addColumn('createdTime', 'integer', array('default' => 0, 'comment' => '创建时间'));
        $table->addColumn('updatedTime', 'integer', array('default' => 0, 'comment' => '创建时间'));    
        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);
    }   

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('department');
    }
}
