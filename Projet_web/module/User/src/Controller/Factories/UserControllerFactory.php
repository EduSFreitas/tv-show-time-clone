<?php
namespace User\Controller\Factories;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use User\Controller\UserController;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        return new UserController();
    }
}
