<?php

declare(strict_types=1);

use Slim\App;
use Slim\Exception\HttpForbiddenException;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        // throw new HttpForbiddenException($request);
        return $response->withJson(['hello' => 'world']);
    });
};
