<?php

require_once("Connector.class.php");
require_once("iReceiver.class.php");

/**
 *	Provides basic WebHook functions
 *
 *	@link https://core.telegram.org/bots/api#getting-updates
*/
class WebHook {
	
	/**
	 *	Enables or disables a webhook to a specified url 
	 *
	 *	@param Connector $connector 	An instance of the Connector class
	 *	@param string|null $url 		The webhook url. Resets webhooks when url is empty
	 *
	 *	@returns mixed[] 				Answer of the Server
	 *
	 *	@link https://core.telegram.org/bots/api#setwebhook
	 *
	 *	@Todo: Custom certificate
	 */
	public static function setWebhook(Connector $connector, $url) {
		if ($url === null)
			$url = '';
		
		$params = array("url", $url);
		
		$connector->request("setWebhook", $params);
	}
	
	/**
	 *	@param iReceiver $receiver 	An instance of a iReceiver class. The functions onReceive() and onError() may be executed
	 */
	public static function analyse(iReceiver $receiver) {
		$raw_result = file_get_contents('php://input');
				
		try {
			$result = json_decode($raw_result, true);
			
			$receiver->onReceive($result);
		} catch (Exception $ex) {
			$receiver->onError($ex);
		}
	}
	
}