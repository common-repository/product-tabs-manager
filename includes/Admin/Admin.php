<?php

namespace WooCommerceProductTabsManager\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Admin class.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */
class Admin {

	/**
	 * Admin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 1 );
		add_filter( 'woocommerce_screen_ids', array( $this, 'screen_ids' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), PHP_INT_MAX );
		add_filter( 'update_footer', array( $this, 'update_footer' ), PHP_INT_MAX );
	}

	/**
	 * Init.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		require_once __DIR__ . '/functions.php';
	}

	/**
	 * Add the plugin screens to the WooCommerce screens.
	 * This will load the WooCommerce admin styles and scripts.
	 *
	 * @param array $ids Screen ids.
	 *
	 * @return array
	 */
	public function screen_ids( $ids ) {
		return array_merge( $ids, self::get_screen_ids() );
	}

	/**
	 * Get screen ids.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_screen_ids() {
		$screen_ids = array(
			'post.php',
			'toplevel_page_product-tabs-manager',
			'wc-tab-manager_page_wcptm-settings',
		);

		return apply_filters( 'product_tabs_manager_screen_ids', $screen_ids );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook Hook name.
	 *
	 * @since 1.0.0
	 */
	public function admin_scripts( $hook ) {
		$screen_ids = self::get_screen_ids();
		wp_enqueue_style( 'bytekit-components' );
		wp_enqueue_style( 'bytekit-layout' );

		product_tabs_manager()->scripts->register_style( 'product-tabs-manager-admin', 'css/admin.css' );
		product_tabs_manager()->scripts->register_style( 'product-tabs-manager-halloween', 'css/halloween.css' );
		product_tabs_manager()->scripts->register_script( 'product-tabs-manager-admin', 'js/admin.js' );

		if ( in_array( $hook, $screen_ids, true ) ) {
			wp_enqueue_style( 'product-tabs-manager-admin' );
			wp_enqueue_script( 'product-tabs-manager-admin' );

			$localize = array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'product_tabs_manager_nonce' ),
				'i18n'     => array(
					'search_categories' => esc_html__( 'Select categories', 'product-tabs-manager' ),
					'search_products'   => esc_html__( 'Select products', 'product-tabs-manager' ),
					'search_user_role'  => esc_html__( 'Select user role', 'product-tabs-manager' ),
				),
			);

			wp_localize_script( 'product-tabs-manager-admin', 'product_tabs_manager_vars', $localize );
		}
	}

	/**
	 * Admin footer text.
	 *
	 * @param string $footer_text Footer text.
	 *
	 * @since 1.1.4
	 * @return string
	 */
	public function admin_footer_text( $footer_text ) {
		if ( product_tabs_manager()->get_review_url() && in_array( get_current_screen()->id, self::get_screen_ids(), true ) ) {
			$footer_text = sprintf(
			/* translators: 1: Plugin name 2: WordPress */
				__( 'Thank you for using %1$s. If you like it, please leave us a %2$s rating. A huge thank you from PluginEver in advance!', 'product-tabs-manager' ),
				'<strong>' . esc_html( product_tabs_manager()->get_name() ) . '</strong>',
				'<a href="' . esc_url( product_tabs_manager()->get_review_url() ) . '" target="_blank" class="product-tabs-manager-rating-link" data-rated="' . esc_attr__( 'Thanks :)', 'product-tabs-manager' ) . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
			);
		}

		return $footer_text;
	}

	/**
	 * Update footer.
	 *
	 * @param string $footer_text Footer text.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function update_footer( $footer_text ) {
		if ( in_array( get_current_screen()->id, self::get_screen_ids(), true ) ) {
			/* translators: 1: Plugin version */
			$footer_text = sprintf( esc_html__( 'Version %s', 'product-tabs-manager' ), product_tabs_manager()->get_version() );
		}

		return $footer_text;
	}
}
