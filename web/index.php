<?php
use Symfony\Component\HttpFoundation\JsonResponse;
define('APP_DIR', __DIR__);
require_once APP_DIR . '/../vendor/autoload.php';

$app = new Silex\Application();

/**
 * Register database service
 */
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
	'db.options' => array(
		'dbname' => 'mydb',
		'user' => 'user',
		'password' => 'secret',
		'host' => 'localhost',
		'driver' => 'pdo_mysql',
	),
));
/**
 * router
 */
$app->post( '/translate', '\SlackBotService\Controller\Translate::translate' );
$app->post( '/zingmp3', '\SlackBotService\Controller\ZingMp3::post' );

$app->post( '/meme/generate', '\SlackBotService\Controller\Meme::generate' );
$app->post( '/meme/list', '\SlackBotService\Controller\Meme::memoList' );

$app->post( '/quote', '\SlackBotService\Controller\Quote::post' );
$app->post( '/horoscope', '\SlackBotService\Controller\Horoscope::post' );

$app->get('/public/meme/{filename}', function (Silex\Application $app, $filename){
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
