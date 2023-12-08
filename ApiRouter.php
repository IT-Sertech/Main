<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main;

class ApiRouter extends \Core\Module\ApiRouter {

    use MainTrait;

    /**
     * @var int
     */
    public int $version = 1;

    /**
     * @var string
     */
    public string $routerType = "page";

    /**
     * @var array|array[]
     */
    public array $mapForUriBuilder = [
        'list' => [
            'callback' => 'getPages',
            'pattern' =>'',
            'method'=>['GET']
        ],
        'page' => [
            'callback' => 'getPage',
            'pattern' =>'/{page:[a-z0-9_-]+}',
            'method'=>['GET']
        ],
    ];

    public string $controller = ApiController\IndexController::class;

}
