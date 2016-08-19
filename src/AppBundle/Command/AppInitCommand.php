<?php

namespace AppBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppInitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:init')
            ->setDescription('Init application.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Init Application.");
        $user = array(
            'username' => 'admin',
            'number' => '0000',
            'password' => 'kaifazhe',
            'roles' => array('ROLE_ADMIN'),
            'trueName' => 'Admin'
        );
        $user = $this->getService('user_service')->register($user);

        $output->writeln([
            "Admin Username: {$user['username']}",
            "Admin Password: {$user['password']}"
        ]);

        $department = array(
            'name' => '技术部'
        );

        $this->getService('department_service')->createDepartment($department);

        $output->writeln(["创建技术部成功"]);

        $department = array(
            'name' => '市场部'
        );

        $this->getService('department_service')->createDepartment($department);

        $output->writeln(["创建市场部成功"]);

        $department = array(
            'name' => '运营部'
        );

        $this->getService('department_service')->createDepartment($department);

        $output->writeln(["创建运营部成功"]);

    }

    protected function getService($name)
    {
        $biz = $this->getApplication()->getKernel()->getContainer()->get('biz');
        return $biz[$name];
    }
}
