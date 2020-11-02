<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Order\UI\OpenApiDocAction;
use App\Order\UI\OrderAction;
use App\Order\UI\OrderListAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->group('/api/v1', function (Group $group) {
        $group->group('/orders', function (Group $group) {
            $group->get('', OrderListAction::class);
            $group->get('/{id}', OrderAction::class);
        });
    });


    $app->get('/open-api',  OpenApiDocAction::class);
};
