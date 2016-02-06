<?php
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
define('APP_DIR', __DIR__);
require_once APP_DIR . '/../vendor/autoload.php';

$app = new Silex\Application();

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
$app->after(function (Request $request, Response $response) {
	$response->headers->set('Access-Control-Allow-Origin', '*');
});
$app->run();
