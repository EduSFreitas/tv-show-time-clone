<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                //Redirige vers /page/1 dans le controller
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'redirect',
                    ],
                ],
            ],
            'produits' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/produits/:id',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\ProduitsController::class,
                        'action'        => 'produits',
                    ],
                ],
            ],
            'administration' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/administration',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\AdministrationController::class,
                        'action'        => 'administration',
                    ],
                ],
            ],
            //suppression d'un produit depuis l'administration
            'suppression' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/administration/suppression/:id',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\AdministrationController::class,
                        'action'        => 'suppression',
                    ],
                ],
            ],
            'ajout' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/administration/ajout',
                    'defaults' => [
                        'controller'    => Controller\AdministrationController::class,
                        'action'        => 'ajout',
                    ],
                ],
            ],
            'edition' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/administration/edition',
                    'defaults' => [
                        'controller'    => Controller\AdministrationController::class,
                        'action'        => 'edition',
                    ],
                ],
            ],
            'panier' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/panier',
                    'defaults' => [
                        'controller'    => Controller\PanierController::class,
                        'action'        => 'panier',
                    ],
                ],
            ],
            'paiement' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/panier/paiement',
                    'defaults' => [
                        'controller'    => Controller\PaiementController::class,
                        'action'        => 'paiement',
                    ],
                ],
            ],
            'ajoutPanier' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/panier/ajout/:id',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\PanierController::class,
                        'action'        => 'ajoutPanier',
                    ],
                ],
            ],
            'suppressionPanier' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/panier/suppression/:id',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\PanierController::class,
                        'action'        => 'suppressionPanier',
                    ],
                ],
            ],
            'profil' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/profil',
                    'defaults' => [
                        'controller'    => Controller\ProfilController::class,
                        'action'        => 'profil',
                    ],
                ],
            ],
            'changerMail' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/profil/changerMail',
                    'defaults' => [
                        'controller'    => Controller\ProfilController::class,
                        'action'        => 'changerMail',
                    ],
                ],
            ],
            //Pagination
            'paginator' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/page/:page',
                    'defaults' => array(
                        'page' => 1,
                        'controller'    => Controller\IndexController::class,
                        'action'        => 'index',
                    ),
                ),
            ),
        ],
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\IndexController::class => [
                ['actions' => ['index'], 'allow' => '*'],
            ],
            Controller\PanierController::class => [
                ['actions' => ['panier'], 'allow' => '@'],
            ],
            Controller\AdministrationController::class => [
                ['actions' => ['ajout','supression','edition'], 'allow' => '@'],
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            Services\ProductTable::class => Services\Factories\ProductTableFactory::class,
            Services\ProductTableGateway::class => Services\Factories\ProductTableGatewayFactory::class,
            Services\PanierTable::class => Services\Factories\PanierTableFactory::class,
            Services\PanierTableGateway::class => Services\Factories\PanierTableGatewayFactory::class,
            Services\NavManager::class => Services\Factories\NavManagerFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factories\IndexControllerFactory::class,
            Controller\ProduitsController::class => Controller\Factories\ProduitsControllerFactory::class,
            Controller\PanierController::class => Controller\Factories\PanierControllerFactory::class,
            Controller\PaiementController::class => Controller\Factories\PaiementControllerFactory::class,
            Controller\AdministrationController::class => Controller\Factories\AdministrationControllerFactory::class,
            Controller\ProfilController::class => Controller\Factories\ProfilControllerFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            View\Helper\Menu::class => View\Helper\Factory\MenuFactory::class,
        ],
        'aliases' => [
            'mainMenu' => View\Helper\Menu::class
        ],
    ],


    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
