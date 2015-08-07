<?php

/**
 * Static file handler
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (is_file($filename)) {
	return false;
}

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
define('APP_DIR', __DIR__);
require_once APP_DIR . '/../vendor/autoload.php';


$app = new Silex\Application();
$app->post( '/translate', '\SlackBotService\Controller\Translate::translate' );
$app->post( '/zingmp3', '\SlackBotService\Controller\ZingMp3::post' );
$app->post( '/meme', '\SlackBotService\Controller\Meme::generate' );
$app->get('/public/meme/{filename}', function ($filename) use ($app) {
	$filePath = APP_DIR.'/public/meme/' . $filename;
	if (!file_exists($filePath)) {
		$app->abort(404, $filePath . ' not found.');
	}
	return $app->sendFile($filePath);
});
/**
 * Error handler
 */
$app->error( function ( \Exception $e, $code ) {
	return new JsonResponse( array( 'errorCode' => $code, 'message' => $e->getMessage() ) );
} );

$app->run();
