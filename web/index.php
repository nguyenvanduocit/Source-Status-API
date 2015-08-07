<?php
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
define('APP_DIR', __DIR__);
require_once APP_DIR . '/../vendor/autoload.php';

$app = new Silex\Application();
$app->post( '/translate', '\SlackBotService\Controller\Translate::translate' );
$app->post( '/zingmp3', '\SlackBotService\Controller\ZingMp3::post' );
$app->post( '/meme', '\SlackBotService\Controller\Meme::generate' );
$app->get('/public/meme/{filename}', function (Silex\Application $app, $filename){
	$filePath = APP_DIR.'/public/meme/' . $filename;
	if (!file_exists($filePath)) {
		$app->abort(404, $filePath . ' not found.');
	}
	$stream = function () use ($filePath) {
		readfile($filePath);
	};
	return $app->stream($stream, 200, array(
		'Content-Type' => 'image/png',
		'Content-length' => filesize($filePath),
		'Content-Disposition' => 'filename="'.$filename.'"'
	));
});
/**
 * Error handler
 */
$app->error( function ( \Exception $e, $code ) {
	return new JsonResponse( array( 'errorCode' => $code, 'message' => $e->getMessage() ) );
} );

$app->run();
