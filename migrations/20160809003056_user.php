<?php

use Phpmig\Migration\Migration;

class User extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('user');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('number', 'string', array('length' => 4, 'comment' => '员工工号'));
        $table->addColumn('username', 'string', array('length' => 64, 'null' => false, 'comment' => '用户名'));
        $table->addColumn('password', 'string', array('length' => 64, 'null' => false, 'comment' => '密码'));
        $table->addColumn('salt', 'string', array('length' => 64, 'null' => false, 'comment' => '密码加密Salt'));
        $table->addColumn('roles', 'string', array('length' => 512, 'default' => 'ROLE_USER', 'comment' => '用户角色'));
        $table->addColumn('status', 'string', array('default' => 'on', 'comment' => '在职状态'));
        $table->addColumn('joinTime', 'integer', array('default' => 0, 'comment' => '入职时间'));
        $table->addColumn('quitTime', 'integer', array('default' => 0, 'comment' => '离职时间'));
        $table->addColumn('createdTime', 'integer', array('default' => 0, 'comment' => '创建时间'));
        $table->addColumn('updatedTime', 'integer', array('default' => 0, 'comment' => '更新时间'));
        $table->addColumn('imgFrontIDcard', 'string', array('length' => 64, 'null' => false, 'comment' => '身份证正面图片路径'));
        $table->addColumn('imgBackIDcard', 'string', array('length' => 64, 'null' => false, 'comment' => '身份证反面图片路径'));
        $table->addColumn('imgHandleIDcard', 'string', array('length' => 64, 'null' => false, 'comment' => '身份证手持图片路径'));
        $table->addColumn('imgEducation', 'string', array('length' => 64, 'null' => false, 'comment' => '学历图片路径'));
        $table->addColumn('imgRank', 'string', array('length' => 64, 'null' => false, 'comment' => '职称图片路径'));
        $table->addColumn('imgProfile', 'string', array('length' => 64, 'null' => false, 'comment' => '个人头像图片路径'));

        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('user');
    }
}
