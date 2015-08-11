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
class Meme {
	protected $memeList;
	protected $outputDir;
	public function __construct()
	{
		$this->outputDir = APP_DIR.'/public/meme';
		$this->memeList = array(
			'1'=>array(
				'src'=>APP_DIR.'/Asset/meme/1.jpg',
				'position'=>array(
					'top'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'fff'
				)
			),
			'2'=>array(
				'src'=>APP_DIR.'/Asset/meme/2.jpg',
				'position'=>array(
					'top',
					'bottom'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'fff'
				)
			),
			'3'=>array(
				'src'=>APP_DIR.'/Asset/meme/3.jpg',
				'position'=>array(
					'bottom'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'000'
				)
			),
			'4'=>array(
				'src'=>APP_DIR.'/Asset/meme/4.jpg',
				'position'=>array(
					'bottom'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'000'
				)
			),
			'5'=>array(
				'src'=>APP_DIR.'/Asset/meme/5.jpg',
				'position'=>array(
					'top'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'000'
				)
			),
			'6'=>array(
				'src'=>APP_DIR.'/Asset/meme/6.jpg',
				'position'=>array(
					'bottom'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'000'
				)
			),
			'7'=>array(
				'src'=>APP_DIR.'/Asset/meme/7.jpg',
				'position'=>array(
					'bottom'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'000'
				)
			),
			'8'=>array(
				'src'=>APP_DIR.'/Asset/meme/8.jpg',
				'position'=>array(
					'bottom'
				),
				'font'=>array(
					'size'=>80,
					'color'=>'000'
				)
			),
			'9'=>array(
				'src'=>APP_DIR.'/Asset/meme/9.jpg',
				'position'=>array(
					'bottom'
				),
				'font'=>array(
					'size'=>70,
					'color'=>'000'
				)
			),
			'wumbo'=>array(
				'src'=>APP_DIR.'/Asset/meme/wumbo.jpg',
				'position'=>array(
					'bottom'
				),
				'font'=>array(
					'size'=>70,
					'color'=>'fff'
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
		$resultObject = new AttachmentResponse();
		if(array_key_exists($backgroundId, $this->memeList)){
			$text = $request->get('text');
			$meme = $this->memeList[$backgroundId];
			$fileName = md5(mt_rand(1,20)).'.jpg';
			$mainLayer = ImageWorkshop::initFromPath($meme['src']);
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
				if($textLayer->getWidth() >= $mainLayer->getWidth()) {
					$textLayer->resizeInPixel( $mainLayer->getWidth() - 100, NULL, TRUE );
				}
				if($position ==='top'){
					$y = 0 + 20;
				}
				else{
					$y = $mainLayer->getHeight()-$textLayer->getHeight() - 20;
				}
				$x = $mainLayer->getWidth()/2 - $textLayer->getWidth()/2;
				$mainLayer->addLayer($index,$textLayer, $x, $y);
			}
			$mainLayer->save($this->outputDir,$fileName);
			$resultObject->setImageUrl('http://slackbotapi.senviet.org/web/public/meme/'.$fileName.'?rand='.uniqid('rand', FALSE));

		}
		else{
			$resultObject->setImageUrl('http://slackbotapi.senviet.org/web/public/meme/list.jpg');
		}
		return new JsonResponse($resultObject);
	}
	public function memoList(Request $request, Application $app){
		$resultObject = new Response();
		$resultObject->setText('http://slackbotapi.senviet.org/web/public/meme/list.jpg');
		return new JsonResponse($resultObject);
	}
}