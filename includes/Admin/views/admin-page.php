<?php
/**
 * View: Admin Page
 *
 * @since 1.0.0
 * @subpackage Admin/Views
 * @package WooCommerceProductTabsManager
 * @var string $page_hook Page hook.
 */

defined( 'ABSPATH' ) || exit;

$current_tab  = filter_input( INPUT_GET, 'tab' );
$current_page = filter_input( INPUT_GET, 'page' );
$tabs         = isset( $tabs ) ? $tabs : array();
$tabs         = apply_filters( 'product_tabs_manager_' . $page_hook . '_tabs', $tabs );
$current_tab  = ! empty( $current_tab ) && array_key_exists( $current_tab, $tabs ) ? $current_tab : key( $tabs );
?>
	<div class="tw-h-24 tw-bg-[#0542FA] sm:tw-h-32 tw-px-[20px] tw-ml-[-20px]" id="wcptm-top-bar">
		<div class="tw-max-w-full tw-m-auto sm:tw-pl-2 xl:tw-pl-3 lg:tw-pl-3 md:tw-pl-3">
			<h1	 class="tw-pt-5 tw-m-0 tw-text-white sm:tw-text-lg sm:tw-pt-3"><?php echo esc_attr( 'WooCommerce Product Tabs Manager' ); ?></h1>
			<p class="tw-text-white"><?php esc_html_e( 'Tailor your WooCommerce product tabs effortlessly with our customizable plugin.', 'product-tabs-manager' ); ?></p>
		</div>
	</div>
	<div class="wrap bk-wrap woocommerce sm:tw-pl-2 xl:tw-pl-3 lg:tw-pl-3 md:tw-pl-3">
		<?php if ( ! empty( $tabs ) && count( $tabs ) > 1 ) : ?>
			<nav class="nav-tab-wrapper bk-navbar">
				<?php
				foreach ( $tabs as $name => $label ) {
					if ( 'documentation' === $name ) {
						if ( product_tabs_manager()->get_docs_url() ) {
							printf( '<a href="%s" class="nav-tab" target="_blank">%s</a>', esc_url( product_tabs_manager()->get_docs_url() ), esc_attr( $label ) );
						}
						continue;
					}
					printf(
						'<a href="%s" class="nav-tab %s">%s</a>',
						esc_url( admin_url( 'admin.php?page=' . $current_page . '&tab=' . $name ) ),
						esc_attr( $current_tab === $name ? 'nav-tab-active' : '' ),
						esc_html( $label )
					);
				}
				?>
				<?php
				/**
				 * Fires after the tabs on the settings page.
				 *
				 * @param string $current_tab Current tab..
				 * @param array $tabs Tabs.
				 *
				 * @since 1.0.0
				 */
				do_action( 'product_tabs_manager_' . $page_hook . '_nav_items', $current_tab, $tabs );
				?>
			</nav>
		<?php endif; ?>

		<?php
		if ( ! empty( $tabs ) && ! empty( $current_tab ) ) {
			/**
			 * Action: Serial Numbers Admin Page Tab
			 *
			 * @param string $current_tab Current tab.
			 *
			 * @since 1.0.0
			 */
			do_action( "product_tabs_manager_{$page_hook}_{$current_tab}_content", $current_tab );
		}

		/**
		 * Action: Serial Numbers Admin Page
		 *
		 * @param string $current_tab Current tab.
		 *
		 * @since 1.0.0
		 */
		do_action( "product_tabs_manager_{$page_hook}_content", $current_tab );
		?>
	</div>
<?php
