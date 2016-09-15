<?php

/**
 *	Interface for a simple message receiver
 */
interface iReceiver {
	
	/**
	  *	This function shall be executed when a new message is received
	  *
	  *	@param mixed[] $data	The message as an array object
	  */
	public function onReceive($data);

	
	/**
	  *	This function shall be executed when a error occurs
	  *
	  *	@param mixed[] $info	Some information concerning the error
	  */
	public function onError($info);
}

?>