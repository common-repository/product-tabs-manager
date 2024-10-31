<?php

namespace WooCommerceProductTabsManager\Frontend;

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
		add_filter( 'woocommerce_product_tabs', array( __CLASS__, 'add_all_custom_default_product_tabs' ), 98 );
	}

	/**
	 * Add custom and default tabs to product single page.
	 *
	 * @param array $tabs Exiting tabs.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function add_all_custom_default_product_tabs( $tabs ) {
		global $post, $product;
		wp_enqueue_style( 'wcptm-frontend' );
		wp_enqueue_script( 'wcptm-frontend' );
		$active_status = get_post_meta( $post->ID, 'wcptm_tab_is_disable', true );
		if ( 'yes' === $active_status ) {
			return array();
		}

		$all_tabs = Helpers::get_product_tabs( $post->ID );
		set_transient( 'wcptm_tabs', $all_tabs, 60 * 5 );

		$priority = 100;
		foreach ( $all_tabs as $key => $tab ) {
			if ( 'yes' !== $tab['disable'] ) {
				if ( 'yes' === $tab['is_overwrite'] ) {
					$title = $tab['custom_title'];
				} elseif ( '' !== $tab['post_id'] ) {
					$title = get_the_title( $tab['post_id'] );
					$icon  = get_post_meta( $tab['post_id'], 'wcptm_tab_icon', true );
				} else {
					$title = $tab['title'];
				}
				switch ( $tab['id'] ) {
					case 'reviews':
						$tabs['reviews']['title']    = str_replace( '%d', apply_filters( 'wc_tab_manager_reviews_tab_title_review_count', $product->get_review_count(), $product ), $title );
						$tabs['reviews']['priority'] = $priority;
						break;
					case 'description':
						add_filter( 'woocommerce_product_description_heading', array( __CLASS__, 'tab_heading_change' ) );
						$tabs['description']['priority'] = $priority;
						$tabs['description']['title']    = $title;
						break;
					case 'additional_information':
						add_filter( 'woocommerce_product_additional_information_heading', array( __CLASS__, 'tab_heading_change' ) );
						$tabs['additional_information']['priority'] = $priority;
						$tabs['additional_information']['title']    = $title;
						break;
					default:
						$tabs[ $tab['id'] ] = array(
							'title'    => $title,
							'priority' => $priority,
							'callback' => array( self::class, 'add_tab_details' ),
						);
						break;
				}
			} else {
				unset( $tab['id'] );
				if ( array_key_exists( $key, $tabs ) ) {
					unset( $tabs[ $key ] );
				}
			}
			$priority = $priority + 10;
		}
		return $tabs;
	}

	/**
	 * Callback function to show tab details.
	 *
	 * @param int $tabid Tab id.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function add_tab_details( $tabid ) {
		$all_tabs = get_transient( 'wcptm_tabs' );
		if ( 'yes' === $all_tabs[ $tabid ]['is_overwrite'] ) {
			echo do_shortcode( $all_tabs[ $tabid ]['custom_content'] );
		} else {
			echo do_shortcode( $all_tabs[ $tabid ]['content'] );
		}
	}

	/**
	 * Callback function to show tab details.
	 *
	 * @param string $heading Tab heading.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function tab_heading_change( $heading ) {
		$all_tabs       = get_transient( 'wcptm_tabs' );
		$current_filter = current_filter();
		switch ( $current_filter ) {
			case 'woocommerce_product_description_heading':
				if ( 'yes' === $all_tabs['description']['is_overwrite'] ) {
					return $all_tabs['description']['custom_heading'];
				} else {
					return $heading;
				}
			case 'woocommerce_product_additional_information_heading':
				if ( 'yes' === $all_tabs['additional_information']['is_overwrite'] ) {
					return $all_tabs['additional_information']['custom_heading'];
				} else {
					return $heading;
				}
		}

		return $heading;
	}
}
