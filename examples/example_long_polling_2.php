<?php
	/**
	 *		Sends an automatic answer to every message	
	 */
	
	
	require_once("../lib/Connector.class.php");
	require_once("../lib/LongPolling.class.php");
	require_once("../lib/Sender.class.php");
	
	class Receiver implements iReceiver {
		public $sender;
		
		public function __construct($connector) {
			$this->sender = new Sender($connector);
		}
		
		public function onReceive($data) {
			
			$chat_id = $data["message"]["chat"]["id"];
			$msg_id = $data["message"]["message_id"];
			$name = $data["message"]["from"]["first_name"];
			
			$this->sender->sendMessage($chat_id, "Thanks for the message, $name.");
			
		}
	
	
		public function onError($info) { }		
	}
	
	
	
	$cn = new Connector("INSERT_YOUR_TOKEN_HERE");
	$lp = new LongPoll($cn);
	
	$rc = new Receiver($cn);
	
	$lp->start($rc);

?>