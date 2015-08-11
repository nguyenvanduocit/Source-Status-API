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
	protected $fallback;

	/**
	 * @return mixed
	 */
	public function getFallback() {
		return $this->fallback;
	}

	/**
	 * @param mixed $fallback
	 *
	 * @return AttachmentResponse
	 */
	public function setFallback( $fallback ) {
		$this->fallback = $fallback;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @param mixed $color
	 *
	 * @return AttachmentResponse
	 */
	public function setColor( $color ) {
		$this->color = $color;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPretext() {
		return $this->pretext;
	}

	/**
	 * @param mixed $pretext
	 *
	 * @return AttachmentResponse
	 */
	public function setPretext( $pretext ) {
		$this->pretext = $pretext;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAuthorName() {
		return $this->author_name;
	}

	/**
	 * @param mixed $author_name
	 *
	 * @return AttachmentResponse
	 */
	public function setAuthorName( $author_name ) {
		$this->author_name = $author_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAuthorLink() {
		return $this->author_link;
	}

	/**
	 * @param mixed $author_link
	 *
	 * @return AttachmentResponse
	 */
	public function setAuthorLink( $author_link ) {
		$this->author_link = $author_link;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAuthorIcon() {
		return $this->author_icon;
	}

	/**
	 * @param mixed $author_icon
	 *
	 * @return AttachmentResponse
	 */
	public function setAuthorIcon( $author_icon ) {
		$this->author_icon = $author_icon;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param mixed $title
	 *
	 * @return AttachmentResponse
	 */
	public function setTitle( $title ) {
		$this->title = $title;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTitleLink() {
		return $this->title_link;
	}

	/**
	 * @param mixed $title_link
	 *
	 * @return AttachmentResponse
	 */
	public function setTitleLink( $title_link ) {
		$this->title_link = $title_link;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param mixed $text
	 *
	 * @return AttachmentResponse
	 */
	public function setMessage( $message ) {
		$this->message = $message;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * @param mixed $fields
	 *
	 * @return AttachmentResponse
	 */
	public function setFields( $fields ) {
		$this->fields = $fields;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getThumbUrl() {
		return $this->thumb_url;
	}

	/**
	 * @param mixed $thumb_url
	 *
	 * @return AttachmentResponse
	 */
	public function setThumbUrl( $thumb_url ) {
		$this->thumb_url = $thumb_url;

		return $this;
	}
	protected $color;
	protected $pretext;
	protected $author_name;
	protected $author_link;
	protected $author_icon;
	protected $title;
	protected $title_link;
	protected $message;
	protected $fields;
	protected $image_url;
	protected $thumb_url;
	public function __construct($message = '', $errorCode = null, $type='attachment'){
		parent::__construct($message, $errorCode, $type);
		$this->type = 'attachment';
	}

	/**
	 * @return mixed
	 */
	public function getImageUrl() {
		return $this->image_url;
	}

	/**
	 * @param mixed $image_url
	 */
	public function setImageUrl( $image_url ) {
		$this->image_url = $image_url;
	}
}