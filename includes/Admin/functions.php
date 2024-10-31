<?php

defined( 'ABSPATH' ) || exit;

/**
 * Get list table class.
 *
 * @param string $type Type of list table to get.
 *
 * @since 1.0.0
 * @return object
 */
function wcptm_get_list_table( $type ) {
	switch ( $type ) {
		case 'product-tabs-manager':
		default:
			$list_table = new \WooCommerceProductTabsManager\Admin\listTables\ProductTabsListTable();
			break;
	}

	return $list_table;
}
