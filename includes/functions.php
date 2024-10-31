<?php

use WooCommerceProductTabsManager\Plugin;

defined( 'ABSPATH' ) || exit;

/**
 * Get the plugin instance.
 *
 * @since 1.0.1
 * @return WooCommerceProductTabsManager\Plugin
 */
function product_tabs_manager() {
	return Plugin::instance();
}
