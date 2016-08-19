<?php

use Phpmig\Migration\Migration;

class UserBasic extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('user_basic');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('userId', 'integer', array('null' => false));
        $table->addColumn('departmentId', 'integer', array('default' => 0, 'comment' => '部门'));
        $table->addColumn('rank', 'string', array('length' => 255, 'default' => null, 'comment' => '职级'));
        $table->addColumn('trueName', 'string', array('length' => 255, 'comment' => '姓名'));
        $table->addColumn('phone', 'string', array('length' => 32, 'comment' => '联系方式'));
        $table->addColumn('email', 'string', array('length' => 255, 'comment' => '邮箱'));
        $table->addColumn('gender', 'string', array('length' => 12, 'default' => 'male', 'comment' => '性别'));
        $table->addColumn('bornTime', 'integer', array('unsigned' => true, 'default' => 0, 'comment' => '出生日期'));
        $table->addColumn('native', 'string', array('length' => 255, 'comment' => '籍贯'));
        $table->addColumn('nation', 'string', array('length' => 64, 'default' => '汉族', 'comment' => '民族'));
        $table->addColumn('height', 'string', array('length' => 8, 'comment' => '身高(cm)'));
        $table->addColumn('weight', 'string', array('length' => 8, 'comment' => '体重(kg)'));
        $table->addColumn('blood', 'string', array('length' => 4, 'comment' => '血型'));
        $table->addColumn('education', 'string', array('length' => 32, 'default' => '初中','comment' => '文化程度'));
        $table->addColumn('prefession', 'string', array('length' => 64, 'comment' => '专业'));
        $table->addColumn('marriage', 'integer', array('default' => 0,'comment' => '婚否'));
        $table->addColumn('residence', 'text', array('comment' => '户口所在地'));
        $table->addColumn('address', 'text', array('comment' => '家庭住址'));
        $table->addColumn('postcode', 'string', array('length' => 6, 'comment' => '邮编'));
        $table->addColumn('Idcard', 'string', array('length' => 32, 'comment' => '身份证'));
        $table->addColumn('professionTitle', 'string', array('comment' => '职称'));
        $table->addColumn('householdType', 'string', array('length' => 32, 'default' => '农村', 'comment' => '户口性质'));
        $table->addColumn('recordPlace', 'text', array('comment' => '档案存放地'));
        $table->addColumn('formerLaborShip', 'text', array('default' =>'已解除', 'comment' => '与原工作的劳动关系'));
        $table->addColumn('politics', 'string', array('length' => 32, 'default' => '群众', 'comment' => '政治面貌'));
        $table->setPrimaryKey(array('id'));
        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('user_basic');
    }
}
