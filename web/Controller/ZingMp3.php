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


use Symfony\Component\HttpFoundation\JsonResponse;

class ZingMp3 {
	public function post(){
		return new JsonResponse(array('fuck'=>true));
	}
}