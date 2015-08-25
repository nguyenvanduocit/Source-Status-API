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

namespace SourceStatus\Model;


use JsonSerializable;

/**
 * Class Response
 * Summary
 *
 * @since   1.0.0
 * @access (private, protected, or public)
 * @package SlackBotService\Model
 */
class Response implements JsonSerializable{
	protected $type;
	protected $text;
	protected $errorCode = null;

	/**
	 * @param string $text
	 * @param null   $errorCode
	 * @param string $type
	 */
	public function __construct($text = '', $errorCode = null, $type='text'){
		$this->text = $text;
		$this->errorCode = $errorCode;
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @param mixed $text
	 */
	public function setText( $text ) {
		$this->text = $text;
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