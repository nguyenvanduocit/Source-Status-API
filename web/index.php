<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', __DIR__);

$app = new Silex\Application();
$app->post( '/translate', '\SlackBotService\Controller\Translate::translate' );
$app->post( '/zingmp3', '\SlackBotService\Controller\ZingMp3::post' );
$app->post( '/meme', '\SlackBotService\Controller\Meme::generate' );
$app->error( function ( \Exception $e, $code ) {
	return new JsonResponse( array( 'errorCode' => $code, 'message' => $e->getMessage() ) );
} );

$app->run();
