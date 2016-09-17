<?php
	/**
	  *	Displays every Request from the server
	  */
	
	require_once("../lib/Connector.class.php");
	require_once("../lib/LongPolling.class.php");
	
	class Receiver implements iReceiver {
		public function onReceive($data) {

			print_r($data);			
			
		}
	
	
		public function onError($info) { }		
	}
	
	
	
	$cn = new Connector("INSERT_YOUR_TOKEN_HERE");
	$lp = new LongPoll($cn);
	
	$rc = new Receiver();
	
	$lp->start($rc);

?>