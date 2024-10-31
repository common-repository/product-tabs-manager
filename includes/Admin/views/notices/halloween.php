<?php
/**
 * Admin Halloween notice.
 *
 * @since 1.0.6
 * @return void
 *
 * @package WooCommerceProductTabsManager
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="notice-body">
	<div class="notice-icon">
		<img src="<?php echo esc_url( product_tabs_manager()->get_assets_url( 'images/halloween-icon.svg' ) ); ?>" alt="halloween">
	</div>
	<div class="notice-content">
		<h3>
			<?php esc_html_e( 'Limited Time Offer! PluginEver Halloween Sale: 30% OFF!!', 'product-tabs-manager' ); ?>
		</h3>
		<p>
			<?php
			echo wp_kses_post(
				sprintf(
					// translators: 1.Offer Percentage, 2. Coupon Code.
					__( 'Spectacular Halloween Deal! Get %1$s on all premium plugins with code %2$s. Don\'t miss out — this offer vanishes soon! 👻', 'product-tabs-manager' ),
					'<strong>' . esc_attr( '30% OFF' ) . '</strong>',
					'<strong>' . esc_attr( 'BIGTREAT30' ) . '</strong>'
				)
			);
			?>
		</p>
	</div>
</div>
<div class="notice-footer">
	<div class="footer-btn">
		<a href="<?php echo esc_url( product_tabs_manager()->plugin_uri ); ?>" class="primary halloween-upgrade-btn">
			<span class="dashicons dashicons-cart"></span>
			<?php esc_html_e( 'Claim your discount!!', 'product-tabs-manager' ); ?>
		</a>
		<a href="#" class="halloween-remind-btn" data-snooze="<?php echo esc_attr( WEEK_IN_SECONDS ); ?>">
			<span class="dashicons dashicons-clock"></span>
			<?php esc_html_e( 'Remind me later', 'product-tabs-manager' ); ?>
		</a>
		<a href="#" class="primary halloween-remove-btn" data-dismiss>
			<span class="dashicons dashicons-remove"></span>
			<?php esc_html_e( 'Never show this again!', 'product-tabs-manager' ); ?>
		</a>
		<a href="#" class="primary halloween-dismiss-btn" data-dismiss>
			<span class="dashicons dashicons-dismiss"></span>
			<?php esc_html_e( 'DISMISS', 'product-tabs-manager' ); ?>
		</a>
	</div>
	<strong class="halloween-footer-text"><?php esc_html_e( 'Valid until November 10, 2024', 'product-tabs-manager' ); ?></strong>
</div>
