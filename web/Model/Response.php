<?php
/**
 * Summary
 * Description.
 *
 * @since  0.9.0
 * @package
 * @subpackage
 * @author nguyenvanduocit
 */

namespace SlackBotService\Model;


use JsonSerializable;

class Response implements JsonSerializable{
	protected $type;
	protected $message;
	protected $errorCode = null;
	public function __construct($message = '', $errorCode = null, $type='text'){
		$this->message = $message;
		$this->errorCode = $errorCode;
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param mixed $message
	 */
	public function setMessage( $message ) {
		$this->message = $message;
	}
	public function jsonSerialize() {
		$json = array();
		foreach($this as $key => $value) {
			$json[$key] = $value;
		}
		return $json;
    }

	/**
	 * @return null
	 */
	public function getErrorCode() {
		return $this->errorCode;
	}

	/**
	 * @param null $errorCode
	 */
	public function setErrorCode( $errorCode ) {
		$this->errorCode = $errorCode;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType( $type ) {
		$this->type = $type;
	}
}