<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Biz\BizKernel;

class UserProvider implements UserProviderInterface
{
    protected $biz;

    public function __construct(BizKernel $biz)
    {
        $this->biz = $biz;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->biz['user_service']->getUserByUsername($username);

        if (empty($user)) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }

        $basic = $this->biz['user_service']->getBasic($user['id']);
        $user['departmentId'] = $basic['departmentId'];
        $department = $this->biz['department_service']->getDepartment($basic['departmentId']);
        $user['trueName'] = $basic['trueName'];
        $user['department'] = $department['name'];

        $currentUser = new CurrentUser($user);

        $this->biz->setUser($currentUser);

        return new CurrentUser($user);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof CurrentUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'AppBundle\Security\CurrentUser';
    }
}