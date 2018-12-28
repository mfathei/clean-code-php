<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\CustomersController;
use CleanPhp\Invoicer\Service\InputFilter\CustomerInputFilter;
use Zend\Hydrator\ClassMethodsHydrator;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\View\Renderer\PhpRenderer;

/**
 * Disable Deprecated warnings
 */
ini_set("error_reporting", E_ALL & ~E_USER_DEPRECATED);

return [
    'controllers' => [
        'invokables' => [
            'Controller\Index' => 'Controller\IndexController',
            'Controller\Customers' => 'Controller\CustomersController',
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'customers' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/customers',
                    'defaults' => [
                        'controller' => 'Controller\Customers',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'create' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/new',
                            'defaults' => [
                                'action' => 'new'
                            ]
                        ]
                    ]
                ]
            ],
            'orders' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/orders',
                    'defaults' => [
                        'controller' => 'Controller\Orders',
                        'action' => 'index',
                    ],
                ],
            ],
            'invoices' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/invoices',
                    'defaults' => [
                        'controller' => 'Controller\Invoices',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            'Controller\Customers' => function ($sm) {
                return new CustomersController(
                    $sm->getServiceLocator()->get('CustomerTable'),
                    new CustomerInputFilter(),
                    new ClassMethodsHydrator()
                );
            },
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'validationErrors' => View\Helper\ValidationErrors::class,
        ],
        'factories' => [
            View\Helper\ValidationErrors::class => InvokableFactory::class,
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
