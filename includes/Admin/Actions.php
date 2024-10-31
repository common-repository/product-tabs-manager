<?php

namespace WooCommerceProductTabsManager\Admin;

use WooCommerceProductTabsManager\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Actions class.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */
class Actions {

	/**
	 * Actions constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_post_add_update_product_tabs_manager', array( __CLASS__, 'handle_add_product_tabs_data' ) );
		add_action( 'admin_post_update_default_tabs_data', array( __CLASS__, 'update_default_tabs_data' ) );
		add_action( 'admin_post_update_general_tabs_data', array( __CLASS__, 'update_general_tabs_data' ) );
		add_action( 'wp_ajax_product_tabs_manager_search_products', array( __CLASS__, 'search_products' ) );
		add_action( 'wp_ajax_product_tabs_manager_search_categories', array( __CLASS__, 'search_categories' ) );
		add_action( 'wp_ajax_product_tabs_manager_search_user_role', array( __CLASS__, 'search_user_role' ) );
	}

	/**
	 * Add product tabs data.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function update_general_tabs_data() {
		check_admin_referer( 'wcptm_update_general_tabs_data' );
		$referer = wp_get_referer();

		/**
		 * Action hook to update general tabs data.
		 *
		 * @since 1.0.0
		 */
		do_action( 'wcptm_before_update_general_tabs_data' );

		$redirect_to = admin_url( 'admin.php?page=wcptm-settings' );
		product_tabs_manager()->flash->success( __( 'General settings updated successfully.', 'product-tabs-manager' ), 'success' );
		wp_safe_redirect( $redirect_to );
		exit;
	}

	/**
	 * Add product tabs data.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function update_default_tabs_data() {
		check_admin_referer( 'wcptm_update_default_tabs_data' );
		$referer = wp_get_referer();

		$tabs         = Helpers::get_default_tabs();
		$default_tabs = array();

		foreach ( $tabs as $key => $tab ) {
			$value = isset( $_POST[ 'wcptm_default_tab_' . $key . '_is_overwrite' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'wcptm_default_tab_' . $key . '_is_overwrite' ] ) ) : 'no';
			if ( 'yes' === $value ) {
				$default_tabs[ $key ] = array(
					'id'             => $key,
					'post_id'        => '',
					'tab_type'       => 'core',
					'tab_icon'       => ! empty( $_POST[ 'wcptm_default_tab_' . $key . '_icon' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'wcptm_default_tab_' . $key . '_icon' ] ) ) : '',
					'position'       => '',
					'type'           => 'default',
					'title'          => $tab['title'],
					'custom_title'   => ! empty( $_POST[ 'wcptm_default_tab_' . $key . '_title' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'wcptm_default_tab_' . $key . '_title' ] ) ) : '',
					'content'        => '',
					'custom_content' => '',
					'heading'        => $tab['heading'],
					'custom_heading' => ! empty( $_POST[ 'wcptm_default_tab_' . $key . '_heading' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'wcptm_default_tab_' . $key . '_heading' ] ) ) : '',
					'disable'        => 'no',
					'is_overwrite'   => $value,
				);
			} else {
				$default_tabs[ $key ] = $tab;
			}
		}

		if ( empty( $default_tabs ) ) {
			delete_option( 'wcptm_customize_default_tabs' );
		} else {
			update_option( 'wcptm_customize_default_tabs', $default_tabs );
		}

		$redirect_to = admin_url( 'admin.php?page=wcptm-settings&tab=default-tabs' );
		product_tabs_manager()->flash->success( __( 'Default tabs updated successfully.', 'product-tabs-manager' ), 'success' );
		wp_safe_redirect( $redirect_to );
		exit;
	}

	/**
	 * Add product tabs data.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function handle_add_product_tabs_data() {
		check_admin_referer( 'wcptm_product_tab_add_update' );
		$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : '';
		$referer = wp_get_referer();

		$data = Helpers::get_tab_settings();
		unset( $data['tab_id'] );
		unset( $data['tab_title'] );

		// Post title & content.
		$wcptm_tab_title        = isset( $_POST['wcptm_tab_title'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_tab_title'] ) ) : '';
		$wcptm_tab_content      = isset( $_POST['wcptm_tab_content'] ) ? Helpers::sanitize_text_content( wp_kses_post( wp_unslash( $_POST['wcptm_tab_content'] ) ) ) : '';
		$wcptm_tab_faq          = isset( $_POST['wcptm_tab_faq'] ) ? map_deep( wp_unslash( $_POST['wcptm_tab_faq'] ), 'sanitize_text_field' ) : array();
		$wcptm_tab_content_type = isset( $_POST['wcptm_tab_content_type'] ) ? wp_kses_post( wp_unslash( $_POST['wcptm_tab_content_type'] ) ) : '';

		// Post Meta Data.
		$wcptm_tab_is_disable          = isset( $_POST['wcptm_tab_is_disable'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_tab_is_disable'] ) ) : 'no';
		$wcptm_tab_visible_type        = isset( $_POST['wcptm_tab_visible_type'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_tab_visible_type'] ) ) : '';
		$wcptm_tab_specific_products   = isset( $_POST['wcptm_tab_specific_products'] ) ? map_deep( wp_unslash( $_POST['wcptm_tab_specific_products'] ), 'sanitize_text_field' ) : '';
		$wcptm_tab_specific_categories = isset( $_POST['wcptm_tab_specific_categories'] ) ? map_deep( wp_unslash( $_POST['wcptm_tab_specific_categories'] ), 'sanitize_text_field' ) : '';

		$args = array(
			'ID'          => $post_id,
			'post_title'  => $wcptm_tab_title,
			'post_type'   => 'wcptm-tabs',
			'post_status' => 'publish',
		);

		$post_id = wp_insert_post( $args );
		if ( is_wp_error( $post_id ) ) {
			product_tabs_manager()->flash->error( __( 'Failed to Add Category Showcase: Please Try Again!', 'product-tabs-manager' ) );
			wp_safe_redirect( $referer );
			exit();
		}

		if ( empty( $wcptm_tab_content_type ) ) {
			delete_post_meta( $post_id, 'wcptm_tab_content_type' );
		} else {
			if ( 'content' === $wcptm_tab_content_type ) {
				if ( empty( $wcptm_tab_content ) ) {
					delete_post_meta( $post_id, 'wcptm_tab_content' );
				} else {
					update_post_meta( $post_id, 'wcptm_tab_content', $wcptm_tab_content );
				}
			} elseif ( 'faq' === $wcptm_tab_content_type ) {
				if ( empty( $wcptm_tab_faq ) ) {
					delete_post_meta( $post_id, 'wcptm_tab_faq' );
				} else {
					update_post_meta( $post_id, 'wcptm_tab_faq', $wcptm_tab_faq );
				}
			}
			update_post_meta( $post_id, 'wcptm_tab_content_type', $wcptm_tab_content_type );
		}

		if ( empty( $wcptm_tab_is_disable ) ) {
			delete_post_meta( $post_id, 'wcptm_tab_is_disable' );
		} else {
			update_post_meta( $post_id, 'wcptm_tab_is_disable', $wcptm_tab_is_disable );
		}

		if ( empty( $wcptm_tab_visible_type ) ) {
			delete_post_meta( $post_id, 'wcptm_tab_visible_type' );
		} else {
			update_post_meta( $post_id, 'wcptm_tab_visible_type', $wcptm_tab_visible_type );
		}

		if ( empty( $wcptm_tab_specific_products ) ) {
			delete_post_meta( $post_id, 'wcptm_tab_specific_products' );
		} else {
			update_post_meta( $post_id, 'wcptm_tab_specific_products', $wcptm_tab_specific_products );
		}

		if ( empty( $wcptm_tab_specific_categories ) ) {
			delete_post_meta( $post_id, 'wcptm_tab_specific_categories' );
		} else {
			update_post_meta( $post_id, 'wcptm_tab_specific_categories', $wcptm_tab_specific_categories );
		}

		/**
		 * Action hook to add product tabs data.
		 *
		 * @param int $post_id Post ID.
		 *
		 * @since 1.0.0
		 */
		do_action( 'after_update_post_data', $post_id );

		$redirect_to = admin_url( 'admin.php?page=product-tabs-manager&edit=' . $post_id );
		product_tabs_manager()->flash->success( __( 'Tab is added successfully.', 'product-tabs-manager' ), 'success' );
		wp_safe_redirect( $redirect_to );
		exit;
	}

	/**
	 * Search products.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function search_products() {
		check_ajax_referer( 'product_tabs_manager_nonce', 'nonce' );

		$term = isset( $_POST['term'] ) ? sanitize_text_field( wp_unslash( $_POST['term'] ) ) : '';

		if ( empty( $term ) ) {
			wp_send_json_success( esc_html__( 'No, search term provided.', 'product-tabs-manager' ) );
			wp_die();
		}

		$data_store = \WC_Data_Store::load( 'product' );
		$ids        = $data_store->search_products( $term, '', true, true );
		$results    = array();

		if ( $ids ) {
			foreach ( $ids as $id ) {
				$product = wc_get_product( $id );
				if ( ! $product ) {
					continue;
				}
				$text = sprintf(
					'(#%1$s) %2$s',
					$product->get_id(),
					wp_strip_all_tags( $product->get_name() )
				);

				$results[] = array(
					'id'   => $product->get_id(),
					'text' => $text,
				);
			}
		}

		wp_send_json(
			array(
				'results'    => $results,
				'pagination' => array(
					'more' => false,
				),
			)
		);

		wp_die();
	}

	/**
	 * Search categories.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function search_categories() {
		check_admin_referer( 'product_tabs_manager_nonce', 'nonce' );
		$term = isset( $_POST['term'] ) ? sanitize_text_field( wp_unslash( $_POST['term'] ) ) : '';

		if ( empty( $term ) ) {
			wp_send_json_success( esc_html__( 'No, search term provided.', 'product-tabs-manager' ) );
			wp_die();
		}

		$categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'name__like' => $term,
			)
		);

		$results = array();

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$text = sprintf(
					'(#%1$s) %2$s',
					$category->term_id,
					wp_strip_all_tags( $category->name )
				);

				$results[] = array(
					'id'   => $category->term_id,
					'text' => $text,
				);
			}
		}

		wp_send_json(
			array(
				'results'    => $results,
				'pagination' => array(
					'more' => false,
				),
			)
		);

		wp_die();
	}

	/**
	 * Search user role.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	public static function search_user_role() {
		check_admin_referer( 'product_tabs_manager_nonce', 'nonce' );
		$term = isset( $_POST['user_role'] ) ? sanitize_text_field( wp_unslash( $_POST['user_role'] ) ) : '';

		if ( empty( $term ) ) {
			wp_send_json_success( esc_html__( 'No, user name provided.', 'product-tabs-manager' ) );
			wp_die();
		}

		global $wp_roles;
		$roles = $wp_roles->get_names();

		$results = array();

		if ( ! empty( $roles ) ) {
			foreach ( $roles as $key => $role_name ) {
				if ( str_contains( strtolower( $role_name ), strtolower( $term ) ) ) {
					$text = sprintf(
						'%s',
						wp_strip_all_tags( $role_name )
					);

					$results[] = array(
						'id'   => $key,
						'text' => $text,
					);
				}
			}
		}

		wp_send_json(
			array(
				'results'    => $results,
				'pagination' => array(
					'more' => false,
				),
			)
		);

		wp_die();
	}
}
