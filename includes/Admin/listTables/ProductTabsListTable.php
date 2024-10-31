<?php

namespace WooCommerceProductTabsManager\Admin\listTables;

use WooCommerceProductTabsManager\Admin\listTables\AbstractListTable;
use WooCommerceProductTabsManager\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * ProductTabsListTable ListTable class.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */
class ProductTabsListTable extends AbstractListTable {
	/**
	 * Get things started
	 *
	 * @param array $args Optional.
	 *
	 * @see WP_List_Table::__construct()
	 * @since  1.0.0
	 */
	public function __construct( $args = array() ) {
		$args         = wp_parse_args(
			$args,
			array(
				'singular' => 'tab',
				'plural'   => 'tabs',
				'ajax'     => true,
			)
		);
		$this->screen = get_current_screen();
		parent::__construct( $args );
	}

	/**
	 * Retrieve all the data for the table.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$sortable              = $this->get_sortable_columns();
		$hidden                = $this->get_hidden_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$per_page              = 20;
		$order_by              = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$order                 = isset( $_GET['order'] ) ? sanitize_key( wp_unslash( $_GET['order'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$search                = isset( $_GET['s'] ) ? sanitize_key( wp_unslash( $_GET['s'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$current_page          = isset( $_GET['paged'] ) ? sanitize_key( wp_unslash( $_GET['paged'] ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! empty( $search ) ) {
			$args = array(
				'post_type'      => 'wcptm-tabs',
				'post_status'    => 'any',
				'order'          => $order,
				'order_by'       => $order_by,
				's'              => $search,
				'posts_per_page' => $per_page,
				'paged'          => $current_page,
			);
		} else {
			$args = array(
				'post_type'      => 'wcptm-tabs',
				'post_status'    => 'any',
				'order'          => $order,
				'order_by'       => $order_by,
				'posts_per_page' => $per_page,
				'paged'          => $current_page,
			);
		}
		$query = new \WP_Query( $args );

		$this->items = $query->posts;
		$total_count = $query->found_posts;
		$total_pages = $query->max_num_pages;

		$this->set_pagination_args(
			array(
				'total_items' => $total_count,
				'per_page'    => $per_page,
				'total_pages' => $total_pages,
			)
		);
	}

	/**
	 * No items found text.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function no_items() {
		esc_html_e( 'No items found.', 'product-tabs-manager' );
	}

	/**
	 * Get the table columns
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'              => '<input type="checkbox" />',
			'name'            => __( 'Title', 'product-tabs-manager' ),
			'visibility_type' => __( 'Visibility Type', 'product-tabs-manager' ),
			'visibility_list' => __( 'Visibility List', 'product-tabs-manager' ),
			'excluded_users'  => __( 'Excluded Users', 'product-tabs-manager' ),
			'tabs_status'     => __( 'Tabs Status', 'product-tabs-manager' ),
			'date_created'    => __( 'Date Created', 'product-tabs-manager' ),
		);
	}

	/**
	 * Get the table sortable columns
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'name'            => array( 'post_title', true ),
			'date_created'    => array( 'date_created', true ),
			'visibility_type' => array( 'visibility_type', true ),
		);
	}

	/**
	 * Get the table hidden columns
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Get bulk actions
	 *
	 * since 1.0.0
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		return array(
			'delete' => __( 'Delete', 'product-tabs-manager' ),
		);
	}

	/**
	 * Process bulk action.
	 *
	 * @param string $doaction Action name.
	 *
	 * @since 1.0.0
	 */
	public function process_bulk_action( $doaction ) {
		if ( ! empty( $doaction ) && check_admin_referer( 'bulk-' . $this->_args['plural'] ) ) {
			$id  = filter_input( INPUT_GET, 'id' );
			$ids = filter_input( INPUT_GET, 'ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
			if ( ! empty( $id ) ) {
				$ids      = wp_parse_id_list( $id );
				$action   = isset( $_REQUEST['action'] ) ? map_deep( wp_unslash( $_REQUEST['action'] ), 'sanitize_text_field' ) : - 1;
				$action2  = isset( $_REQUEST['action2'] ) ? map_deep( wp_unslash( $_REQUEST['action2'] ), 'sanitize_text_field' ) : - 1;
				$doaction = ( - 1 !== $action ) ? $action : $action2;
			} elseif ( ! empty( $ids ) ) {
				$ids = array_map( 'absint', $ids );
			} elseif ( wp_get_referer() ) {
				wp_safe_redirect( wp_get_referer() );
				exit;
			}
			$deleted_count = 0;
			switch ( $doaction ) {
				case 'delete':
					$deleted_count = 0;
					foreach ( $ids as $id ) {
						wp_delete_post( $id, true );
						++$deleted_count;
					}
					break;
			}
			// translators: %d: number of things deleted.
			product_tabs_manager()->flash->success( sprintf( _n( '%d item deleted.', '%d items deleted.', $deleted_count, 'product-tabs-manager' ), $deleted_count ) );
			wp_safe_redirect( admin_url( 'admin.php?page=product-tabs-manager' ) );
			exit();
		}

		parent::process_bulk_actions( $doaction );
	}

	/**
	 * Define primary column.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_primary_column_name() {
		return 'name';
	}

	/**
	 * Renders the checkbox column in the items list table.
	 *
	 * @param object $item The current ticket object.
	 *
	 * @since  1.0.0
	 * @return string Displays a checkbox.
	 */
	public function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="ids[]" value="%d"/>', esc_attr( $item->ID ) );
	}

	/**
	 * Renders the name column in the items list table.
	 *
	 * @param object $item The current post tab object.
	 *
	 * @since  1.0.0
	 * @return string Displays the tab name.
	 */
	public function column_name( $item ) {
		$admin_url = admin_url( 'admin.php?page=product-tabs-manager&' );
		$id_url    = add_query_arg( 'id', $item->ID, $admin_url );
		$actions   = array(
			'edit'   => sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( 'edit', $item->ID, $admin_url ) ), __( 'Edit', 'product-tabs-manager' ) ),
			'delete' => sprintf( '<a href="%s">%s</a>', wp_nonce_url( add_query_arg( 'action', 'delete', $id_url ), 'bulk-tabs' ), __( 'Delete', 'product-tabs-manager' ) ),
		);

		return sprintf( '<a href="%s">%s</a> %s', esc_url( add_query_arg( 'edit', $item->ID, $admin_url ) ), esc_html( $item->post_title ), $this->row_actions( $actions ) );
	}


	/**
	 * This function renders most of the columns in the list table.
	 *
	 * @param object $item The current tab object.
	 * @param string $column_name The name of the column.
	 *
	 * @since 1.0.0
	 */
	public function column_default( $item, $column_name ) {
		$value = '&mdash;';
		switch ( $column_name ) {
			case 'visibility_type':
				$id    = $item->ID;
				$html  = get_post_meta( $id, 'wcptm_tab_visible_type', true );
				$value = ucwords( str_replace( '-', ' ', $html ) );
				break;
			case 'tabs_status':
				$id        = $item->ID;
				$is_active = ( 'yes' !== get_post_meta( $id, 'wcptm_tab_is_disable', true ) ) ? __( 'Active', 'product-tabs-manager' ) : __( 'Inactive', 'product-tabs-manager' );
				$html      = '<span class="' . esc_attr( $is_active ) . '">' . esc_attr( $is_active ) . '</span>';
				$value     = $html;
				break;
			case 'date_created':
				$date = $item->post_date;
				if ( $date ) {
					$value = sprintf( '<time datetime="%s">%s</time>', esc_attr( $date ), esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) ) );
				}
				break;
			case 'visibility_list':
				$id           = $item->ID;
				$visible_type = get_post_meta( $id, 'wcptm_tab_visible_type', true );
				if ( 'specific-products' === $visible_type ) {
					$visible_list = get_post_meta( $id, 'wcptm_tab_specific_products', true );
					$value        = '';
					if ( ! empty( $visible_list ) ) {
						foreach ( $visible_list as $product_id ) {
							$value .= Helpers::get_product_title( $product_id, true ) . ', ';
						}
					}
					$value = trim( $value, ', ' );
				} elseif ( 'specific-categories' === $visible_type ) {
					$visible_list = get_post_meta( $id, 'wcptm_tab_specific_categories', true );
					$value        = '';
					if ( ! empty( $visible_list ) ) {
						foreach ( $visible_list as $product_id ) {
							$value .= Helpers::get_category_title( $product_id, true ) . ', ';
						}
					}
					$value = trim( $value, ', ' );
				} else {
					$value = __( 'Show in all products.', 'product-tabs-manager' );
				}
				break;
			case 'excluded_users':
				$id             = $item->ID;
				$excluded_users = get_post_meta( $id, 'wcptm_excluded_users', true );
				if ( $excluded_users ) {
					if ( ! empty( $excluded_users ) ) {
						foreach ( $excluded_users as $excluded_user ) {
							$value .= Helpers::get_product_title( $excluded_user, true ) . ', ';
						}
					}
					$value = trim( $value, ', ' );
				} else {
					$value = __( 'No users excluded.', 'product-tabs-manager' );
				}
				break;
			default:
				$value = parent::column_default( $item, $column_name );
		}

		return $value;
	}
}
