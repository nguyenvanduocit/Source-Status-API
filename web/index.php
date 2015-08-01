<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->post( '/translate', '\SlackBotService\Controller\Translate::translate' );
$app->post( '/zingmp3', '\SlackBotService\Controller\ZingMp3::post' );
$app->error( function ( \Exception $e, $code ) {
	return new JsonResponse( array( 'errorCode' => $code, 'message' => $e->getMessage() ) );
} );

$app->run();
