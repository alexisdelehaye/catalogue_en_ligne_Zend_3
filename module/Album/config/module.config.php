<?php

namespace Album;



use Album\Model\Product;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'product' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/product[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            ],
        ],

    'view_manager' => [
        'template_map' => array(
            'product/PayerPanier' =>  __DIR__ .'/../view/product/PayerPanier.phtml'
        ),
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',

        ],
    ],



];

