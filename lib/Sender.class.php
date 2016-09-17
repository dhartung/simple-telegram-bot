<?php
	require_once("Connector.class.php");
	require_once("iReplyMarkup.class.php");


	/**
	 *	Provides some basic function to use a Telegram-Bot
	 *
	 *	@link https://core.telegram.org/bots/api
	 */
	class Sender {
		protected $connector;
		
		/**
		 *	@param Connector $connector 	An instance of the Connector class
		 */
		public function __construct(Connector $connector) {
			$this->connector = $connector;
		}
			
		/**
		 *	Sends a message 
		 *	
		 *	@param mixed $chat_id					Identifier for the target chat_id or username
		 *	@param string $text						Text of the message
		 *	@param string $parse_mode				'Markdown' or 'HTML'
		 *	@param bool $disable_web_page_preview	Disable link previews when set to true
		 *	@param bool $disable_notification		Disables notifications on the client device when set to true
		 *	@param int $reply_to_message_id			If set the message will be a reply
		 *	@param iReplyMarkup $reply_markup		Additional reply information
		 *
		 *	@return	mixed[]							Answer of the server
		 *
		 *	@link https://core.telegram.org/bots/api#sendmessage
		 */
		public function sendMessage($chat_id, 
									$text, 
									$parse_mode = null, 
									$disable_web_page_preview = null, 
									$disable_notification = null, 
									$reply_to_message_id = null, 
									iReplyMarkup $reply_markup = null) {
										
			$params = array();
			$params["chat_id"] = $chat_id;
			$params["text"] = $text;
			
			if ($parse_mode != null)
				$params["parse_mode"] = $parse_mode;
			
			if ($disable_web_page_preview != null)
				$params["disable_web_page_preview"] = $disable_web_page_preview;
				
			if ($disable_notification != null)
				$params["disable_notification"] = $disable_notification;
			
			if ($reply_to_message_id)
				$params["reply_to_message_id"] = $reply_to_message_id;
			
			if ($reply_markup)
				$params["reply_markup"] = $reply_markup->toJSON();
			
			
			print_r($params);
			
			return $this->connector->request("sendMessage", $params);
				
		}		

	}