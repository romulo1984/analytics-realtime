<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/libs/GoogleAnalyticsRealTime.php';

$app = new \Slim\App;

// $app->get('/realtime[/{url:.+}]', function (Request $request, Response $response, array $args) {
//     $realTime = new GoogleAnalyticsRealTime();
//     $realTime->setParams('filters', 'rt:pagePath=@/' . ($args['url'] ?? ''));

//     $response = $response->withJson(['data' => $realTime->getActiveUsers()]);
//     return $response
//         ->withHeader('Access-Control-Allow-Origin', '*')
//         ->withHeader('Access-Control-Allow-Methods', 'GET');
// });

$app->get('/realtime/batch', function (Request $request, Response $response) {
    $realTime = new GoogleAnalyticsRealTime();

    $response = $response->withJson(['data' => $realTime->getBatch()]);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET');
});

$app->run();

