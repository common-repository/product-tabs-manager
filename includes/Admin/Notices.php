<?php

namespace WooCommerceProductTabsManager\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Notices class.
 *
 * @since 1.0.0
 */
class Notices {

	/**
	 * Notices constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin notices.
	 *
	 * @since 1.0.0
	 */
	public function admin_notices() {
		$installed_time = get_option( 'wcptm_installed' );
		$current_time   = wp_date( 'U' );
		$halloween_time = date_i18n( strtotime( '2024-11-11 00:00:00' ) );

		// Halloween offer notice.
		if ( $current_time < $halloween_time ) {
			wp_enqueue_style( 'product-tabs-manager-halloween' );
			product_tabs_manager()->notices->add(
				array(
					'message'     => __DIR__ . '/views/notices/halloween.php',
					'dismissible' => false,
					'notice_id'   => 'wcptm_promotion',
					'style'       => 'border-left-color: #0542fa;',
					'class'       => 'notice-halloween',
				)
			);
		}

		if ( ! defined( 'WCTABMANAGER_VERSION' ) ) {
			product_tabs_manager()->notices->add(
				array(
					'message'     => __DIR__ . '/views/notices/upgrade.php',
					'notice_id'   => 'wcptm_upgrade',
					'style'       => 'border-left-color: #0542fa;',
					'dismissible' => false,
				)
			);
		}

		// Show after 5 days.
		if ( $installed_time && $current_time > ( $installed_time + ( 5 * DAY_IN_SECONDS ) ) ) {
			product_tabs_manager()->notices->add(
				array(
					'message'     => __DIR__ . '/views/notices/review.php',
					'dismissible' => false,
					'notice_id'   => 'wcptm_review',
					'style'       => 'border-left-color: #0542fa;',
				)
			);
		}
	}
}
