<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    Flextensions
 * @subpackage WordPress
 * @author     Felix Herzog
 * @copyright  2021 
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://github.com/fleks/flextensions-for-elementor,
 *             Flextensions for Elementor on GitHub)
 * @since      1.0.0
 * php version 7.2
 */

namespace Flextensions;

defined( 'ABSPATH' ) || die(); // Blocks direct access to the plugin PHP files.

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Widgets {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once 'widgets/class-flextensions-top-arrow.php';
		require_once 'widgets/class-flextensions-all-controls.php';
		require_once 'widgets/class-flextensions-all-animations.php';
		require_once 'widgets/class-flextensions-side-buttons.php';
		require_once 'widgets/class-flextensions-multiline-heading.php';
		require_once 'widgets/class-flextensions-flex-gallery.php';
		
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// Include Widgets files.
		$this->include_widgets_files();

		// Register the plugin widget classes.
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Flextensions_TopArrow() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Flextensions_AllControls() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Flextensions_AllAnimations() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Flextensions_MultilineHeading() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Flextensions_SideButtons() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Flextensions_FlexGallery() );
	}

	/**
	 * Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Register the widgets.
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}
}

// Instantiate the Widgets class.
Widgets::instance();
