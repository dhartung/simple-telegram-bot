<?php
	require_once("iReplyMarkup.class.php");

	/**
	 * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
	 */
	class InlineKeyboardMarkup implements iReplyMarkup {		
		protected $data = array();
		
		public function addRow() {
			$arg_list = func_get_args();			
			$result = array();
			 
			for ($i = 0; $i < count($arg_list); $i++) {
				
				if (!($arg_list[$i] instanceof InlineButton))
					throw new Exception("Only type InlineButton is supported");
				
				$result[] = $arg_list[$i]->toArray();
			}
			
			$this->data[] = $result;
		}
		
		public function toJSON() {
			return json_encode(
						array(
							"inline_keyboard" => $this->data
						));	
		}
	}
	
	
	abstract class InlineButton {
		protected $text;
		protected $data;
		
		public function __construct($text, $data) {
			$this->text = $text;
			$this->data = $data;
		}
		
		abstract protected function getDataName();
		
		public function toArray() {
			return array (	"text" => $this->text ,
							$this->getDataName() => $this->data );
		}
	}
	
	class UrlButton extends InlineButton {
		protected function getDataName() { return "url"; }
	}
	
	class CallbackDataButton extends InlineButton {
		protected function getDataName() { return "callback_data"; }
	}

	class SwitchInlineQuery extends InlineButton {
		protected function getDataName() { return "switch_inline_query"; }
	}

