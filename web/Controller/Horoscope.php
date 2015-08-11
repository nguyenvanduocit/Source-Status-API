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

use PHPImageWorkshop\ImageWorkshop;
use Silex\Application;
use SlackBotService\Model\AttachmentResponse;
use SlackBotService\Model\Response;
use Stichoza\GoogleTranslate\TranslateClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Meme
 * Summary
 *
 * @since   0.9.0
 * @access (private, protected, or public)
 * @package SlackBotService\Controller
 */
class Horoscope {
	public function __construct(){
	}
	/**
	 * Summary.
	 *
	 * @since  0.9.0
	 * @see
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 * @param \Silex\Application                        $app
	 *
	 * @return JsonResponse
	 * @author nguyenvanduocit
	 */
	public function post(Request $request, Application $app){
		$sign = $request->get('sign');
		$response = new AttachmentResponse();
		if(!$sign){
			$response->setMessage('You have to enter the sign');
		}
		else{

		}

		return new JsonResponse($response);
	}
}