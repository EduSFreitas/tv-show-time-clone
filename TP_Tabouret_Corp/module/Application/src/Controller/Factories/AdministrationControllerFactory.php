<?php
namespace Application\Controller\Factories;

use Application\Controller\AdministrationController;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session as SessionStorage;
use Interop\Container\ContainerInterface;
use Application\Controller\IndexController;
use Application\Services\ProductTable;

/**
 * The factory responsible for creating of authentication service.
 */
class AdministrationControllerFactory implements FactoryInterface
{
    /**
     * This method creates the Zend\Authentication\AuthenticationService service
     * and returns its instance.
     */
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $panierTable = $container->get(\Application\Services\PanierTable::class);

        return new AdministrationController($container->get(ProductTable::class),$panierTable);
    }
}
