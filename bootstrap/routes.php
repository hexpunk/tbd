<?php

declare(strict_types=1);

use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        return $response->withJson(['hello' => 'world']);
    });
};
