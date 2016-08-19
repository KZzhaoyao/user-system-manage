<?php
namespace Biz;

use Codeages\Biz\Framework\Context\Kernel;
use Biz\User\Impl\UserServiceImpl;
use Biz\Department\Impl\DepartmentServiceImpl;
use Biz\User\Dao\Impl\UserDaoImpl;
use Biz\User\Dao\Impl\UserBasicInfoDaoImpl;
use Biz\User\Dao\Impl\UserConfirmInfoDaoImpl;
use Biz\User\Dao\Impl\UserFamilyInfoDaoImpl;
use Biz\User\Dao\Impl\UserLearnInfoDaoImpl;
use Biz\User\Dao\Impl\UserOtherInfoDaoImpl;
use Biz\User\Dao\Impl\UserWorkInfoDaoImpl;
use Biz\User\Dao\Impl\UserSearchDaoImpl;
use Biz\Department\Dao\Impl\DepartmentDaoImpl;

class BizKernel extends Kernel
{
    protected $extraContainer;

    public function __construct($config, $extraContainer)
    {
        parent::__construct($config);
        $this->extraContainer = $extraContainer;
    }

    public function boot($options = array())
    {
        $this->registerService();
        $this->put('migration_directories', dirname(dirname(__DIR__)). '/migrations');
        parent::boot();
    }

    public function registerProviders()
    {
        return [];
    }

    protected function registerService()
    {
        $this['user_dao'] = $this->dao(function($container) {
            return new UserDaoImpl($container);
        });

        $this['user_basic_dao'] = $this->dao(function($container) {
            return new UserBasicInfoDaoImpl($container);
        });

        $this['family_member_dao'] = $this->dao(function($container) {
            return new UserFamilyInfoDaoImpl($container);
        });

        $this['work_experience_dao'] = $this->dao(function($container) {
            return new UserWorkInfoDaoImpl($container);
        });

        $this['confirm_person_dao'] = $this->dao(function($container) {
            return new UserConfirmInfoDaoImpl($container);
        });

        $this['edu_experience_dao'] = $this->dao(function($container) {
            return new UserLearnInfoDaoImpl($container);
        });

        $this['other_info_dao'] = $this->dao(function($container) {
            return new UserOtherInfoDaoImpl($container);
        });

        $this['user_search_dao'] = function($container) {
            return new UserSearchDaoImpl($container);
        };

        $this['user_service'] = function($container) {
            return new UserServiceImpl($container);
        };

        $this['department_dao'] = $this->dao(function($container) {
            return new DepartmentDaoImpl($container);
        });

        $this['department_service'] = function($container) {
            return new DepartmentServiceImpl($container);
        };

        $this['password_encoder'] = function($container) {
            $class = $this->extraContainer->getParameter('app.current_user.class');
            $user = new $class(array());
            return $this->extraContainer->get('security.encoder_factory')->getEncoder($user);
        };
    }
}