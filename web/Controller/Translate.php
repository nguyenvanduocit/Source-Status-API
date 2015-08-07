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


use Silex\Application;
use SlackBotService\Model\Response;
use Stichoza\GoogleTranslate\TranslateClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Translate
 * Summary
 *
 * @since   0.9.0
 * @access (private, protected, or public)
 * @package SlackBotService\Controller
 */
class Translate {
	/**
	 * Summary.
	 *
	 * @since  0.9.0
	 * @see
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 * @param \Silex\Application                        $app
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 * @author nguyenvanduocit
	 */
	public function translate(Request $request, Application $app){
		$resultObject = new Response();
		$from = $request->get('from');
		$to = $request->get('to', 'en');
		$text = $request->get('text');

		$translator = new TranslateClient($from, $to);
		$translatedText = $translator->translate($text);
		if($translatedText){
			$from = ($from?$from:$translator->getLastDetectedSource());
			$messageFormat = '%1$s -> %2$s : %3$s';
			$message  = sprintf($messageFormat, $from, $to, $translatedText);
			$resultObject->setMessage($message);
		}
		else{
			$resultObject->setErrorCode(404);
			$detectedSource = $translator->getLastDetectedSource();
			if(!$detectedSource){
				$resultObject->setMessage('Can not detect your language');
			}
			else{
				$resultObject->setMessage('Can not translate your text.');
			}
		}
		return new JsonResponse($resultObject);
	}
}