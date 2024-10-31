<?php
/**
 * Admin notice for upgrade.
 *
 * @since 1.0.4
 * @return void
 *
 * @package WooCommerceProductTabsManager
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="notice-body">
	<div class="notice-icon">
		<img src="<?php echo esc_attr( product_tabs_manager()->get_assets_url( 'images/plugin-icon.png' ) ); ?>" alt="Product Tabs Manager">
	</div>
	<div class="notice-content">
		<h3><?php esc_attr_e( 'Flash Sale Alert!', 'product-tabs-manager' ); ?></h3>
		<p>
			<?php
			echo wp_kses_post(
				sprintf(
					// translators: %1$s: Product Tabs Manager Pro link, %2$s: Coupon code.
					__( 'Get access to %1$s with a <strong>20%% discount</strong> for the next <strong>72 hours</strong> only! Use coupon code %2$s at checkout. Hurry up, the offer ends soon.', 'product-tabs-manager' ),
					'<a href="https://pluginever.com/plugins/wc-tab-manager/?utm_source=plugin&utm_medium=notice&utm_campaign=flash-sale" target="_blank"><strong>WC Tab Manager</strong></a>',
					'<strong>FLASH20</strong>'
				)
			);
			?>
		</p>
	</div>
</div>
<div class="notice-footer">
	<a class="primary" href="https://pluginever.com/plugins/wc-tab-manager/?utm_source=plugin&utm_medium=notice&utm_campaign=flash-sale" target="_blank">
		<span class="dashicons dashicons-cart"></span>
		<?php esc_attr_e( 'Upgrade now', 'product-tabs-manager' ); ?>
	</a>
	<a href="#" data-snooze="<?php echo esc_attr( WEEK_IN_SECONDS ); ?>">
		<span class="dashicons dashicons-clock"></span>
		<?php esc_attr_e( 'Maybe later', 'product-tabs-manager' ); ?>
	</a>
</div>
