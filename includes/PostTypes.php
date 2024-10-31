<?php

namespace WooCommerceProductTabsManager;

defined( 'ABSPATH' ) || exit;

/**
 * Class PostTypes.
 *
 * Responsible for registering custom post types.
 *
 * @package WooCommerceProductTabsManager
 * @since 1.0.0
 */
class PostTypes {

	/**
	 * CPT constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_custom_post_types' ) );
	}

	/**
	 * Register custom post types.
	 *
	 * @since 1.0.0
	 */
	public function register_custom_post_types() {
		$labels = array(
			'name'               => _x( 'Product Tabs Manager', 'post type general name', 'product-tabs-manager' ),
			'singular_name'      => _x( 'Product Tabs Manager', 'post type singular name', 'product-tabs-manager' ),
			'menu_name'          => _x( 'Product Tabs Manager', 'admin menu', 'product-tabs-manager' ),
			'name_admin_bar'     => _x( 'Product Tabs', 'add new on admin bar', 'product-tabs-manager' ),
			'add_new'            => _x( 'Add New', 'Add New Tab', 'product-tabs-manager' ),
			'add_new_item'       => __( 'Add New Tab', 'product-tabs-manager' ),
			'new_item'           => __( 'Add New Tab', 'product-tabs-manager' ),
			'edit_item'          => __( 'Edit Tab', 'product-tabs-manager' ),
			'view_item'          => __( 'View Tab', 'product-tabs-manager' ),
			'all_items'          => __( 'All Tabs', 'product-tabs-manager' ),
			'search_items'       => __( 'Search Tabs', 'product-tabs-manager' ),
			'parent_item_colon'  => __( 'Parent Tab:', 'product-tabs-manager' ),
			'not_found'          => __( 'No tabs found.', 'product-tabs-manager' ),
			'not_found_in_trash' => __( 'No tabs found in trash.', 'product-tabs-manager' ),
		);

		$args = array(
			'labels'              => apply_filters( 'wc_product_tabs_manager_post_type_labels', $labels ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => false,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'query_var'           => false,
			'can_export'          => false,
			'rewrite'             => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => null,
			'supports'            => array( 'title' ),
		);

		register_post_type( 'wcptm-tabs', apply_filters( 'wc_product_tabs_manager_post_type_args', $args ) );
	}
}
