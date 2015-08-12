<?php
/**
 * Believe about
 * This controler show some think about some things
 * Example what developer believe about name ? => the content of http://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/
 * Ideal from : http://blog.codinghorror.com/doing-terrible-things-to-your-code/
 *
*@since  0.9.0
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
class BelieveAbout {
	protected $quotes;
	public function __construct(){
		$this->quotes = array(
			'funny' => array(
				"Cưỡi sao lên hỏi ông trời\nTrai không mê gái trên đời có không?\nÔng trời ổng bảo 'hỏi ngôg!'\nTrai không mê gái ... 'công công' hả mày ?",
				"Thất tình tự tử đu cây mận\nCây mận rung rinh ngã cái uỳnh\nNào ngờ dưới đất cây đinh nhọn\nKhông chết vì tình, chết vì đinh.",
				"Nếu biết rằng em đã lấy chồng\nAnh về lấy vợ thế là xong\nMười tám năm sau con anh lớn\nQuyết tán con em trả hận lòng.",
				"Ngồi buồn ta đếm ngón tay.\nỦa sao ngón ngắn ngón dài vậy ta.\nNghỉ hoài mà cũng chẳng ra.\nLấy dao chặt bớt thế là bằng nhau.",
				'Cẩn thận người nằm bên cạnh bạn, không nên trùm chăn kín đầu đến chân vì người đó có thể \'bủm\'!',
				"Nếu lỡ ngày mai em có chồng\nAnh về lê gót tận biển đông\nLên tàu vượt biển đi qua Mỹ\nXa mặt mong sao sẽ cách lòng.",
				'Đi làm muộn cũng có cái lợi vì nó góp phần làm giảm nạn … kẹt xe.',
				'Ăn hột mít luộc có thể gây mất đoàn kết nội bộ và nghi ngờ lẫn nhau.',
				'Những cô gái giống như những tên miền Internet, những tên đẹp mà ta thích đã có chủ nhân rồi!',
				"Con mèo mà trèo cây cau, hỏi thăm chú chuột đi đâu vắng nhà.\nChú chuột đi chợ đằng xa,\nem là cô chuột, vào nhà đi anh!",
				"Má ơi đừng gả con xa\nChim kêu vượn hú biết nhà má đâu\nThôi má hãy gả nhà giàu\nCó tiền chỉnh mặt, làm đầu cho con.",
				"Đời nhân viên là đời đau khổ\nHãy đứng lên lật đổ lít đờ.",
				"Nếu biết ngày mai em lấy chồng\nAnh vào bộ đội pháo phòng không\nBắn vào đám cưới mấy trăng phát\nBắn chết chồng em lúc động phòng.",
				'Không phải người đàn bà nào cũng đẹp và không phải người đẹp nào cũng là đàn bà.',
				'Thất tình tự tử đu dây điện. Điện giật tê tê chết từ từ',
				"Uớc gì em hoá thành trâu.\nĐể anh là đỉa anh bâu lấy đùi.",
				'Cứ vui chơi cho hết đời trai trẻ. Rồi âm thầm lặng lẽ đạp xích lô.',
				"Dẫu biết rằng cố ăn là sẽ béo\nNên dặn lòng càng béo lại càng xinh.",
				"Thuận vợ thuận chồng\nĐông con cũng mệt",
				'Thà hôn em một lần rồi chịu tát còn hơn cả đời nhìn thằng khác hôn em.',
				'Trăm năm bia đá cũng mòn , bia chai cũng bể , chỉ còn bia … ôm.'
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
	public function post(Request $request, Application $app){
		$category = $request->get('category', 'all');
		$response = new AttachmentResponse();
		$response->setType('text');
		if(array_key_exists($category, $this->quotes)){
			$quotes = $this->quotes[$category];
			$quoteContent = $quotes[array_rand($quotes)];
			$response->setText($quoteContent);
		}
		else{
			$categorylist = implode(', ', array_keys($this->quotes));
			$response->setText('I don\'t know about this category, I only know abount '.$categorylist);
		}

		return new JsonResponse($response);
	}
}