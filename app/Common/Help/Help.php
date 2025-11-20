<?php
namespace AIOSEO\Plugin\Common\Help;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Help {
	/**
	 * Source of the documentation content.
	 * Disabled - Independent plugin
	 *
	 * @since 4.0.0
	 *
	 * @var string
	 */
	private $url = '';

	/**
	 * Settings.
	 * Disabled - Independent plugin
	 *
	 * @since 4.0.0
	 *
	 * @var array
	 */
	private $settings = [
		'docsUrl'          => '#',
		'supportTicketUrl' => '#',
		'upgradeUrl'       => '#'
	];

	/**
	 * Gets the URL for the notifications api.
	 *
	 * @since 4.0.0
	 *
	 * @return string The URL to use for the api requests.
	 */
	private function getUrl() {
		if ( defined( 'AIOSEO_DOCS_FEED_URL' ) ) {
			return AIOSEO_DOCS_FEED_URL;
		}

		return $this->url;
	}

	/**
	 * Returns the help docs for our menus.
	 * Disabled - Independent plugin
	 *
	 * @since 4.0.0
	 *
	 * @return array The help docs.
	 */
	public function getDocs() {
		// Disabled - Independent plugin without external help docs
		return [];
	}
}