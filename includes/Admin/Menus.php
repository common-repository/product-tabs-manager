<?php

namespace WooCommerceProductTabsManager\Admin;

use WooCommerceProductTabsManager\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Admin class.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */
class Menus {

	/**
	 * Menus constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'main_menu' ) );
		add_action( 'product_tabs_manager_all-product-tabs_content', array( $this, 'output_all_product_tabs_content_and_list' ) );
		add_action( 'product_tabs_manager_tab-settings_general_content', array( $this, 'output_general_settings_page' ) );
		add_action( 'product_tabs_manager_tab-settings_export-import_content', array( $this, 'output_export_import_settings_page' ) );
		add_action( 'product_tabs_manager_tab-settings_default-tabs_content', array( $this, 'output_default_tabs_settings_page' ) );
	}

	/**
	 * Main menu.
	 *
	 * @since 1.0.0
	 */
	public function main_menu() {
		add_menu_page(
			esc_html__( 'WC Tab Manager', 'product-tabs-manager' ),
			esc_html__( 'WC Tab Manager', 'product-tabs-manager' ),
			'manage_options',
			'product-tabs-manager',
			null,
			WCPTM_ASSETS_URL . 'images/menu-icon.svg',
			'55.5'
		);

		add_submenu_page(
			'product-tabs-manager',
			esc_html__( 'All Product Tabs', 'product-tabs-manager' ),
			esc_html__( 'All Product Tabs', 'product-tabs-manager' ),
			'manage_options',
			'product-tabs-manager',
			array( $this, 'output_tab_list_page' )
		);
		add_submenu_page(
			'product-tabs-manager',
			esc_html__( 'Add New Tab', 'product-tabs-manager' ),
			esc_html__( 'Add New Tab', 'product-tabs-manager' ),
			'manage_options',
			admin_url( 'admin.php?page=product-tabs-manager&new=1' ),
			null
		);

		add_submenu_page(
			'product-tabs-manager',
			esc_html__( 'Settings', 'product-tabs-manager' ),
			esc_html__( 'Settings', 'product-tabs-manager' ),
			'manage_options',
			'wcptm-settings',
			array( $this, 'output_tab_settings_page' )
		);
	}

	/**
	 * Output main page.
	 *
	 * @since 1.0.0
	 */
	public function output_tab_list_page() {
		$page_hook = 'all-product-tabs';
		include __DIR__ . '/views/admin-page.php';
	}

	/**
	 * Output main page.
	 *
	 * @since 1.0.0
	 */
	public function output_tab_settings_page() {
		$page_hook = 'tab-settings';
		$tabs      = array(
			'general'       => __( 'General', 'product-tabs-manager' ),
			'default-tabs'  => __( 'Default Tabs', 'product-tabs-manager' ),
			'export-import' => __( 'Export / Import', 'product-tabs-manager' ),
			'documentation' => __( 'Documentation', 'product-tabs-manager' ),
		);
		$tabs      = apply_filters( 'product_tabs_manager_settings_tabs', $tabs );
		include __DIR__ . '/views/admin-page.php';
	}

	/**
	 * Output all product tabs content and list.
	 *
	 * @since 1.0.0
	 */
	public function output_all_product_tabs_content_and_list() {
		$add_new_tab = isset( $_GET['new'] ) ? true : false; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$edit_tab_id = isset( $_GET['edit'] ) ? absint( wp_unslash( $_GET['edit'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( $add_new_tab ) {
			$tab_details = Helpers::get_tab_settings();
			include __DIR__ . '/views/edit-product-tabs.php';
		} elseif ( $edit_tab_id ) {
			$tab_details = Helpers::get_tab_settings( $edit_tab_id );
			include __DIR__ . '/views/edit-product-tabs.php';
		} else {
			include __DIR__ . '/views/all-tabs-list.php';
		}
	}

	/**
	 * Output settings page.
	 *
	 * @since 1.0.0
	 */
	public function output_general_settings_page() {
		include __DIR__ . '/views/settings/general.php';
	}

	/**
	 * Output general settings page.
	 *
	 * @since 1.0.0
	 */
	public function output_default_tabs_settings_page() {
		include __DIR__ . '/views/settings/default-tabs.php';
	}

	/**
	 * Output general settings page.
	 *
	 * @since 1.0.0
	 */
	public function output_export_import_settings_page() {
		include __DIR__ . '/views/settings/export-import.php';
	}
}
