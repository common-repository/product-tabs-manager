<?php

namespace WooCommerceProductTabsManager\Admin;

use WooCommerceProductTabsManager\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Products class.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */
class Products {
	/**
	 * Products constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'woocommerce_product_data_tabs', array( __CLASS__, 'product_data_tab' ) );
		add_action( 'woocommerce_product_data_panels', array( __CLASS__, 'add_product_tabs' ) );
		add_filter( 'woocommerce_process_product_meta', array( __CLASS__, 'product_save_tab_data' ) );
	}

	/**
	 * Products tab add for tab.
	 *
	 * @param array $tabs tabs array.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public static function product_data_tab( $tabs ) {
		$tabs['wcptm_product_tabs_manager'] = array(
			'label'    => __( 'Product Tabs Manager', 'product-tabs-manager' ),
			'target'   => 'wcptm_product_tab_data',
			'priority' => 1000,
		);

		return $tabs;
	}

	/**
	 * Show tabs for individual products.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function add_product_tabs() {
		global $post;
		$tabs          = array();
		$is_tab_active = get_post_meta( $post->ID, 'wcptm_tab_is_disable', true );
		$tabs          = Helpers::get_product_tabs( $post->ID );
		include __DIR__ . '/views/products/product-tab-meta.php';
	}

	/**
	 * Save tabs data for the product.
	 *
	 * @param int $postid product id.
	 * @since 1.0.0
	 * @return void
	 */
	public static function product_save_tab_data( $postid ) {
		$active_tab = isset( $_POST['wcptm_tab_is_disable'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_tab_is_disable'] ) ) : 'no';
		if ( 'yes' === $active_tab ) {
			update_post_meta( $postid, 'wcptm_tab_is_disable', $active_tab );
		} else {
			update_post_meta( $postid, 'wcptm_tab_is_disable', $active_tab );
		}
		if ( 'yes' !== $active_tab ) {
			$tabs_count = isset( $_POST['wcptm_product_tab_count'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_tab_count'] ) ) : '';

			$product_tab = array();
			for ( $i = 0; $i < $tabs_count; $i++ ) {
				$tab_id           = isset( $_POST['wcptm_product_save_tabs'][ $i ]['id'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['id'] ) ) : '';
				$tab_post_id      = isset( $_POST['wcptm_product_save_tabs'][ $i ]['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['post_id'] ) ) : '';
				$tab_disable      = isset( $_POST['wcptm_product_save_tabs'][ $i ]['disable'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['disable'] ) ) : 'no';
				$tab_is_overwrite = isset( $_POST['wcptm_product_save_tabs'][ $i ]['is_overwrite'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['is_overwrite'] ) ) : 'no';
				$tab_title        = isset( $_POST['wcptm_product_save_tabs'][ $i ]['title'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['title'] ) ) : '';
				$tab_heading      = isset( $_POST['wcptm_product_save_tabs'][ $i ]['heading'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['heading'] ) ) : '';
				$tab_content      = isset( $_POST[ 'wcptm_product_save_tabs_content_' . $i ] ) ? wp_kses_post( wp_unslash( $_POST[ 'wcptm_product_save_tabs_content_' . $i ] ) ) : '';
				$tab_type         = isset( $_POST['wcptm_product_save_tabs'][ $i ]['type'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['type'] ) ) : 'custom';
				$tab_position     = isset( $_POST['wcptm_product_save_tabs'][ $i ]['position'] ) ? sanitize_text_field( wp_unslash( $_POST['wcptm_product_save_tabs'][ $i ]['position'] ) ) : '';
				switch ( $tab_type ) {
					case 'custom':
						$product_tab[ $tab_id ] = array(
							'id'             => $tab_id,
							'post_id'        => $tab_post_id,
							'position'       => $tab_position,
							'type'           => 'custom',
							'title'          => get_the_title( $tab_post_id ),
							'custom_title'   => $tab_title,
							'content'        => get_post_meta( $tab_post_id, 'wcptm_tab_content', true ),
							'custom_content' => $tab_content,
							'heading'        => '',
							'custom_heading' => '',
							'disable'        => $tab_disable,
							'is_overwrite'   => $tab_is_overwrite,
						);
						break;
					default:
						$default_tabs           = ! empty( get_option( 'wcptm_customize_default_tabs' ) ) ? get_option( 'wcptm_customize_default_tabs' ) : Helpers::get_default_tabs();
						$product_tab[ $tab_id ] = array(
							'id'             => $tab_id,
							'post_id'        => $tab_post_id,
							'position'       => $tab_position,
							'type'           => 'default',
							'title'          => $default_tabs[ $tab_id ]['title'],
							'custom_title'   => $tab_title,
							'content'        => '',
							'custom_content' => '',
							'heading'        => $default_tabs[ $tab_id ]['heading'],
							'custom_heading' => $tab_heading,
							'disable'        => $tab_disable,
							'is_overwrite'   => $tab_is_overwrite,
						);
						break;
				}
			}

			uasort( $product_tab, array( Helpers::class, 'tab_sort_according_to_position' ) );
			update_post_meta( $postid, 'wcptm_product_save_tabs', $product_tab );
		}
	}
}
