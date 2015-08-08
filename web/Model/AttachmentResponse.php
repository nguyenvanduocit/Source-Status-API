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

/**
 * Class AttachmentResponse
 * Summary
 *
 * @since   0.9.0
 * @access (private, protected, or public)
 * @package SlackBotService\Model
 */
class AttachmentResponse extends Response{
	protected $type;
	public function __construct($message = '', $errorCode = null){
		parent::__construct($message, $errorCode);
		$this->type = 'photo';
	}
}