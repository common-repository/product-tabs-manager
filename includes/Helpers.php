<?php

namespace WooCommerceProductTabsManager;

defined( 'ABSPATH' ) || exit;

/**
 * Helpers class.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */
class Helpers {

	/**
	 * Get slider settings.
	 *
	 * @param int $id ID of the slider post.
	 *
	 * @return array Returns the slider settings.
	 */
	public static function get_tab_settings( $id = null ) {
		$defaults = array(
			'tab_content_type'        => 'content',
			'tab_content'             => '',
			'tab_faq'                 => array(),
			'tab_icon'                => '',
			'tab_is_disable'          => 'no',
			'tab_visible_type'        => 'all-products',
			'tab_specific_products'   => array(),
			'tab_specific_categories' => array(),
		);

		/**
		 * Filter the default tab settings.
		 *
		 * @since 1.0.0
		 *
		 * @param array $defaults The default settings.
		 */
		$defaults = apply_filters( 'wcptm_default_tab_settings', $defaults );

		if ( ! empty( $id ) ) {
			$metadata                    = get_post_meta( $id );
			$settings                    = array();
			$settings['wcptm_tab_id']    = $id;
			$settings['wcptm_tab_title'] = get_the_title( $id );
			foreach ( $metadata as $key => $value ) {
				$value = maybe_unserialize( is_array( $value ) ? $value[0] : $value );
				if ( ! empty( $value ) ) {
					$settings[ $key ] = $value;
				} else {
					$settings[ $key ] = $defaults[ str_replace( 'wcptm_', '', $key ) ];
				}
			}
		} else {
			$settings                    = array();
			$settings['wcptm_tab_id']    = '';
			$settings['wcptm_tab_title'] = '';
			foreach ( $defaults as $key => $value ) {
				$settings[ 'wcptm_' . $key ] = $defaults[ $key ];
			}
		}

		// Adjust other properties based on the dependent fields.
		if ( empty( $settings['wcptm_tab_content_type'] ) ) {
			$settings['wcptm_tab_content_type'] = $defaults['tab_content_type'];
		}
		if ( empty( $settings['wcptm_tab_icon'] ) ) {
			$settings['wcptm_tab_icon'] = $defaults['tab_icon'];
		}

		/**
		 * Filter the tab settings.
		 *
		 * @since 1.0.0
		 *
		 * @param array $settings The tab settings.
		 * @param array $defaults The default settings.
		 */
		$settings = apply_filters( 'wcptm_get_tab_settings', $settings, $defaults );
		return $settings;
	}

	/**
	 * Get category title.
	 *
	 * @param \WP_Term| int $category Category title.
	 * @param boolean       $tab_list Is function call from tab list table.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_category_title( $category, $tab_list = false ) {
		$category = get_term( $category );
		if ( $category && ! is_wp_error( $category ) ) {
			if ( $tab_list ) {
				return sprintf(
					'<a href="%1$s">%2$s</a>',
					admin_url( 'edit.php?orderby=title&order=asc&s&post_status=all&post_type=product&action=-1&product_cat=' . $category->slug . '&product_type&stock_status&filter_action=Filter&paged=1&action2=-1' ),
					html_entity_decode( $category->name )
				);
			} else {
				return sprintf(
					'(#%1$s) %2$s',
					$category->term_id,
					html_entity_decode( $category->name )
				);
			}
		}
		return null;
	}

	/**
	 * Get product title.
	 *
	 * @param \WC_Product| int $product Products title.
	 * @param boolean          $tab_list Is function call from tab list table.
	 *
	 * @since 1.0.0
	 *
	 * @return string|null
	 */
	public static function get_product_title( $product, $tab_list = false ) {
		$product = wc_get_product( $product );
		if ( $product && ! empty( $product->get_id() ) ) {
			if ( true === $tab_list ) {
				return sprintf(
					'<a href="%1$s">%2$s</a>',
					admin_url( 'post.php?post=' . $product->get_id() . '&action=edit' ),
					html_entity_decode( $product->get_name() )
				);
			} else {
				return sprintf(
					'(#%1$s) %2$s',
					$product->get_id(),
					html_entity_decode( $product->get_formatted_name() )
				);
			}
		}
		return null;
	}

	/**
	 * Get the default WooCommerce tabs data structure.
	 *
	 * @since 1.0.0
	 *
	 * @return array The core tabs
	 */
	public static function get_default_tabs() {
		$default_tabs = array(
			'description'            => array(
				'id'             => 'description',
				'post_id'        => '',
				'tab_type'       => 'core',
				'tab_icon'       => '',
				'position'       => '',
				'type'           => 'default',
				'title'          => __( 'Description', 'product-tabs-manager' ),
				'custom_title'   => '',
				'content'        => '',
				'custom_content' => '',
				'heading'        => __( 'Description', 'product-tabs-manager' ),
				'custom_heading' => '',
				'disable'        => 'no',
				'is_overwrite'   => 'no',
			),
			'additional_information' => array(
				'id'             => 'additional_information',
				'post_id'        => '',
				'tab_type'       => 'core',
				'tab_icon'       => '',
				'position'       => '',
				'type'           => 'default',
				'title'          => __( 'Additional Information', 'product-tabs-manager' ),
				'custom_title'   => '',
				'content'        => '',
				'custom_content' => '',
				'heading'        => __( 'Additional Information', 'product-tabs-manager' ),
				'custom_heading' => '',
				'disable'        => 'no',
				'is_overwrite'   => 'no',
			),
			'reviews'                => array(
				'id'             => 'reviews',
				'post_id'        => '',
				'tab_type'       => 'core',
				'tab_icon'       => '',
				'position'       => '',
				'type'           => 'default',
				'title'          => sprintf( '%s (%%d)', __( 'Reviews', 'product-tabs-manager' ) ),
				'custom_title'   => '',
				'content'        => '',
				'custom_content' => '',
				'heading'        => __( 'Reviews', 'product-tabs-manager' ),
				'custom_heading' => '',
				'disable'        => 'no',
				'is_overwrite'   => 'no',
			),
		);

		return $default_tabs;
	}

	/**
	 * Get the default WooCommerce tabs data structure.
	 *
	 * @param int $post_id Product ID.
	 * @since 1.0.0
	 *
	 * @return array The core tabs
	 */
	public static function get_product_tabs( $post_id = null ) {
		$product_save_tabs = get_post_meta( $post_id, 'wcptm_product_save_tabs', true );

		if ( ! is_array( $product_save_tabs ) || empty( $product_save_tabs ) ) {
			$product_save_tabs = array();
		}

		$get_product_tabs = array();
		$default_tabs     = ! empty( get_option( 'wcptm_customize_default_tabs' ) ) ? get_option( 'wcptm_customize_default_tabs' ) : self::get_default_tabs();
		$custom_tabs      = self::get_product_custom_tabs( $post_id );
		$get_product_tabs = array_merge( $default_tabs, $custom_tabs, $get_product_tabs );

		foreach ( $get_product_tabs as $key => $tab ) {
			if ( array_key_exists( $key, $product_save_tabs ) && 'yes' === $product_save_tabs[ $key ]['is_overwrite'] ) {
				if ( $tab['id'] === $product_save_tabs[ $key ]['id'] ) {
					$get_product_tabs[ $key ] = $product_save_tabs[ $key ];
				}
			}
		}

		uasort( $get_product_tabs, array( self::class, 'tab_sort_according_to_position' ) );
		return $get_product_tabs;
	}

	/**
	 * Get the default WooCommerce tabs data structure.
	 *
	 * @param int $post_id Product ID.
	 * @since 1.0.0
	 *
	 * @return array The core tabs
	 */
	public static function get_product_custom_tabs( $post_id ) {
		$product_cats_ids = wc_get_product_term_ids( $post_id, 'product_cat' );
		$custom_tabs      = array();
		$args             = array(
			'post_type' => 'wcptm-tabs',
			'order'     => 'ASC',
		);
		$meta_query       = new \WP_Query( $args );
		$posts            = $meta_query->posts;

		foreach ( $posts as $post ) {
			$tab_details = self::get_tab_settings( $post->ID );
			if ( ( 'faq' === $tab_details['wcptm_tab_content_type'] || 'product_list' === $tab_details['wcptm_tab_content_type'] ) && ! is_plugin_active( 'wc-tab-manager/wc-tab-manager.php' ) ) {
				continue;
			}

			if ( empty( $tab_details['wcptm_tab_specific_products'] ) || ! is_array( $tab_details['wcptm_tab_specific_products'] ) ) {
				$tab_details['wcptm_tab_specific_products'] = array();
			}

			if ( 'faq' === $tab_details['wcptm_tab_content_type'] ) {
				$tab_details['wcptm_tab_content'] = $tab_details['wcptm_tab_faq'];
			} elseif ( 'product_list' === $tab_details['wcptm_tab_content_type'] ) {
				$tab_details['wcptm_tab_content'] = $tab_details['wcptm_tab_product_list'];
			}

			if ( in_array( (string) $post_id, $tab_details['wcptm_tab_specific_products'], true ) && 'specific-products' === $tab_details['wcptm_tab_visible_type'] && 'yes' !== $tab_details['wcptm_tab_is_disable'] ) {
				$custom_tabs[ $post->post_name ] = array(
					'id'             => $post->post_name,
					'post_id'        => $post->ID,
					'tab_type'       => $tab_details['wcptm_tab_content_type'],
					'tab_icon'       => $tab_details['wcptm_tab_icon'],
					'position'       => '',
					'type'           => 'custom',
					'title'          => $post->post_title,
					'custom_title'   => '',
					'content'        => ! empty( $tab_details['wcptm_tab_content'] ) ? $tab_details['wcptm_tab_content'] : '',
					'custom_content' => '',
					'heading'        => $post->post_title,
					'custom_heading' => '',
					'disable'        => 'no',
					'is_overwrite'   => 'no',
				);
			}

			if ( empty( $tab_details['wcptm_tab_specific_categories'] ) || ! is_array( $tab_details['wcptm_tab_specific_categories'] ) ) {
				$tab_details['wcptm_tab_specific_categories'] = array();
			}
			$result = array_intersect( $tab_details['wcptm_tab_specific_categories'], $product_cats_ids );
			if ( ! empty( $result) && 'specific-categories' === $tab_details['wcptm_tab_visible_type'] && 'yes' !== $tab_details['wcptm_tab_is_disable'] ) { //phpcs:ignore
				$custom_tabs[ $post->post_name ] = array(
					'id'             => $post->post_name,
					'post_id'        => $post->ID,
					'tab_type'       => $tab_details['wcptm_tab_content_type'],
					'tab_icon'       => $tab_details['wcptm_tab_icon'],
					'position'       => '',
					'type'           => 'custom',
					'title'          => $post->post_title,
					'custom_title'   => '',
					'content'        => ! empty( $tab_details['wcptm_tab_content'] ) ? $tab_details['wcptm_tab_content'] : '',
					'custom_content' => '',
					'heading'        => $post->post_title,
					'custom_heading' => '',
					'disable'        => 'no',
					'is_overwrite'   => 'no',
				);
			}
			if ( 'all-products' === $tab_details['wcptm_tab_visible_type'] && 'yes' !== $tab_details['wcptm_tab_is_disable'] ) {
				$custom_tabs[ $post->post_name ] = array(
					'id'             => $post->post_name,
					'post_id'        => $post->ID,
					'tab_type'       => $tab_details['wcptm_tab_content_type'],
					'tab_icon'       => $tab_details['wcptm_tab_icon'],
					'position'       => '',
					'type'           => 'custom',
					'title'          => $post->post_title,
					'custom_title'   => '',
					'content'        => ! empty( $tab_details['wcptm_tab_content'] ) ? $tab_details['wcptm_tab_content'] : '',
					'custom_content' => '',
					'heading'        => $post->post_title,
					'custom_heading' => '',
					'disable'        => 'no',
					'is_overwrite'   => 'no',
				);
			}
		}
		return $custom_tabs;
	}

	/**
	 * sorting tab array for default tabs.
	 *
	 * @param int $a Array values.
	 * @param int $b Array values.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public static function tab_sort_according_to_position( $a, $b ) {
		if ( $a['position'] === $b['position'] ) {
			return 0;
		}
		if ( '' === $a['position'] || '' === $b['position'] ) {
			return 0;
		}
		return $a['position'] < $b['position'] ? -1 : 1;
	}

	/**
	 * Sanitize post content.
	 *
	 * @param string $post_content Post content.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function sanitize_text_content( $post_content ) {
		$post_content = do_blocks( $post_content );
		$post_content = wptexturize( $post_content );
		$post_content = wpautop( $post_content );
		$post_content = shortcode_unautop( $post_content );
		$post_content = prepend_attachment( $post_content );
		$post_content = convert_smilies( $post_content );

		return $post_content;
	}
}
