<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main;

use Core\Exception;
use DI\DependencyException;
use DI\NotFoundException;
use Modules\Main\Controller\IndexController;

class Router extends \Core\Module\Router {

    use MainTrait;

    /**
     * @var string
     */
    public string $routerType = "main";

    /**
     * @var string
     */
    public string $router = "";

    /**
     * @var array|string[][]
     */
    public array $mapForUriBuilder = [
        'home' => [
            'callback' => 'index',
            'pattern' => '/',
            'method'=>['GET']
        ],
        'page' => [
            'callback' => 'page',
            'pattern' => '/{page:[a-z0-9-/_]+}',
            'method'=>['GET']
        ],
        'sitemap'=>[
            'callback' => 'sitemap',
            'pattern' => '/sitemap.xml',
            'method'=>['GET']
        ]
    ];

    public string $controller = IndexController::class;
}
