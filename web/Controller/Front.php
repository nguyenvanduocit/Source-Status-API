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

namespace SourceStatus\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Translate
 * Summary
 *
 * @since   0.9.0
 * @access (private, protected, or public)
 * @package SlackBotService\Controller
 */
class Front {
	public function index(Request $request, Application $app){
		return $app['twig']->render('index.twig', array(
			'title' => 'CS4VN - Counter Strike for VietNamese',
		));
	}
}