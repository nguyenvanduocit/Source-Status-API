<?php
/**
 * Summary
 * Description.
 *
 * @since  0.9.0
 * @package
 * @subpackage
 * @author nguyenvanduocit
 */

namespace SlackBotService\Controller;

use GuzzleHttp\Client;
use Silex\Application;
use SlackBotService\Model\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class ZingMp3 {
	protected $keycode = 'fafd463e2131914934b73310aa34a23f';
	protected $baseURI = 'http://api.mp3.zing.vn/api/mobile/';
	public function post(Request $request, Application $app){
		$resultObject = new Response();
		$path = $request->get('path');
		if(!$path){
			$resultObject->setErrorCode(404);
			$resultObject->setMessage('Your path is not exist');
			return new JsonResponse($resultObject);
		}
		$objectId = $request->get('id');
		$httpClient = new Client();
		$endpoint = sprintf('%1$s/%2$s?keycode=%3$s&requestdata=%4$s', $this->baseURI, $path, $this->keycode, json_encode(array('id'=>$objectId)));
		$res = $httpClient->get($endpoint);
		if($res->getStatusCode() === 200){
			$bodyObject = json_decode($res->getBody()->getContents());
			if(isset($bodyObject->source)){
				/**
				 * This type have source : song, video
				 */
				if(isset($bodyObject->source->{'1080'})) {
					$resultObject->setMessage( $bodyObject->source->{'1080'} );
				}
				else if(isset($bodyObject->source->{'720'})) {
					$resultObject->setMessage( $bodyObject->source->{'720'} );
				}
				else if(isset($bodyObject->source->{'480'})) {
					$resultObject->setMessage( $bodyObject->source->{'480'} );
				}
				else if($bodyObject->source && isset($bodyObject->source->{'320'})){
					$resultObject->setMessage($bodyObject->source->{'320'});
				}else if($bodyObject->source && isset($bodyObject->source->{'128'})){
					$resultObject->setMessage($bodyObject->source->{'128'});
				}
			}
			else if(isset($bodyObject->content)){
				/**
				 * Lyric
				 */
				$resultObject->setMessage($bodyObject->content);
			}
			else{
				$resultObject->setErrorCode(100);
				$resultObject->setMessage('This song was blog download by Zing.');
			}
		}
		else{
			$resultObject->setErrorCode($res->getStatusCode());
			$resultObject->setMessage($res->getBody()->getContents());
		}
		return new JsonResponse($resultObject);
	}

}