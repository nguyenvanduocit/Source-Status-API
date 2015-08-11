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


class DailyHoloscope {
	/**
	 * @return mixed
	 */
	public function getImageURL() {
		return $this->imageURL;
	}

	/**
	 * @param mixed $imageURL
	 *
	 * @return DailyHoloscope
	 */
	public function setImageURL( $imageURL ) {
		$this->imageURL = $imageURL;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 *
	 * @return DailyHoloscope
	 */
	public function setName( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param mixed $content
	 *
	 * @return DailyHoloscope
	 */
	public function setContent( $content ) {
		$this->content = $content;

		return $this;
	}
	protected $imageURL;
	protected $name;
	protected $content;
	protected $rating;

	/**
	 * @return mixed
	 */
	public function getRating() {
		return $this->rating;
	}

	/**
	 * @param mixed $rating
	 */
	public function setRating( $rating ) {
		$this->rating = $rating;
	}

	/**
	 * DailyHoloscope constructor.
	 *
	 * @param $imageURL
	 * @param $name
	 * @param $content
	 */
	public function __construct( $name='', $content='', $imageURL='', $rating = array()) {
		$this->imageURL = $imageURL;
		$this->name     = $name;
		$this->content     = $content;
		$this->rating = $rating;
	}
}