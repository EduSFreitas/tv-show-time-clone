<?php
namespace User\Services\Factories;

use User\Services\UserPrivilegeTable;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session as SessionStorage;
use Interop\Container\ContainerInterface;


use User\Services\UserPrivilegeTableGateway;


class UserPrivilegeTableFactory implements FactoryInterface
{
    /**
     * This method creates the Zend\Authentication\AuthenticationService service
     * and returns its instance.
     */
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $tableGateway = $container->get(UserPrivilegeTableGateway::class);
        $table = new UserPrivilegeTable($tableGateway);
        return $table;
    }
}
