<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/libs/GoogleAnalyticsRealTime.php';

$app = new \Slim\App;

$app->get('/realtime/batch/{urls:.+}', function (Request $request, Response $response, array $args) {
    $realTime = new GoogleAnalyticsRealTime();

    $items = explode(';', $args['urls']);
    $finalParsedUrls = [];

    foreach($items as $value) {
        $item = explode(',', $value);
        $finalParsedUrls[$item[0]] = $item[1];
    }

    $response = $response->withJson(['data' => $realTime->getBatch($finalParsedUrls)]);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET');
});

// $app->get('/realtime[/{url:.+}]', function (Request $request, Response $response, array $args) {
//     var_dump($args['url']);
//     $realTime = new GoogleAnalyticsRealTime();
//     $realTime->setParams('filters', 'rt:pagePath=@' . ($args['url'] ?? ''));

//     $response = $response->withJson(['data' => $realTime->getActiveUsers()]);
//     return $response
//         ->withHeader('Access-Control-Allow-Origin', '*')
//         ->withHeader('Access-Control-Allow-Methods', 'GET');
// });

$app->run();

