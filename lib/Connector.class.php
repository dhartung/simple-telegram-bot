<?php

/**
 *	The main class for connecting to the Telegram API. 
 */
class Connector {
	
	/**
	 *	Disables or enables the curl SSL verifier.
	 *	May be useful
	 *
	 *	@Todo Set default to true
	 *	@Todo Cant be modified / is only used in constructor
	 */
	public $ssl_verifier = false;
	
	protected $token;
	protected $url;
	protected $curl;
	
	/**
	 *	@param string $token	The token of your Telegram Bot. Keep it secret!
	 *
	 *	@link https://core.telegram.org/bots
	 */
	public function __construct($token) {
		$this->token = $token;
		$this->url = 'https://api.telegram.org/bot' . $token . '/';
		
		$this->setCurl();
	}
	
	protected function setCurl() {
		$this->curl = curl_init();
		
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifier);				
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
	}
	
	
	/**
	 *	Sends a (post) message to the server
	 *	
	 *	@param string $method	The method name
	 *	@param string[] $params	The parameter, encoded as string array
	 *	@param int $timeout		The timeout of the request - Use it for long polling
	 *
	 *	@return mixed[]			Answer of the Server 
	 */
	public function request($method, $params = array(), $timeout = 5) {
		$url = $this->url . $method;
		
		curl_setopt($this->curl, CURLOPT_POST, true);		
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($this->curl, CURLOPT_URL, $url);
		
		curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);


		$raw_result = curl_exec($this->curl);		
		$status_code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);		
		$errorData = curl_errno($this->curl);
		
			
		if ($status_code == 401) {
			throw new Exception('Acces denied. Wrong token?');
		}
		else if($errorData != '') {
			throw new Exception('An error occured: '.$errorData);
		}

		
		return json_decode($raw_result, true);
	}
	
}
?>