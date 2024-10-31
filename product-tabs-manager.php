<?php
/**
 * Plugin Name:          Product Tabs Manager
 * Plugin URI:           https://pluginever.com/plugins/wc-tab-manager/
 * Description:          Tailor your WooCommerce product tabs effortlessly with our customizable plugin.
 * Version:              1.0.6
 * Author:               PluginEver
 * Author URI:           https://pluginever.com
 * License:              GPL v2 or later
 * License URI:          https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:          product-tabs-manager
 * Domain Path:          /languages
 * Requires Plugins:     woocommerce
 * Requires at least:    5.2
 * Tested up to:         6.6
 * Requires PHP:         7.4
 * WC requires at least: 6.0.0
 * WC tested up to:      9.3
 *
 * @package     WooCommerceProductTabsManager
 * @author      pluginever
 * @link        https://pluginever.com/plugins/wc-tab-manager/
 */

use WooCommerceProductTabsManager\Plugin;

// don't call the file directly.
defined( 'ABSPATH' ) || exit();

// Require the autoloader.
require_once __DIR__ . '/vendor/autoload.php';

// Instantiate the plugin.
WooCommerceProductTabsManager\Plugin::create(
	array(
		'file'         => __FILE__,
		'settings_url' => admin_url( 'admin.php?page=product-tabs-manager' ),
		'docs_url'     => 'https://pluginever.com/docs/wc-tab-manager/',
		'support_url'  => 'https://pluginever.com/support/',
		'review_url'   => 'https://wordpress.org/support/plugin/product-tabs-manager/reviews/#new-post',
	)
);
