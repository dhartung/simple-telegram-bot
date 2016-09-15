<?php

require_once("Connector.class.php");
require_once("iReceiver.class.php");

/**
 *	Provides a basic long polling functionallity
 *
 *	Inspired by @kolar 's Poll Bot ({@link https://github.com/kolar/telegram-poll-bot})
 *
 *	@link https://core.telegram.org/bots/api#getting-updates
*/
class LongPoll {
	
	/**
	 *	Limit of updates to be retrieved
	 *
	 *	@link https://core.telegram.org/bots/api#getupdates
	 */
	public $pollingLimit = 100;
	
	/**
	 *	Timeout for long polling in seconds 
	 *
	 *	@link https://core.telegram.org/bots/api#getupdates
	 */
	public $pollingTimeout = 600;
	
	
	protected $pollingOffset = null;
	protected $connector;
	
	protected $handler;
	
	
	/**
	 *	@param Connector $connector 	An instance of the Connector class
	 */
	public function __construct($connector) {
		$this->connector = $connector;		
	}
	
	/**
	 *	Starts long polling
	 *
	 *	@param iReceiver $receiver 		An instance of a iReceiver class. The functions onReceive() and onError() may be executed
	 */
	public function start(iReceiver $receiver) {
		$this->handler = $receiver;
		
		while (true) {
			
			try {
				$this->doPoll();
				
			} catch (Exception $ex) {
				$this->handler->onError($ex);
				
				sleep(30);
			}		
		}
			
	}	
	
	protected function doPoll() {
		echo "Executed";
		
		$params = array(
		  'limit' => $this->pollingLimit,
		  'timeout' => $this->pollingTimeout,
		);
		
		if ($this->pollingOffset != null)
			$params['offset'] = $this->pollingOffset;

		$result = $this->connector->request('getUpdates', $params, $this->pollingTimeout + 10);
		
		if ($result['ok']) {			
		  $items = $result['result'];
		  
			for ($i = 0; $i < count($items); $i++) {
			  $this->pollingOffset = $items[$i]['update_id'] + 1;
			  
			  $this->handler->onReceive($items[$i]);
			}
			
		} else {			
			$this->handler->onError($result);			
		}
	}	
}