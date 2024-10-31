<?php
/**
 * Product Tab Meta.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="wcptm_product_tab_data" class="panel wc-metaboxes-wrapper tw-pb-4">
	<div class="tw-flex tw-justify-between tw-items-center tw-px-2 tw-pt-0 tw-pb-2 tw-bg-[#0542FA]">
		<div>
			<h4 class="tw-text-white tw-text-sm tw-mb-1"><?php esc_html_e( 'WooCommerce Product Tabs Manager', 'product-tabs-manager' ); ?></h4>
			<a href="<?php echo esc_url( 'https://pluginever.com/plugins/wc-tab-manager' ); ?>" target="_blank" class="wcptm-pro tw-italic tw-text-white hover:tw-text-gray-400 tw-font-bold tw-text-sm"><?php esc_html_e( 'Upgrade To Pro', 'product-tabs-manager' ); ?></a>
		</div>
		<div class="tw-flex tw-justify-between tw-items-center tw-gap-4">
			<div class="tw-inline-flex">
				<label class="tw-inline-flex tw-cursor-pointer tw-w-full tw-gap-2 tw-text-white wcptm-pro">
					<?php esc_html_e( 'Disable All Tabs:', 'product-tabs-manager' ); ?>
					<input class="tw-sr-only tw-peer !tw-border-[#e4e3df]" type="checkbox" name="wcptm_tab_is_disable" value="<?php echo esc_attr( 'yes' ); ?>" <?php if ( 'yes' === $is_tab_active ) { echo 'checked'; } ?> disabled>
					<div class="wcptm-small-toggle tw-bg-[#ff7f0e]"></div>
				</label>
			</div>
			<div class="tw-text-white">
				<a href="#" class="wcptm-expand-all tw-text-white hover:tw-text-gray-400"><?php esc_html_e( 'Expand All', 'product-tabs-manager' ); ?></a> /
				<a href="#" class="wcptm-close-all tw-text-white hover:tw-text-gray-400"><?php esc_html_e( 'Close All', 'product-tabs-manager' ); ?></a>
			</div>
		</div>
	</div>
	<div class="wcptm-all-tab-list tw-pb-4">
		<?php $tab_position = 0; foreach ( $tabs as $tab ) { ?>
		<div class="tw-mt-[1px] wcptm-all-tab-list-item">
			<div class="wcptm-move-handle tw-flex tw-justify-between tw-items-center tw-px-2 tw-bg-gray-200">
				<div class="tw-flex tw-items-center tw-gap-1 tw-text-text-grey-500 hover:tw-text-blue-500">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
						<path d="M7.6 16.5C8.48366 16.5 9.2 15.7725 9.2 14.875C9.2 13.9775 8.48366 13.25 7.6 13.25C6.71634 13.25 6 13.9775 6 14.875C6 15.7725 6.71634 16.5 7.6 16.5Z"/>
						<path d="M7.6 11.625C8.48366 11.625 9.2 10.8975 9.2 10C9.2 9.10254 8.48366 8.375 7.6 8.375C6.71634 8.375 6 9.10254 6 10C6 10.8975 6.71634 11.625 7.6 11.625Z"/>
						<path d="M7.6 6.75C8.48366 6.75 9.2 6.02246 9.2 5.125C9.2 4.22754 8.48366 3.5 7.6 3.5C6.71634 3.5 6 4.22754 6 5.125C6 6.02246 6.71634 6.75 7.6 6.75Z"/>
						<path d="M12.4 16.5C13.2837 16.5 14 15.7725 14 14.875C14 13.9775 13.2837 13.25 12.4 13.25C11.5163 13.25 10.8 13.9775 10.8 14.875C10.8 15.7725 11.5163 16.5 12.4 16.5Z"/>
						<path d="M12.4 11.625C13.2837 11.625 14 10.8975 14 10C14 9.10254 13.2837 8.375 12.4 8.375C11.5163 8.375 10.8 9.10254 10.8 10C10.8 10.8975 11.5163 11.625 12.4 11.625Z"/>
						<path d="M12.4 6.75C13.2837 6.75 14 6.02246 14 5.125C14 4.22754 13.2837 3.5 12.4 3.5C11.5163 3.5 10.8 4.22754 10.8 5.125C10.8 6.02246 11.5163 6.75 12.4 6.75Z"/>
					</svg>
					<h4 class="tw-text-[#030a49]">
								<?php echo esc_attr( $tab['title'] ); ?>
								<?php if ( 'default' === $tab['type'] ) { ?>
							<span class="tw-italic tw-text-gray-400"><?php echo esc_attr( ' - Default Tab' ); ?></span>
						<?php } ?>
					</h4>
				</div>
				<div class="tw-flex tw-gap-5 tw-items-center">
					<label class="tw-inline-flex tw-cursor-pointer tw-w-full tw-gap-2 tw-text-[#030a49] wcptm-pro">
								<?php esc_html_e( 'Disable This Tab:', 'product-tabs-manager' ); ?>
						<input class="tw-sr-only tw-peer !tw-border-[#e4e3df]" type="checkbox" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][disable]" value="<?php echo esc_attr( 'yes' ); ?>" <?php if ( 'yes' === $tab['disable'] ) { echo 'checked'; } ?> disabled>
						<div class="wcptm-small-toggle tw-bg-[#ff7f0e]"></div>
					</label>
					<svg class="wcptm-tab-edit-show tw-text-text-grey-500 hover:tw-text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
						<path d="M8.19788 14.2882L9.1139 13.373H3.94387V3.943H17.158V6.76351C17.3385 6.83924 17.5025 6.94943 17.6408 7.0879L18.1019 7.54856V3.4715C18.1019 3.34645 18.0522 3.22652 17.9637 3.1381C17.8752 3.04968 17.7551 3 17.63 3H3.47193C3.34677 3 3.22673 3.04968 3.13823 3.1381C3.04972 3.22652 3 3.34645 3 3.4715V13.8445C3 13.9695 3.04972 14.0895 3.13823 14.1779C3.22673 14.2663 3.34677 14.316 3.47193 14.316H8.17617C8.1842 14.3075 8.19127 14.2967 8.19788 14.2882Z"/>
						<path d="M18.8782 9.92397L16.838 7.88568C16.7977 7.84562 16.7499 7.81395 16.6972 7.7925C16.6445 7.77105 16.5882 7.76025 16.5313 7.76073H16.5176C16.3934 7.76389 16.2752 7.81451 16.1873 7.90218L8.99875 15.0888C8.95723 15.1303 8.92673 15.1815 8.91003 15.2378L7.75709 18.6986C7.71698 18.8315 7.91944 18.9994 8.03412 18.9994C8.04133 19.0002 8.04861 19.0002 8.05583 18.9994C8.15352 18.9768 11.0101 18.0008 11.5217 17.847C11.5772 17.8304 11.6277 17.8001 11.6685 17.7589L18.857 10.5718C18.9405 10.4884 18.9909 10.3774 18.9986 10.2597C19.0036 10.1984 18.9954 10.1367 18.9747 10.0788C18.9539 10.0209 18.921 9.96814 18.8782 9.92397ZM8.68161 18.0753L9.6151 15.473L11.2857 17.1379C10.5207 17.3675 9.34232 17.8782 8.68161 18.0753Z"/>
					</svg>
					<a href="#" class="wcptm-tab-edit-done tw-hidden"><?php esc_html_e( 'Done', 'product-tabs-manager' ); ?></a>
				</div>
			</div>
			<div class="tw-px-2 tw-pt-2 tw-bg-gray-50 wcptm-tab-details-to-show tw-hidden">
				<div class="tw-w-full tw-flex tw-justify-end">
					<label class="tw-inline-flex tw-justify-end tw-cursor-pointer tw-w-full tw-gap-2 tw-text-[#030a49] wcptm-pro">
								<?php esc_html_e( 'Overwrite It:', 'product-tabs-manager' ); ?>
						<input class="tw-sr-only tw-peer !tw-border-[#e4e3df]" type="checkbox" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][is_overwrite]" value="<?php echo esc_attr( 'yes' ); ?>" <?php if ( 'yes' === $tab['is_overwrite'] ) { echo 'checked'; } ?> disabled>
						<div class="wcptm-small-toggle tw-bg-[#ff7f0e]"></div>
					</label>
				</div>
				<div class="tw-flex tw-gap-4 tw-items-center !tw-mt-1">
					<div class="tw-w-1/5 sm:tw-max-w-60">
						<h4 class="!tw-text-black !tw-font-bold tw-text-sm"><?php esc_html_e( 'Tab Title', 'product-tabs-manager' ); ?></h4>
					</div>
					<label class="tw-inline-flex tw-cursor-pointer tw-w-4/5">
						<input type="text" class="tw-w-full" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][title]" value="<?php echo esc_attr( 'yes' === $tab['is_overwrite'] ? $tab['custom_title'] : $tab['title'] ); ?>">
					</label>
				</div>
				<div class="tw-flex tw-gap-4 !tw-mt-1 tw-pb-3">
					<div class="tw-w-1/5 sm:tw-max-w-60">
						<?php if ( 'custom' === $tab['type'] ) { ?>
							<h4 class="!tw-text-black !tw-font-bold tw-text-sm"><?php esc_html_e( 'Tab Description', 'product-tabs-manager' ); ?></h4>
						<?php } else { ?>
							<h4 class="!tw-text-black !tw-font-bold tw-text-sm"><?php esc_html_e( 'Tab Heading', 'product-tabs-manager' ); ?></h4>
						<?php } ?>
					</div>
					<div class="tw-flex tw-cursor-pointer tw-w-4/5">
								<?php
								if ( 'custom' === $tab['type'] ) {
									$content   = 'yes' === $tab['is_overwrite'] ? $tab['custom_content'] : $tab['content'];
									$editor_id = 'wcptm_product_save_tabs_content_' . esc_attr( $tab_position );
									$settings  = array(
										'media_buttons' => true,
										'textarea_rows' => 15,
										'teeny'         => true,
										'textarea_name' => $editor_id,
										'tinymce'       => true,
										'wpautop'       => true,
									);
									wp_editor( $content, $editor_id, $settings );
								} else {
									?>
										<input type="text" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][heading]" class="tw-w-full" value="<?php echo esc_attr( 'yes' === $tab['is_overwrite'] ? $tab['custom_heading'] : $tab['heading'] ); ?>">
									<?php
								}
								?>
					</div>
				</div>
			</div>
			<input type="hidden" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][type]" value="<?php echo esc_attr( $tab['type'] ); ?>">
			<input type="hidden" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][id]" value="<?php echo esc_attr( $tab['id'] ); ?>">
			<input type="hidden" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][post_id]" value="<?php echo esc_attr( $tab['post_id'] ); ?>">
			<input type="hidden" name="wcptm_product_save_tabs[<?php echo esc_attr( $tab_position ); ?>][position]" class="wcptm_product_tab_position" value="<?php echo esc_attr( $tab_position ); ?>">
		</div>
				<?php ++$tab_position; } ?>
		<input type="hidden" name="wcptm_product_tab_count" class="wcptm_product_tab_count" value="<?php echo esc_attr( $tab_position ); ?>">
	</div>

	<?php
	/**
	 * Action hook to add more fields after product tab meta.
	 *
	 * @since 1.0.0
	 */
	do_action( 'wcptm_after_product_tab_meta' );
	?>
</div>

<?php
require_once WCPTM_TEMPLATE_PATH . 'upgrade-to-pro.php';
