<?php
/**
 * Admin View: List Products Tabs
 *
 * @package WooCommerceProductTabsManager
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$list_table = wcptm_get_list_table( 'product-tabs-manager' );
$action     = $list_table->current_action();
$list_table->process_bulk_action( $action );
$list_table->prepare_items();
?>

<div class="wrap bk-wrap">
	<div class="bk-admin-page__header">
		<div>
			<h1 class="wp-heading-inline">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-tabs-manager&new=1' ) ); ?>" class="page-title-action">
					<?php esc_html_e( 'Add New Tab', 'product-tabs-manager' ); ?>
				</a>
			</h1>
		</div>
	</div>
	<form id="things-list-table" method="get">
		<?php
		$status = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$list_table->views();
		$list_table->search_box( __( 'Search', 'product-tabs-manager' ), 'key' );
		$list_table->display();
		?>
		<input type="hidden" name="status" value="<?php echo esc_attr( $status ); ?>">
		<input type="hidden" name="page" value="product-tabs-manager">
	</form>
</div>

