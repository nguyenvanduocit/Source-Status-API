<?php
/**
 * Summary
 * Description.
 *
 * @since  1.0.0
 * @package
 * @subpackage
 * @author nguyenvanduocit
 */

namespace SourceStatus\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SourceInfoQuery
 * Summary
 *
 * @since   1.0.0
 * @access (private, protected, or public)
 * @package SourceStatus\Controller
 */
class SourceInfoQuery {
	public function post(Request $request, Application $app){
		$sourceQuery = new \SourceQuery();
		try
		{
			$ip = $request->get('serverIp');
			$port = $request->get('port');
			$appId = $request->get('appid');
			$sourceQuery->Connect( $ip, $port, 1, $appId );
			$result = array(
				'success'=>true,
				'data'=>array(
					'info'=>$sourceQuery->GetInfo(),
					'players'=>$sourceQuery->GetPlayers(),
					'rules'=>$sourceQuery->GetRules()
				)
			);
			return new JsonResponse($result);
		}
		catch( \Exception $e )
		{
			return new JsonResponse(array('success'=>FALSE, 'message'=> $e->getMessage()));
		}
	}
}