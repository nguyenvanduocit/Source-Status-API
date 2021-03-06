<?php
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
define('APP_DIR', __DIR__);
require_once APP_DIR . '/../vendor/autoload.php';

$app = new Silex\Application();

//handling CORS respons with right headers
$app->after(function (Request $request, Response $response) {
	$response->headers->set("Access-Control-Allow-Origin","*");
	$response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
});

/**
 * API router
 */
$app->post( '/SourceQuery', '\SourceStatus\Controller\SourceInfoQuery::post' )->bind('SourceQuery');

/**
 * Index request
 */
$app->get( '/', '\SourceStatus\Controller\Front::index' );

/**
 * Error handler
 */
$app->error( function ( \Exception $e, $code ) {
	return new JsonResponse( array( 'errorCode' => $code, 'message' => $e->getMessage() ) );
} );
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__."/View",
));
$app->register(new UrlGeneratorServiceProvider());
$app->run();
