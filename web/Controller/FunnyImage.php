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
use SlackBotService\Model\Response;
use Stichoza\GoogleTranslate\TranslateClient;
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
class FunnyImage {

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
	public function post( Request $request, Application $app ) {
		$category = $request->get( 'category', 'all' );
		/**
		 * Todo support another fact
		 */
		$response = new AttachmentResponse();

		if ( $category ==='programming' ) {
			$data = $this->getRandomFactOfProgramming();
			$response->setTitle($data['title']);
			$response->setImageUrl($data['image_url']);
		} else {
			$categorylist = implode( ', ', array_keys( $this->images ) );
			$response->setText( 'I don\'t know about this category, I only know abount ' . $categorylist );
		}

		return new JsonResponse( $response );
	}

	/**
	 * Summary.

	 *
*@since  0.9.0

	 * @see
	 * @return array('title', 'image_url')

	 * @author nguyenvanduocit
	 */
	public function getRandomFactOfProgramming(){
		$client = new Client();
		$response = $client->get('http://thecodinglove.com/random');
		if($response->getStatusCode() === 200){
			$result = array(
				'title'=>'',
				'image_url'=>''
			);
			$crawler = new Crawler($response->getBody()->getContents());
			/**
			 * Get the title
			 */
			$titleCrawler = $crawler->filterXPath('//div[@id="post1"]//h3');
			if($titleCrawler){
				$result['title']= $titleCrawler->text();
			}
			/**
			 * Get image
			 */
			$imageCrawler = $crawler->filterXPath('//div[@class="bodytype"]//img');
			if($imageCrawler){
				$result['image_url'] = $imageCrawler->attr('src');
			}
			return $result;
		}
		else{
			return array(
				'title'=>'No image found' . $response->getStatusCode(),
				'image_url'=>'http://funny.topdev.vn/wp-content/uploads/images/when-they-tell-me-the-website-has-to-be-supported-by-ie6-1439201300.gif'
			);
		}
	}
}