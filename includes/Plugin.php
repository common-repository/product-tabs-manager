<?php

namespace WooCommerceProductTabsManager;

defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin.
 *
 * @since 1.0.0
 *
 * @package WooCommerceProductTabsManager
 */
final class Plugin extends ByteKit\Plugin {

	/**
	 * Plugin constructor.
	 *
	 * @param array $data The plugin data.
	 *
	 * @since 1.0.0
	 */
	protected function __construct( $data ) {
		parent::__construct( $data );
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define constants.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function define_constants() {
		$this->define( 'WCPTM_VERSION', $this->get_version() );
		$this->define( 'WCPTM_FILE', $this->get_file() );
		$this->define( 'WCPTM_PATH', $this->get_dir_path() );
		$this->define( 'WCPTM_URL', $this->get_dir_url() );
		$this->define( 'WCPTM_ASSETS_URL', $this->get_assets_url() );
		$this->define( 'WCPTM_ASSETS_PATH', $this->get_assets_path() );
		$this->define( 'WCPTM_TEMPLATE_PATH', $this->get_dir_path() . 'templates/' );
	}

	/**
	 * Include required files.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function includes() {
		require_once __DIR__ . '/functions.php';
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function init_hooks() {
		register_activation_hook( $this->get_file(), array( $this, 'install' ) );
		add_action( 'before_woocommerce_init', array( $this, 'on_before_woocommerce_init' ) );
		add_action( 'woocommerce_init', array( $this, 'init' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Run on plugin activation.
	 *
	 * @since 2.1.0
	 * @return void
	 */
	public function install() {
		// Add option for installed time.
		add_option( 'wcptm_installed', wp_date( 'U' ) );
	}

	/**
	 * Run on before WooCommerce init.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function on_before_woocommerce_init() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', $this->get_file(), true );
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', $this->get_file(), true );
		}
	}

	/**
	 * Init the plugin after plugins_loaded so environment variables are set.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function init() {
		$this->set( PostTypes::class );
		$this->set( Helpers::class );
		$this->set( Frontend\Products::class );

		if ( is_admin() ) {
			$this->set( Admin\Admin::class );
			$this->set( Admin\Menus::class );
			$this->set( Admin\Actions::class );
			$this->set( Admin\Products::class );
			$this->set( Admin\Notices::class );
		}

		// Init action.
		do_action( 'product_tabs_manager_init' );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		product_tabs_manager()->scripts->register_style( 'wcptm-frontend', 'css/frontend.css' );
		product_tabs_manager()->scripts->register_script( 'wcptm-frontend', 'js/frontend.js' );
	}
}
