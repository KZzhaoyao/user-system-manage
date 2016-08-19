<?php

use Phpmig\Migration\Migration;

class FamilyMember extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('family_member');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('userId', 'integer', array('null' => false));
        $table->addColumn('member', 'string', array('length' => 32, 'comment' => '家庭成员称呼'));
        $table->addColumn('trueName', 'string', array('length' => 255, 'comment' => '姓名'));
        $table->addColumn('age', 'integer', array('default' => 0, 'comment' => '年龄'));
        $table->addColumn('job', 'text', array('comment' => '工作单位及岗位职务'));
        $table->addColumn('phone', 'string', array('length' => 16, 'comment' => '联系电话'));
        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('family_member');
    }
}
