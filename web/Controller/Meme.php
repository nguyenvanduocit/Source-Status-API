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

use Imagine\Gd\Imagine;
use Silex\Application;
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
class Meme {
	protected $memeList;
	protected $outputDir;
	public function __construct()
	{
		$this->outputDir = 'Public/Meme';
		$this->memeList = array(
			'1'=>array(
				'src'=>'Asset/meme/1.jpg',
				'position'=>array(
					array(10, 10)
				)
			)
		);
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
	public function generate(Request $request, Application $app){
		$backgroundId = $request->get('backgroundId');
		if(array_key_exists($backgroundId, $this->memeList)){
			$resultObject = new Response();
			$backgroundPath = $this->memeList[$backgroundId];
			$imagine = new Imagine();
			$imagine->open($backgroundPath);
			return new JsonResponse($resultObject);
		}
		else{
			/**
			 * Create a troll image
			 */
		}
	}
}