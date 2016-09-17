<?php
	require_once("iReplyMarkup.class.php");

	
	/**
	 *	@link https://core.telegram.org/bots/api#replykeyboardhide
	 */
	class ReplyKeyboardHide implements iReplyMarkup {
		public $selective = null;
		
		public function toJSON() {
			$output = array("hide_keyboard" => true);
			
			if ($this->selective !== null)
				$output["selective"] = $this->selective;
			
			return json_encode($output);
		}
	}
		
	
	/**
	  *	@link https://core.telegram.org/bots/api#replykeyboardmarkup
	  */
	class ReplyKeyboardMarkup implements iReplyMarkup {
		public $resize_keyboard = null;
		public $one_time_keyboard = null;
		public $selective = null;
		
		protected $data = array();
		
		public function addRow() {
			$arg_list = func_get_args();			
			$result = array();
			 
			for ($i = 0; $i < count($arg_list); $i++) {
				
				if ($arg_list[$i] instanceof ReplyButton) {
					$result[] = $arg_list[$i]->toArray();
				} else {
					$result[] = $arg_list[$i];
				}
			}
			
			$this->data[] = $result;			
		}
		
		public function toJSON() {
			$output = array("keyboard" => $this->data);
			
			if ($this->resize_keyboard !== null)
				$output["resize_keyboard"] = $this->resize_keyboard;
			
			if ($this->one_time_keyboard !== null)
				$output["one_time_keyboard"] = $this->one_time_keyboard;
			
			if ($this->selective !== null)
				$output["selective"] = $this->selective;
			
			return json_encode($output);
		}
	}
	
	abstract class ReplyButton {
		protected $text;
		
		public function __construct($text) {
			$this->text = $text;
		}	
		
		abstract protected function getDataName();
		
		public function toArray() {
			return array (	"text" => $this->text ,
							$this->getDataName() => true );
		}
	}
	
	class RequestContact extends ReplyButton {
		protected function getDataName() { return "request_contact"; }
	}
	
	class RequestLocation extends ReplyButton {
		protected function getDataName() { return "request_location"; }
	}