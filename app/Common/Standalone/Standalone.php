<?php
namespace AIOSEO\Plugin\Common\Standalone;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Removed: use AIOSEO\Plugin\Pro\Standalone - independent plugin uses Common classes

/**
 * Registers the standalone components.
 *
 * @since 4.2.0
 */
class Standalone {
	/**
	 * HeadlineAnalyzer class instance.
	 *
	 * @since 4.2.7
	 *
	 * @var HeadlineAnalyzer
	 */
	public $headlineAnalyzer = null;

	/**
	 * FlyoutMenu class instance.
	 *
	 * @since 4.2.7
	 *
	 * @var FlyoutMenu
	 */
	public $flyoutMenu = null;

	/**
	 * SeoPreview class instance.
	 *
	 * @since 4.2.8
	 *
	 * @var SeoPreview
	 */
	public $seoPreview = null;

	/**
	 * SetupWizard class instance.
	 *
	 * @since 4.2.7
	 *
	 * @var SetupWizard
	 */
	public $setupWizard = null;

	/**
	 * PrimaryTerm class instance.
	 *
	 * @since 4.3.6
	 *
	 * @var PrimaryTerm
	 */
	public $primaryTerm = null;

	/**
	 * UserProfileTab class instance.
	 *
	 * @since 4.5.4
	 *
	 * @var UserProfileTab
	 */
	public $userProfileTab = null;

	/**
	 * BuddyPress class instance.
	 *
	 * @since 4.7.6
	 *
	 * @var BuddyPress\BuddyPress
	 */
	public $buddyPress = null;

	/**
	 * BbPress class instance.
	 *
	 * @since 4.8.1
	 *
	 * @var BbPress\BbPress
	 */
	public $bbPress = null;

	/**
	 * List of page builder integration class instances.
	 *
	 * @since 4.2.7
	 *
	 * @var array[Object]
	 */
	public $pageBuilderIntegrations = [];

	/**
	 * List of block class instances.
	 *
	 * @since 4.2.7
	 *
	 * @var array[Object]
	 */
	public $standaloneBlocks = [];

	/**
	 * Class constructor.
	 *
	 * @since 4.2.0
	 */
	public function __construct() {
		$this->headlineAnalyzer = new HeadlineAnalyzer();
		$this->flyoutMenu       = new FlyoutMenu();
		$this->seoPreview       = new SeoPreview();
		$this->setupWizard      = new SetupWizard();
		$this->primaryTerm      = new PrimaryTerm(); // Always use Common class
		$this->userProfileTab   = new UserProfileTab();
		$this->buddyPress       = new BuddyPress\BuddyPress(); // Always use Common class
		$this->bbPress          = new BbPress\BbPress(); // Always use Common class

		new DetailsColumn(); // Always use Common class

		new AdminBarNoindexWarning();
		new LimitModifiedDate();
		new Notifications();
		new PublishPanel();
		new WpCode();

		$this->pageBuilderIntegrations = [
			'elementor'  => new PageBuilders\Elementor(),
			'divi'       => new PageBuilders\Divi(),
			'seedprod'   => new PageBuilders\SeedProd(),
			'wpbakery'   => new PageBuilders\WPBakery(),
			'avada'      => new PageBuilders\Avada(),
			'siteorigin' => new PageBuilders\SiteOrigin(),
			'thrive'     => new PageBuilders\ThriveArchitect()
		];

		$this->standaloneBlocks = [
			'tocBlock' => new Blocks\TableOfContents(),
			'faqBlock' => new Blocks\FaqPage()
		];
	}
}