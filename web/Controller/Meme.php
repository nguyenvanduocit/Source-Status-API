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
		$this->outputDir = APP_DIR.'/public/meme';
		$this->memeList = array(
			'2'=>array(
				'src'=>APP_DIR.'/Asset/meme/2.jpg',
				'position'=>array(
					array(
						'y'=>59
					),
					array(
						'y'=>188
					)
				),
				'font'=>array(
					'size'=>50,
					'color'=>'fff'
				)
			),
			'3'=>array(
				'src'=>APP_DIR.'/Asset/meme/3.jpg',
				'position'=>array(
					array(
						'y'=>427
					)
				),
				'font'=>array(
					'size'=>40,
					'color'=>'000'
				)
			),
			'4'=>array(
				'src'=>APP_DIR.'/Asset/meme/4.jpg',
				'position'=>array(
					array(
						'y'=>490
					)
				),
				'font'=>array(
					'size'=>40,
					'color'=>'000'
				)
			),
			'5'=>array(
				'src'=>APP_DIR.'/Asset/meme/5.jpg',
				'position'=>array(
					array(
						'y'=>83
					)
				),
				'font'=>array(
					'size'=>40,
					'color'=>'000'
				)
			),
			'6'=>array(
				'src'=>APP_DIR.'/Asset/meme/6.jpg',
				'position'=>array(
					array(
						'x'=>33,
						'y'=>580
					)
				),
				'font'=>array(
					'size'=>40,
					'color'=>'000'
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
		$resultObject = new Response();
		if(array_key_exists($backgroundId, $this->memeList)){
			$text = $request->get('text');
			$meme = $this->memeList[$backgroundId];
			$fileName = md5(mt_rand(1,20)).'.jpg';
			$mailLayer = ImageWorkshop::initFromPath($meme['src']);
			$textPaths = explode(';', $text);
			foreach($textPaths as $index=>$text){
				if(array_key_exists($index, $meme['position'])){
					$position = $meme['position'][$index];
				}
				else{
					$lastPostion = count($meme['position'])-1;
					$position = $meme['position'][$lastPostion];
				}
				$textLayer = ImageWorkshop::initTextLayer($text, APP_DIR.'/Asset/font/OpenSans-Bold.ttf', $meme['font']['size'], $meme['font']['color'], 0, null);
				$mailLayer->addLayer($index,$textLayer );
			}
			$mailLayer->save($this->outputDir,$fileName);
			$resultObject->setMessage('http://slackbotapi.senviet.org/web/public/meme/'.$fileName.'?rand='.uniqid('rand', FALSE));

		}
		else{
			$resultObject->setMessage('http://slackbotapi.senviet.org/web/public/meme/404.png');
		}
		return new JsonResponse($resultObject);
	}
}