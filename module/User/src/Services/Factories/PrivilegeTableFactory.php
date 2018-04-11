<?php
namespace User\Services\Factories;

use User\Services\PrivilegeTable;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session as SessionStorage;
use Interop\Container\ContainerInterface;


use User\Services\PrivilegeTableGateway;


class PrivilegeTableFactory implements FactoryInterface
{
    /**
     * This method creates the Zend\Authentication\AuthenticationService service
     * and returns its instance.
     */
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $tableGateway = $container->get(PrivilegeTableGateway::class);
        $table = new PrivilegeTable($tableGateway);
        return $table;
    }
}
