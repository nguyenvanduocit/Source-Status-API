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
use PHPImageWorkshop\ImageWorkshop;
use Silex\Application;
use SlackBotService\Model\AttachmentResponse;
use SlackBotService\Model\DailyHoloscope;
use SlackBotService\Model\Response;
use Stichoza\GoogleTranslate\TranslateClient;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DomCrawler\Crawler;
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
	protected $dailyEndPoint = array(
		'aries'=>'http://my.horoscope.com/astrology/free-daily-horoscope-aries.html',
		'taurus'=>'http://my.horoscope.com/astrology/free-daily-horoscope-taurus.html',
		'gemini'=>'http://my.horoscope.com/astrology/free-daily-horoscope-gemini.html',
		'cancer'=>'http://my.horoscope.com/astrology/free-daily-horoscope-cancer.html',
		'leo'=>'http://my.horoscope.com/astrology/free-daily-horoscope-leo.html',
		'virgo'=>'http://my.horoscope.com/astrology/free-daily-horoscope-virgo.html',
		'libra'=>'http://my.horoscope.com/astrology/free-daily-horoscope-libra.html',
		'scorpio'=>'http://my.horoscope.com/astrology/free-daily-horoscope-scorpio.html',
		'sagittarius'=>'http://my.horoscope.com/astrology/free-daily-horoscope-sagittarius.html',
		'capricorn'=>'http://my.horoscope.com/astrology/free-daily-horoscope-capricorn.html',
		'aquarius'=>'http://my.horoscope.com/astrology/free-daily-horoscope-aquarius.html',
		'pisces'=>'http://my.horoscope.com/astrology/free-daily-horoscope-pisces.html'
	);
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
		$sign = strtolower($sign);
		if(!$sign){
			$errorResponse = new Response();
			$errorResponse->setErrorCode('100');
			$errorResponse->setText('Your have to provice the sign.');
			return new JsonResponse($errorResponse);
		}
		if(!array_key_exists($sign, $this->dailyEndPoint)){
			$errorResponse = new Response();
			$errorResponse->setErrorCode('101');
			$errorResponse->setText('Your sign is not exist.');
			return new JsonResponse($errorResponse);
		}

		$response = new AttachmentResponse();
		$holoscope = $this->getDailyHoroscope($sign);
		$response->setText($holoscope->getContent());
		$response->setThumbUrl($holoscope->getImageURL());
		$response->setTitle($holoscope->getName());
		// Set Field
		$fields = $holoscope->getRating();
		array_walk($fields, function(&$item) { $item['short'] = 'true'; });
		$response->setFields($fields);
		return new JsonResponse($response);
	}
	public function getDailyHoroscope($sign){
		if(!array_key_exists($sign, $this->dailyEndPoint)){
			throw new Exception('Sign is not exist', 100);
		}
		$signURL = $this->dailyEndPoint[$sign];
		$httpClient = new Client();
		$response = $httpClient->get($signURL);
		if($response->getStatusCode() !== 200){
			throw new Exception('Request error', $response->getStatusCode());
		}
		$content = $response->getBody()->getContents();
		$crawler = new Crawler($content);
		/**
		 * Get the content
		 */
		$contentCrawler = $crawler->filterXPath('//div[@id="textline"]');
		if($contentCrawler){
			$holoscope = new DailyHoloscope();
			$holoscope->setContent($contentCrawler->text());
			/**
			 * Get the image
			 */
			$thumbnailCrawler = $crawler->filterXPath('//td[@class="col200"]/div/img');
			if($thumbnailCrawler) {
				$holoscope->setImageURL( 'http://horoscope.com' . $thumbnailCrawler->attr( 'src' ) );
			}
			/**
			 * Get the tile
			 */
			$titleCrawler = $crawler->filterXPath('//h1[@class="h1b"][2]');
			if($titleCrawler) {
				$holoscope->setName( $titleCrawler->text() );
			}

			/**
			 * Get rating
			 */
			/**
			 * {
			 *   "title": "Priority",
			 *   "value": "High",
			 *   "short": false
			 * }
			 */
			$ratingCrawler = $crawler->filterXPath('//img[contains(@src, "starrating")]');
			if($ratingCrawler){
				$fields = array();
				/** @var \DOMElement $domElement */
				foreach ($ratingCrawler as $domElement) {
					$ratingText = $domElement->getAttribute('alt');
					$ratings = explode(':', $ratingText);
					$fields[] = array(
						'title'=>$ratings[0],
						'value'=>$ratings[1]
					);
				}
				$holoscope->setRating($fields);
			}
			return $holoscope;
		}
		else
		{
			throw new Exception('Content not found', 102);
		}
	}
}