<?php
/**
 * Admin views: Add/Edit Product Tabs Data
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */

use WooCommerceProductTabsManager\Helpers;

defined( 'ABSPATH' ) || exit;

?>
<h1 class="wp-heading-inline">
	<?php
	if ( ! isset( $_GET['edit'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		esc_html_e( 'Add Product Tab', 'product-tabs-manager' );
	} else {
		esc_html_e( 'Edit Product Tab', 'product-tabs-manager' );
	}
	?>
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-tabs-manager' ) ); ?>" class="page-title-action">
		<?php esc_html_e( 'Back', 'product-tabs-manager' ); ?>
	</a>
	<?php if ( isset( $_GET['edit'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=product-tabs-manager&new=1' ) ); ?>" class="page-title-action">
		<?php esc_html_e( 'Add New Tab', 'product-tabs-manager' ); ?>
	</a>
	<?php } ?>
</h1>

<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<div class="bk-poststuff" id="wcptm-product-tabs-manager">
		<div class="column-1">
			<div class="bk-card">
				<div class="bk-card__header">
					<h3 class="pev-card__title !tw-text-xl"><?php esc_html_e( 'Tab Title & Description', 'product-tabs-manager' ); ?></h3>
					<p class="pev-card__subtitle sm:tw-text-right">
						<?php esc_html_e( 'Add tab title and description', 'product-tabs-manager' ); ?>
					</p>
				</div>
				<div class="bk-card__body form-inline !tw-px-6">
					<div class="bk-form-field !tw-mt-4">
						<label for="wcptm_tab_title" class="!tw-text-black !tw-font-bold tw-text-base">
							<?php esc_html_e( 'Title', 'product-tabs-manager' ); ?><span class="!tw-text-red-500">*</span>
						</label>
						<input type="text" name="wcptm_tab_title" id="wcptm_tab_title" class="regular-text !tw-border-[#e4e3df]" value="<?php echo esc_attr( $tab_details['wcptm_tab_title'] ); ?>" required placeholder="<?php esc_html_e( 'Add tab title...', 'product-tabs-manager' ); ?>"/>
					</div>
					<div class="bk-form-field !tw-mt-4">
						<label for="wcptm_tab_content_type" class="!tw-text-black !tw-font-bold tw-text-base">
							<?php esc_html_e( 'Content Type', 'product-tabs-manager' ); ?><span class="!tw-text-red-500">*</span>
						</label>
						<select type="text" name="wcptm_tab_content_type" id="wcptm_tab_content_type" class="regular-text !tw-border-[#e4e3df] tw-w-full" value="<?php echo esc_attr( $tab_details['wcptm_tab_content_type'] ); ?>" required >
							<option value="content"><?php esc_html_e( 'General Content', 'product-tabs-manager' ); ?></option>
							<option value="" disabled><?php esc_html_e( 'Question/Answer ( Upgrade to PRO )', 'product-tabs-manager' ); ?></option>
							<option value="" disabled><?php esc_html_e( 'Product List ( Upgrade to PRO )', 'product-tabs-manager' ); ?></option>
						</select>
					</div>
					<div class="bk-form-field !tw-mt-4">
						<label for="wcptm_tab_content" class="!tw-text-black !tw-font-bold tw-text-base">
							<?php esc_html_e( 'Description', 'product-tabs-manager' ); ?>
						</label>
						<?php
							$content   = isset( $tab_details['wcptm_tab_content'] ) ? $tab_details['wcptm_tab_content'] : '';
							$editor_id = 'wcptm_tab_content';
							$settings  = array(
								'media_buttons' => true,
								'textarea_rows' => 15,
								'teeny'         => true,
								'textarea_name' => $editor_id,
								'tinymce'       => true,
								'wpautop'       => true,
							);
							wp_editor( $content, $editor_id, $settings );
							?>
					</div>
				</div>
			</div>

			<div class="bk-card">
				<div class="bk-card__header">
					<h3 class="bk-card__title !tw-text-xl"> <?php esc_html_e( 'Tab Additional Settings', 'product-tabs-manager' ); ?> </h3>
					<p class="bk-card__subtitle sm:tw-text-right">
						<?php esc_html_e( 'Add tab additional settings.', 'product-tabs-manager' ); ?>
					</p>
				</div>
				<div class="bk-card__body form-inline !tw-px-6">
					<div class="tw-flex tw-gap-4 tw-items-center !tw-mt-4">
						<div class="tw-max-w-96 sm:tw-max-w-60">
							<h3 class="!tw-text-black !tw-font-bold tw-text-2xl"><?php esc_html_e( 'Disable This tab', 'product-tabs-manager' ); ?></h3>
							<p class="tw-text-black"><?php esc_html_e( 'Toggle this switch to deactivate the selected tab on the product page. When disabled, this tab will not be visible to customers, allowing you to control the content displayed.', 'product-tabs-manager' ); ?></p>
						</div>
						<label class="tw-inline-flex tw-cursor-pointer tw-w-full">
							<input class="tw-sr-only tw-peer !tw-border-[#e4e3df]" type="checkbox" name="wcptm_tab_is_disable" value="<?php echo esc_attr( 'yes' ); ?>" <?php if ( 'yes' === $tab_details['wcptm_tab_is_disable'] ) { echo 'checked'; } ?>>
							<div class="wcptm-large-toggle"></div>
						</label>
					</div>

					<div class="wcptm-divider"></div>

					<div class="tw-flex tw-gap-4 tw-items-center !tw-mt-4 sm:tw-flex-col lg:tw-flex-col">
						<div class="tw-max-w-96 lg:tw-max-w-full">
							<h3 class="!tw-text-black !tw-font-bold tw-text-2xl"><?php esc_html_e( 'Tab Visible Type ', 'product-tabs-manager' ); ?><span class="!tw-text-red-500">*</span></h3>
							<p class="tw-text-black"><?php esc_html_e( 'Choose how this tab should be shown: \'All Products\' will display it everywhere, \'Specific Products\' lets you select individual products, and \'Specific Categories\' allows you to show the tab for certain categories only. Pick the option that fits your needs.', 'product-tabs-manager' ); ?></p>
						</div>
						<label class="tw-inline-flex tw-cursor-pointer tw-w-full">
							<select class="!tw-w-full tw-h-[42px] !tw-max-w-full !tw-border-[#e4e3df]" name="wcptm_tab_visible_type" id="wcptm_tab_visible_type" required>
								<option value="all-products" <?php echo ( 'all-products' === $tab_details['wcptm_tab_visible_type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'All Products', 'product-tabs-manager' ); ?></option>
								<option disabled value="specific-products" <?php echo ( 'specific-products' === $tab_details['wcptm_tab_visible_type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Specific Products ( Upgrade to PRO )', 'product-tabs-manager' ); ?></option>
								<option value="specific-categories" <?php echo ( 'specific-categories' === $tab_details['wcptm_tab_visible_type'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Specific Categories', 'product-tabs-manager' ); ?></option>
							</select>
						</label>
					</div>

					<div class="tw-flex tw-gap-4 tw-items-center sm:tw-flex-col lg:tw-flex-col !tw-mt-4 wcptm-specific-product <?php echo ( 'all-products' === $tab_details['wcptm_tab_visible_type'] || 'specific-categories' === $tab_details['wcptm_tab_visible_type'] ) ? 'tw-hidden' : ''; ?>">
						<div class="tw-max-w-96 lg:tw-max-w-full">
							<h3 class="!tw-text-black !tw-font-bold tw-text-2xl"><?php esc_html_e( 'Specific Products', 'product-tabs-manager' ); ?></h3>
							<p class="tw-text-black"><?php esc_html_e( 'Use this multi-select box to choose products that will be associated with this tab. You can search for products by name and select multiple products to include them in this tab.', 'product-tabs-manager' ); ?></p>
						</div>
						<label class="tw-inline-flex tw-cursor-pointer tw-w-full">
							<select class="!tw-w-full !tw-border-[#e4e3df]" name="wcptm_tab_specific_products[]" id="wcptm_tab_specific_products" multiple="multiple">
								<?php if ( ! empty( $tab_details['wcptm_tab_specific_products'] ) ) : ?>
									<?php foreach ( $tab_details['wcptm_tab_specific_products'] as $product_id ) : ?>
										<option value="<?php echo esc_attr( $product_id ); ?>" selected="selected"><?php echo esc_html( Helpers::get_product_title( $product_id ) ); ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</label>
					</div>

					<div class="tw-flex tw-gap-4 tw-items-center !tw-mt-4 sm:tw-flex-col lg:tw-flex-col wcptm-specific-category <?php echo ( 'all-products' === $tab_details['wcptm_tab_visible_type'] || 'specific-products' === $tab_details['wcptm_tab_visible_type'] ) ? 'tw-hidden' : ''; ?>">
						<div class="tw-max-w-96 lg:tw-max-w-full">
							<h3 class="!tw-text-black !tw-font-bold tw-text-2xl"><?php esc_html_e( 'Specific Categories', 'product-tabs-manager' ); ?></h3>
							<p class="tw-text-black"><?php esc_html_e( 'Use this multi-select box to choose categories that will be associated with this tab. You can search for products by name and select multiple categories to include them in this tab.', 'product-tabs-manager' ); ?></p>
						</div>
						<label class="tw-inline-flex tw-cursor-pointer tw-w-full">
							<select class="!tw-w-full !tw-border-[#e4e3df]" name="wcptm_tab_specific_categories[]" id="wcptm_tab_specific_categories" multiple="multiple">
								<?php if ( ! empty( $tab_details['wcptm_tab_specific_categories'] ) ) : ?>
									<?php foreach ( $tab_details['wcptm_tab_specific_categories'] as $category_id ) : ?>
										<option value="<?php echo esc_attr( $category_id ); ?>" selected="selected"><?php echo esc_html( Helpers::get_category_title( $category_id ) ); ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</label>
					</div>

					<div class="wcptm-divider"></div>

					<div class="wcptm-upcoming wcptm-pro">
						<div class="tw-flex tw-gap-4 tw-items-center !tw-mt-4 sm:tw-flex-col lg:tw-flex-col">
							<div class="tw-max-w-96 lg:tw-max-w-full">
								<h3 class="!tw-text-black !tw-font-bold tw-text-2xl"><?php esc_html_e( 'Exclude Products', 'product-tabs-manager' ); ?></h3>
								<p class="tw-text-black"><?php esc_html_e( 'Choose the products you want to exclude this tab from. Use the multi-select box to search for and select multiple products. This tab will be hidden for the selected products.', 'product-tabs-manager' ); ?></p>
							</div>
							<label class="tw-inline-flex tw-cursor-pointer tw-w-full">
								<select class="!tw-w-full !tw-border-[#e4e3df]" name="wcptm_tab_exclude_products[]" id="wcptm_tab_exclude_products" multiple="multiple">
									<option value=""><?php esc_html_e( 'Select Products', 'product-tabs-manager' ); ?></option>
								</select>
							</label>
						</div>
						<div class="tw-flex tw-gap-4 tw-items-center !tw-mt-4 sm:tw-flex-col lg:tw-flex-col">
							<div class="tw-max-w-96 lg:tw-max-w-full">
								<h3 class="!tw-text-black !tw-font-bold tw-text-2xl"><?php esc_html_e( 'Exclude Categories', 'product-tabs-manager' ); ?></h3>
								<p class="tw-text-black"><?php esc_html_e( 'Choose the products you want to exclude this tab from. Use the multi-select box to search for and select multiple products. This tab will be hidden for the selected products.', 'product-tabs-manager' ); ?></p>
							</div>
							<label class="tw-inline-flex tw-cursor-pointer tw-w-full">
								<select class="!tw-w-full !tw-border-[#e4e3df]" name="wcptm_tab_exclude_categories[]" id="wcptm_tab_exclude_categories" multiple="multiple">
									<option value=""><?php esc_html_e( 'Select Categories', 'product-tabs-manager' ); ?></option>
								</select>
							</label>
						</div>
						<div class="wcptm-upcoming-pro-features tw-flex tw-justify-center tw-items-center">
							<h3 class="!tw-text-[#ff0000] !tw-text-2xl"><?php esc_html_e( 'Upgrade to Pro', 'product-tabs-manager' ); ?></h3>
						</div>
					</div>
					<?php
					/**
					 * Fires after the tabs on add tabs.
					 *
					 * @since 1.0.1
					 */
					do_action( 'wcptm_after_product_tabs_manager_metabox' );
					?>
				</div>
			</div>
		</div>
		<div class="column-2">
			<div class="bk-card">
				<div class="bk-card__header">
					<h3 class="bk-card__title"><?php esc_html_e( 'Actions', 'product-tabs-manager' ); ?></h3>
				</div>
				<div class="bk-card__footer">
					<input type="hidden" name="action" value="add_update_product_tabs_manager"/>
					<?php wp_nonce_field( 'wcptm_product_tab_add_update' ); ?>
					<?php if ( ! isset( $_GET['edit'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
						<button class="button button-primary bkit-w-100"><?php esc_html_e( 'Publish', 'product-tabs-manager' ); ?></button>
					<?php } else { ?>
						<a class="del" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'action', 'delete', admin_url( 'admin.php?page=product-tabs-manager&id=' . $tab_details['wcptm_tab_id'] ) ), 'bulk-tabs' ) ); ?>"><?php esc_html_e( 'Delete', 'product-tabs-manager' ); ?></a>
						<input type="hidden" name="post_id" value="<?php echo esc_attr( $tab_details['wcptm_tab_id'] ); ?>">
						<button class="button button-primary bkit-w-100"><?php esc_html_e( 'Update', 'product-tabs-manager' ); ?></button>
					<?php } ?>
				</div>
			</div>
			<div class="bk-card tw-opacity-50 wcptm-pro">
				<div class="bk-card__header">
					<h3 class="bk-card__title"><?php esc_html_e( 'Add Icon', 'product-tabs-manager' ); ?></h3>
				</div>
				<div class="bk-card__body" id="icon-placeholder">
					<i class="dashicons dashicons-editor-help tw-w-full tw-h-[64px]"></i>
				</div>
				<div class="bk-card__footer" id="icon-picker-wrap">
					<span class="del icon-none tw-text-accent-red-500 hover:tw-text-red-800 hover:tw-underline"><?php esc_html_e( 'Remove', 'product-tabs-manager' ); ?></span>
					<span class="button button-primary bkit-w-100 icon-picker">
						<span id="select-icon" class="select-icon"><?php esc_html_e( 'Add Icon', 'product-tabs-manager' ); ?></span>
					</span>
				</div>
			</div>
			<div class="bk-card">
				<div class="bk-card__header">
					<h3 class="bk-card__title"><?php esc_html_e( 'Need Any Help?', 'product-tabs-manager' ); ?></h3>
				</div>
				<div class="bk-card__body">
					<p><?php esc_html_e( 'Support team is here to assist you. Get help with any issues you might have.', 'product-tabs-manager' ); ?></p>
				</div>
				<div class="bk-card__footer">
					<a href="<?php echo esc_url( 'https://pluginever.com/docs/wc-tab-manager/' ); ?>" class="tw-flex tw-justify-center tw-text-accent-orange-500 tw-no-underline" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
							<path d="M12.4994 15.8333V12.9166C12.4994 12.8061 12.5432 12.7001 12.6214 12.622C12.6995 12.5439 12.8055 12.5 12.916 12.5H15.8327C15.8393 12.5633 15.8334 12.6274 15.8153 12.6884C15.7971 12.7495 15.7671 12.8064 15.7269 12.8558L12.8552 15.7275C12.8058 15.7677 12.7489 15.7977 12.6878 15.8159C12.6268 15.834 12.5627 15.84 12.4994 15.8333Z"/>
							<path d="M15.416 4.16663H4.58268C4.47218 4.16663 4.36619 4.21052 4.28805 4.28866C4.20991 4.36681 4.16602 4.47279 4.16602 4.58329V15.4166C4.16602 15.5271 4.20991 15.6331 4.28805 15.7113C4.36619 15.7894 4.47218 15.8333 4.58268 15.8333H11.666V12.5C11.666 12.2789 11.7538 12.067 11.9101 11.9107C12.0664 11.7544 12.2783 11.6666 12.4994 11.6666H15.8327V4.58329C15.8327 4.47279 15.7888 4.36681 15.7106 4.28866C15.6325 4.21052 15.5265 4.16663 15.416 4.16663ZM9.99935 12.5H6.66602V11.6666H9.99935V12.5ZM13.3327 9.99996H6.66602V9.16663H13.3327V9.99996ZM13.3327 7.49996H6.66602V6.66663H13.3327V7.49996Z"/>
						</svg>
						<?php esc_html_e( 'Documentation', 'product-tabs-manager' ); ?>
					</a>
					<a href="<?php echo esc_url( 'https://pluginever.com/support/' ); ?>" class="tw-flex tw-justify-center tw-text-fade-blue-600 tw-no-underline" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
							<path d="M10.4167 8.33325C10.5272 8.33325 10.6332 8.37715 10.7113 8.45529C10.7894 8.53343 10.8333 8.63941 10.8333 8.74992V13.7499C10.8333 13.8604 10.7894 13.9664 10.7113 14.0445C10.6332 14.1227 10.5272 14.1666 10.4167 14.1666H6.49417C6.38367 14.1666 6.2777 14.2105 6.19958 14.2887L5 15.4878V14.5833C5 14.4727 4.9561 14.3668 4.87796 14.2886C4.79982 14.2105 4.69384 14.1666 4.58333 14.1666H3.75C3.63949 14.1666 3.53351 14.1227 3.45537 14.0445C3.37723 13.9664 3.33333 13.8604 3.33333 13.7499V8.74992C3.33333 8.63941 3.37723 8.53343 3.45537 8.45529C3.53351 8.37715 3.63949 8.33325 3.75 8.33325H10.4167ZM3.75 7.49992C3.41848 7.49992 3.10054 7.63162 2.86612 7.86604C2.6317 8.10046 2.5 8.4184 2.5 8.74992V13.7499C2.5 14.0814 2.6317 14.3994 2.86612 14.6338C3.10054 14.8682 3.41848 14.9999 3.75 14.9999H4.16667V16.997C4.16668 17.0382 4.17891 17.0785 4.20183 17.1128C4.22475 17.1471 4.25732 17.1737 4.29542 17.1895C4.33351 17.2052 4.37543 17.2093 4.41585 17.2012C4.45627 17.1932 4.49339 17.1733 4.5225 17.1441L6.66667 14.9999H10.4167C10.7482 14.9999 11.0661 14.8682 11.3006 14.6338C11.535 14.3994 11.6667 14.0814 11.6667 13.7499V8.74992C11.6667 8.4184 11.535 8.10046 11.3006 7.86604C11.0661 7.63162 10.7482 7.49992 10.4167 7.49992H3.75Z"/>
							<path d="M12.5 8.58325C12.5 8.07492 12.2981 7.58741 11.9386 7.22796C11.5792 6.86852 11.0917 6.66659 10.5833 6.66659H7.5V4.58325C7.5 4.25173 7.6317 3.93379 7.86612 3.69937C8.10054 3.46495 8.41848 3.33325 8.75 3.33325H16.25C16.5815 3.33325 16.8995 3.46495 17.1339 3.69937C17.3683 3.93379 17.5 4.25173 17.5 4.58325V9.58325C17.5 9.91477 17.3683 10.2327 17.1339 10.4671C16.8995 10.7016 16.5815 10.8333 16.25 10.8333H15V12.8303C15 12.8716 14.9878 12.9119 14.9648 12.9461C14.9419 12.9804 14.9093 13.0071 14.8713 13.0228C14.8332 13.0386 14.7912 13.0427 14.7508 13.0346C14.7104 13.0265 14.6733 13.0066 14.6442 12.9774L12.5 10.8333V8.58325Z"/>
						</svg>
						<?php esc_html_e( 'Get Support', 'product-tabs-manager' ); ?>
					</a>
				</div>
			</div>
			<?php if ( ! is_plugin_active( 'wc-tab-manager/wc-tab-manager.php' ) ) { ?>
				<div class="bk-card">
					<div class="bk-card__header">
						<h2><?php esc_html_e( 'Try Pro!', 'product-tabs-manager' ); ?></h2>
					</div>
					<div class="bk-card__body">
						<ul>
							<li class="tw-flex tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Get Category visibility type.', 'product-tabs-manager' ); ?>
							</li>
							<li class="tw-flex tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Get Exclude Products Option', 'product-tabs-manager' ); ?>
							</li>
							<li class="tw-flex tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Get Exclude Categories Option.', 'product-tabs-manager' ); ?>
							</li>
							<li class="tw-flex tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Get Exclude from user type option.', 'product-tabs-manager' ); ?>
							</li>
							<li class="tw-flex tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Disable default tabs globally.', 'product-tabs-manager' ); ?>
							</li>
							<li class="tw-flex tw-flex-row tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Sort Tabs in Your Preferred Order.', 'product-tabs-manager' ); ?>
							</li>
							<li class="tw-flex tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Customize tabs from product admin page.', 'product-tabs-manager' ); ?>
							</li>
							<li class="tw-flex tw-justify-left tw-items-center tw-gap-2">
								<svg class="tw-w-6" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
									<g clip-path="url(#clip0_676_7168)">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99495 14.8471C5.76824 14.8471 3.14258 12.2214 3.14258 8.99471C3.14258 5.76799 5.76824 3.14233 8.99495 3.14233C12.2217 3.14233 14.8473 5.76799 14.8473 8.99471C14.8473 12.2214 12.2217 14.8471 8.99495 14.8471Z" fill="#FFC107"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.99473 2.25659C8.8471 2.25659 8.72056 2.1406 8.72056 1.98243V0.274165C8.72056 0.126538 8.8471 0 8.99473 0C9.1529 0 9.26889 0.126538 9.26889 0.274165V1.98243C9.26889 2.1406 9.1529 2.25659 8.99473 2.25659ZM12.5062 3.19508C12.4534 3.19508 12.4112 3.18453 12.3691 3.16344C12.232 3.08963 12.1898 2.92091 12.2636 2.79438L13.1283 1.30756C13.2021 1.17047 13.3708 1.1283 13.4974 1.20211C13.6239 1.27592 13.6766 1.44464 13.5923 1.58172L12.7381 3.058C12.6854 3.1529 12.6011 3.19508 12.5062 3.19508ZM15.0685 5.76801C14.9736 5.76801 14.8787 5.71529 14.8366 5.63093C14.7627 5.49385 14.8049 5.33568 14.9315 5.25132L16.4183 4.39719C16.5448 4.32337 16.7135 4.36555 16.7873 4.50264C16.8612 4.62917 16.819 4.79789 16.6924 4.8717L15.2056 5.72583C15.1634 5.75747 15.1213 5.76801 15.0685 5.76801ZM17.7258 9.26889H16.007C15.8594 9.26889 15.7329 9.1529 15.7329 8.99473C15.7329 8.8471 15.8594 8.72056 16.007 8.72056H17.7258C17.8735 8.72056 18 8.8471 18 8.99473C18 9.1529 17.8735 9.26889 17.7258 9.26889ZM16.5554 13.6344C16.5026 13.6344 16.4605 13.6239 16.4183 13.5923L14.9315 12.7381C14.8049 12.6643 14.7627 12.4956 14.8366 12.3691C14.9104 12.232 15.0791 12.1898 15.2056 12.2636L16.6924 13.1283C16.819 13.2021 16.8612 13.3708 16.7873 13.4974C16.7452 13.5817 16.6503 13.6344 16.5554 13.6344ZM13.3603 16.8295C13.2654 16.8295 13.1705 16.7768 13.1283 16.6924L12.2636 15.2056C12.1898 15.0791 12.232 14.9104 12.3691 14.8366C12.4956 14.7627 12.6643 14.8049 12.7381 14.9315L13.5923 16.4183C13.6766 16.5448 13.6239 16.7135 13.4974 16.7873C13.4552 16.819 13.4025 16.8295 13.3603 16.8295ZM8.99473 18C8.8471 18 8.72056 17.8735 8.72056 17.7258V16.007C8.72056 15.8594 8.8471 15.7329 8.99473 15.7329C9.1529 15.7329 9.26889 15.8594 9.26889 16.007V17.7258C9.26889 17.8735 9.1529 18 8.99473 18ZM4.63972 16.8295C4.58699 16.8295 4.54482 16.819 4.50264 16.7873C4.36555 16.7135 4.32337 16.5448 4.39719 16.4183L5.25132 14.9315C5.33568 14.8049 5.49385 14.7522 5.63093 14.8366C5.75747 14.9104 5.79965 15.0791 5.72583 15.2056L4.8717 16.6924C4.81898 16.7768 4.73462 16.8295 4.63972 16.8295ZM1.44464 13.6344C1.34974 13.6344 1.25483 13.5817 1.20211 13.4974C1.1283 13.3708 1.17047 13.2021 1.30756 13.1283L2.79438 12.2636C2.92091 12.1898 3.08963 12.232 3.16344 12.3691C3.23726 12.4956 3.19508 12.6643 3.06854 12.7381L1.58172 13.5923C1.53954 13.6239 1.48682 13.6344 1.44464 13.6344ZM1.98243 9.26889H0.274165C0.126538 9.26889 0 9.1529 0 8.99473C0 8.8471 0.126538 8.72056 0.274165 8.72056H1.98243C2.1406 8.72056 2.25659 8.8471 2.25659 8.99473C2.25659 9.1529 2.1406 9.26889 1.98243 9.26889ZM2.93146 5.76801C2.87873 5.76801 2.83656 5.75747 2.79438 5.72583L1.30756 4.8717C1.17047 4.79789 1.1283 4.62917 1.20211 4.50264C1.27592 4.36555 1.44464 4.32337 1.58172 4.39719L3.06854 5.25132C3.19508 5.33568 3.23726 5.49385 3.16344 5.63093C3.11072 5.71529 3.01582 5.76801 2.93146 5.76801ZM5.49385 3.19508C5.39895 3.19508 5.30404 3.1529 5.25132 3.06854L4.39719 1.58172C4.32337 1.44464 4.36555 1.27592 4.50264 1.20211C4.62917 1.1283 4.79789 1.17047 4.8717 1.30756L5.72583 2.79438C5.79965 2.92091 5.75747 3.08963 5.63093 3.16344C5.58875 3.18453 5.53603 3.19508 5.49385 3.19508Z" fill="#FF9D05"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.9775 12.3163C10.9458 12.3163 10.9142 12.3163 10.8826 12.2952L8.99505 11.5676L7.11807 12.2952C7.03371 12.3374 6.92826 12.3163 6.85445 12.2636C6.78064 12.2108 6.73846 12.1265 6.749 12.0316L6.86499 10.0175L5.57853 8.45688C5.5258 8.38307 5.50471 8.28816 5.53635 8.19326C5.56798 8.1089 5.63125 8.03509 5.72615 8.014L7.67695 7.50785L8.77361 5.79959C8.81579 5.72577 8.91069 5.68359 8.99505 5.68359C9.08995 5.68359 9.17431 5.72577 9.22703 5.79959L10.3237 7.50785L12.2745 8.014C12.3588 8.03509 12.4327 8.1089 12.4643 8.19326C12.4959 8.28816 12.4748 8.38307 12.4116 8.45688L11.1356 10.0175L11.2516 12.0316C11.2516 12.1265 11.2095 12.2108 11.1356 12.2636C11.0935 12.3057 11.0302 12.3163 10.9775 12.3163Z" fill="white"/>
									</g>
								</svg>
								<?php esc_html_e( 'Disable tabs from product admin page.', 'product-tabs-manager' ); ?>
							</li>
						</ul>
					</div>
					<div class="bk-card__footer">
						<a href="<?php echo esc_url( 'https://demo.pluginever.com/wc-tab-manager/' ); ?>" class="tw-flex tw-justify-center tw-text-accent-orange-500 tw-no-underline" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
								<path d="M13.359 5.74267C12.3183 5.26865 11.1689 5.01451 10 5C5.59924 5 2 8.89866 2 10.1634C2 11.5195 5.78819 15 9.96749 15C14.1834 15 18 11.5167 18 10.1634C18 9.09664 15.8596 6.84514 13.359 5.74267ZM10 14.1705C9.07325 14.1705 8.16732 13.926 7.39676 13.4678C6.6262 13.0096 6.02562 12.3584 5.67096 11.5964C5.31631 10.8345 5.22352 9.99605 5.40432 9.18718C5.58512 8.3783 6.03139 7.6353 6.6867 7.05214C7.34201 6.46897 8.17692 6.07183 9.08586 5.91093C9.9948 5.75004 10.9369 5.83261 11.7931 6.14822C12.6493 6.46383 13.3812 6.99829 13.896 7.68402C14.4109 8.36976 14.6857 9.17596 14.6857 10.0007C14.6857 10.5483 14.5645 11.0905 14.329 11.5964C14.0936 12.1023 13.7484 12.562 13.3133 12.9492C12.8782 13.3364 12.3616 13.6436 11.7931 13.8531C11.2246 14.0627 10.6153 14.1705 10 14.1705Z"/>
								<path d="M11.3547 10.0382C10.9955 10.0382 10.651 9.91125 10.397 9.68526C10.1429 9.45928 10.0001 9.15276 10 8.83311C10.0026 8.62348 10.0673 8.41818 10.1878 8.23799C10.3082 8.05781 10.48 7.90914 10.6857 7.80703C10.4632 7.74743 10.2324 7.71563 10 7.71256C9.49135 7.71256 8.99412 7.8468 8.5712 8.09829C8.14828 8.34978 7.81866 8.70723 7.62403 9.12544C7.4294 9.54365 7.3785 10.0038 7.47777 10.4478C7.57704 10.8917 7.82202 11.2995 8.18173 11.6196C8.54143 11.9396 8.99971 12.1575 9.4986 12.2458C9.99749 12.334 10.5146 12.2886 10.9845 12.1154C11.4544 11.9421 11.856 11.6487 12.1385 11.2723C12.421 10.8958 12.5718 10.4533 12.5717 10.0007C12.5684 9.81722 12.5385 9.6349 12.4828 9.45826C12.3662 9.63272 12.2013 9.77766 12.0037 9.87919C11.8062 9.98073 11.5827 10.0355 11.3547 10.0382Z"/>
							</svg>
							<?php esc_html_e( 'View Demo', 'product-tabs-manager' ); ?>
						</a>
						<a href="<?php echo esc_url( 'https://pluginever.com/plugins/wc-tab-manager/' ); ?>" class="wcptm-pro button button-primary !tw-flex !tw-items-center tw-text-white tw-bg-orange-400 tw-no-underline tw-p-2 tw-rounded hover:tw-text-white hover:tw-bg-orange-300 tw-gap-[4px]" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
								<path d="M15.1332 15.5894L17.3494 7.57188L13.7182 9.62938C13.6287 9.68017 13.5299 9.71259 13.4278 9.72473C13.3256 9.73687 13.222 9.72849 13.1231 9.70009C13.0242 9.67168 12.932 9.62382 12.8518 9.5593C12.7717 9.49479 12.7052 9.41492 12.6563 9.32438L9.99942 4.41626L7.34254 9.32376C7.29346 9.41411 7.22688 9.4938 7.1467 9.55817C7.06651 9.62253 6.97432 9.6703 6.87549 9.69869C6.77666 9.72708 6.67317 9.73551 6.57105 9.72351C6.46893 9.7115 6.37022 9.67929 6.28066 9.62876L2.64941 7.57126L4.86566 15.5894H15.1332Z" fill="#FFD731"/>
								<path d="M17.3492 7.56885L15.1305 15.5876H12.6367C13.2098 14.6379 13.5716 13.5759 13.6973 12.4738C13.801 11.5494 13.736 10.6138 13.5055 9.7126C13.5805 9.7001 13.6492 9.66885 13.718 9.63135L17.3492 7.56885Z" fill="#FFC933"/>
								<path d="M16.905 15.3345C16.9062 15.5786 16.8251 15.8161 16.6749 16.0086C16.5247 16.2011 16.314 16.3375 16.0769 16.3957C14.0563 16.8707 12.0244 17.0988 9.99939 17.0988C7.97439 17.0988 5.94189 16.8707 3.92189 16.3957C3.68475 16.3375 3.47411 16.2011 3.32389 16.0086C3.17367 15.8161 3.09261 15.5786 3.09376 15.3345C3.09376 14.6488 3.72314 14.1263 4.39314 14.2707C6.25814 14.6732 8.13189 14.8676 9.99939 14.8676C11.8669 14.8676 13.7406 14.6738 15.6056 14.2707C16.2756 14.1263 16.905 14.6488 16.905 15.3345Z" fill="#FFD731"/>
								<path d="M16.9062 15.3389C16.9062 15.8389 16.5625 16.2827 16.075 16.3952C15.425 16.5452 14.775 16.6764 14.125 16.7764C14.45 16.5514 14.65 16.1764 14.65 15.7702C14.65 15.2014 14.2625 14.7327 13.75 14.6014C14.3687 14.5139 14.9875 14.4077 15.6062 14.2702C16.275 14.1264 16.9062 14.6514 16.9062 15.3389Z" fill="#FFC933"/>
								<path d="M2.65 8.97212C3.4232 8.97212 4.05 8.34532 4.05 7.57212C4.05 6.79892 3.4232 6.17212 2.65 6.17212C1.8768 6.17212 1.25 6.79892 1.25 7.57212C1.25 8.34532 1.8768 8.97212 2.65 8.97212Z" fill="#FFD731"/>
								<path d="M17.3492 8.97212C18.1224 8.97212 18.7492 8.34532 18.7492 7.57212C18.7492 6.79892 18.1224 6.17212 17.3492 6.17212C16.576 6.17212 15.9492 6.79892 15.9492 7.57212C15.9492 8.34532 16.576 8.97212 17.3492 8.97212Z" fill="#FFC933"/>
								<path d="M9.99961 5.70259C10.7728 5.70259 11.3996 5.07579 11.3996 4.30259C11.3996 3.52939 10.7728 2.90259 9.99961 2.90259C9.22641 2.90259 8.59961 3.52939 8.59961 4.30259C8.59961 5.07579 9.22641 5.70259 9.99961 5.70259Z" fill="#FFD731"/>
								<path d="M9.99957 13.3145C10.7258 13.3145 11.3146 12.6032 11.3146 11.7257C11.3146 10.8483 10.7258 10.137 9.99957 10.137C9.27332 10.137 8.68457 10.8483 8.68457 11.7257C8.68457 12.6032 9.27332 13.3145 9.99957 13.3145Z" fill="#FF7F0E"/>
								<path d="M11.3123 11.7245C11.3123 12.5995 10.7248 13.312 9.9998 13.312C9.8498 13.312 9.7123 13.2807 9.58105 13.2307C10.0998 13.0182 10.4748 12.4245 10.4748 11.7245C10.4748 11.0245 10.0998 10.4307 9.58105 10.2182C9.7123 10.1682 9.8498 10.137 9.9998 10.137C10.7248 10.137 11.3123 10.8495 11.3123 11.7245Z" fill="#FF7F0E"/>
								<path d="M5.25306 11.6529L4.76306 9.88099C4.75404 9.84728 4.73839 9.81571 4.71703 9.78813C4.69566 9.76054 4.66901 9.73749 4.63864 9.72032C4.60826 9.70315 4.57476 9.69222 4.54011 9.68815C4.50546 9.68407 4.47034 9.68695 4.43681 9.69661C4.40323 9.70586 4.3718 9.72165 4.34432 9.74305C4.31684 9.76446 4.29385 9.79108 4.27667 9.82138C4.25949 9.85168 4.24845 9.88508 4.24418 9.91965C4.23992 9.95422 4.24251 9.98929 4.25181 10.0229L4.74181 11.7947C4.76078 11.8625 4.80581 11.92 4.86707 11.9547C4.92832 11.9894 5.00081 11.9984 5.06869 11.9797C5.13644 11.9608 5.19391 11.9157 5.22848 11.8544C5.26305 11.7932 5.27189 11.7207 5.25306 11.6529ZM5.55869 12.7572C5.54966 12.7235 5.53399 12.6918 5.5126 12.6641C5.4912 12.6365 5.46451 12.6134 5.43407 12.5961C5.40364 12.5789 5.37008 12.5679 5.33535 12.5638C5.30062 12.5597 5.26542 12.5626 5.23181 12.5722C5.19823 12.5815 5.1668 12.5973 5.13932 12.6187C5.11184 12.6401 5.08885 12.6667 5.07167 12.697C5.05449 12.7273 5.04345 12.7607 5.03918 12.7953C5.03492 12.8298 5.03751 12.8649 5.04681 12.8985L5.09244 13.0641C5.1151 13.1273 5.16082 13.1797 5.22043 13.2106C5.28005 13.2415 5.34915 13.2488 5.4139 13.2309C5.47864 13.2131 5.53424 13.1714 5.56955 13.1143C5.60487 13.0571 5.61728 12.9888 5.60431 12.9229L5.55869 12.7572ZM8.72181 9.20474C8.75247 9.22149 8.78614 9.232 8.82089 9.23566C8.85563 9.23932 8.89075 9.23606 8.92423 9.22606C8.9577 9.21607 8.98887 9.19954 9.01591 9.17742C9.04296 9.15531 9.06536 9.12806 9.08181 9.09724L9.50494 8.31599C9.53842 8.25399 9.5459 8.18124 9.52574 8.11372C9.50558 8.04621 9.45943 7.98947 9.39744 7.95599C9.33544 7.9225 9.26269 7.91502 9.19517 7.93518C9.12766 7.95534 9.07092 8.00149 9.03744 8.06349L8.61494 8.84474C8.58156 8.90669 8.57407 8.97933 8.5941 9.04679C8.61412 9.11425 8.66004 9.17103 8.72181 9.20474Z" fill="#FFE576"/>
								<path d="M17.3496 5.90563C16.9081 5.90613 16.4847 6.08178 16.1724 6.39403C15.8602 6.70629 15.6845 7.12966 15.684 7.57126C15.684 7.77501 15.7259 7.96813 15.7934 8.14876L13.5878 9.40001C13.5288 9.43338 13.4638 9.45465 13.3965 9.46255C13.3292 9.47046 13.261 9.46484 13.1959 9.44604C13.1309 9.42723 13.0702 9.39562 13.0175 9.35305C12.9648 9.31048 12.9211 9.25781 12.889 9.19813L10.9659 5.65188C11.1815 5.49854 11.3574 5.29593 11.479 5.0609C11.6005 4.82588 11.6642 4.56523 11.6646 4.30063C11.6646 3.38188 10.9178 2.63501 9.99902 2.63501C9.08027 2.63501 8.3334 3.38188 8.3334 4.30063C8.3334 4.85813 8.6109 5.34938 9.03215 5.65188L7.10902 9.19813C7.07707 9.25777 7.03352 9.31041 6.98093 9.35297C6.92834 9.39552 6.86777 9.42714 6.80278 9.44594C6.7378 9.46475 6.66971 9.47038 6.60251 9.46249C6.53532 9.4546 6.47039 9.43336 6.41152 9.40001L4.20527 8.14876C4.27613 7.96439 4.31318 7.76877 4.31465 7.57126C4.31465 6.65251 3.56777 5.90563 2.64902 5.90563C1.73027 5.90563 0.983398 6.65251 0.983398 7.57126C0.983398 8.49001 1.73027 9.23688 2.64902 9.23688C2.71152 9.23688 2.7709 9.22501 2.83152 9.21876L4.14965 13.9819C3.79623 13.9897 3.45994 14.1357 3.21285 14.3885C2.96575 14.6413 2.82752 14.9809 2.82777 15.3344C2.82777 15.9581 3.26215 16.5138 3.86027 16.6544C7.89792 17.602 12.1001 17.602 16.1378 16.6544C16.7365 16.5131 17.1703 15.9581 17.1703 15.3344C17.171 14.9807 17.0329 14.6409 16.7857 14.388C16.5385 14.1351 16.202 13.9893 15.8484 13.9819L17.1665 9.21938C17.2271 9.22626 17.2865 9.23751 17.349 9.23751C18.2678 9.23751 19.0146 8.49063 19.0146 7.57188C19.0146 6.65313 18.2678 5.90563 17.3496 5.90563ZM9.99965 3.16626C10.6253 3.16626 11.134 3.67501 11.134 4.30063C11.134 4.92626 10.6253 5.43563 9.99965 5.43563C9.37402 5.43563 8.86527 4.92688 8.86527 4.30126C8.86527 3.67563 9.37402 3.16626 9.99965 3.16626ZM1.51527 7.57126C1.51527 6.94563 2.02402 6.43688 2.64965 6.43688C3.27465 6.43688 3.78402 6.94563 3.78402 7.57126C3.78402 8.19689 3.27527 8.70626 2.64965 8.70626C2.02402 8.70626 1.51527 8.19689 1.51527 7.57126ZM16.6403 15.3344C16.6408 15.5185 16.5798 15.6975 16.4669 15.8429C16.354 15.9884 16.1957 16.0918 16.0171 16.1369C12.0589 17.0612 7.94098 17.0612 3.98277 16.1369C3.80426 16.0918 3.64594 15.9884 3.53302 15.8429C3.4201 15.6975 3.35907 15.5185 3.35965 15.3344C3.35965 15.0838 3.47215 14.8494 3.66715 14.6913C3.75962 14.6159 3.86783 14.5623 3.9838 14.5344C4.09977 14.5065 4.22052 14.505 4.33715 14.53C8.0697 15.3306 11.9296 15.3306 15.6621 14.53C15.8971 14.4806 16.1428 14.5381 16.3321 14.6913C16.5278 14.8494 16.6403 15.0838 16.6403 15.3344ZM15.2753 14.0625C11.7937 14.7694 8.20559 14.7694 4.72402 14.0625L3.34527 9.08001C3.57965 8.97126 3.78152 8.80876 3.94215 8.60938L6.14965 9.86251C6.26965 9.93101 6.40224 9.97462 6.53948 9.99073C6.67671 10.0068 6.81579 9.99511 6.9484 9.95626C7.08164 9.91857 7.20592 9.85442 7.31384 9.76766C7.42175 9.6809 7.51109 9.57329 7.57652 9.45126L9.51027 5.88501C9.66652 5.93314 9.8284 5.96688 9.99965 5.96688C10.1709 5.96688 10.3328 5.93314 10.4884 5.88501L12.4221 9.45126C12.5559 9.69876 12.779 9.87814 13.0503 9.95626C13.1829 9.99538 13.322 10.0072 13.4593 9.99096C13.5966 9.97474 13.7292 9.93083 13.849 9.86188L16.0565 8.60876C16.2171 8.80814 16.419 8.97126 16.6534 9.07939L15.2753 14.0625ZM17.3496 8.70626C16.7246 8.70626 16.2153 8.19751 16.2153 7.57188C16.2153 6.94626 16.724 6.43751 17.3496 6.43751C17.9753 6.43751 18.484 6.94626 18.484 7.57188C18.484 8.19751 17.9753 8.70626 17.3496 8.70626Z" fill="#020617"/>
								<path d="M9.99957 9.87134C9.1277 9.87134 8.41895 10.7032 8.41895 11.7257C8.41895 12.7482 9.1277 13.5801 9.99957 13.5801C10.8714 13.5801 11.5802 12.7482 11.5802 11.7257C11.5802 10.7032 10.8714 9.87134 9.99957 9.87134ZM9.99957 13.0488C9.42082 13.0488 8.9502 12.4551 8.9502 11.7257C8.9502 10.9963 9.42082 10.4026 9.99957 10.4026C10.5783 10.4026 11.0489 10.9963 11.0489 11.7257C11.0489 12.4551 10.5783 13.0488 9.99957 13.0488Z" fill="#020617"/>
							</svg>
							<?php esc_html_e( 'Upgrade To Pro!', 'product-tabs-manager' ); ?>
						</a>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</form>

<?php
require_once WCPTM_TEMPLATE_PATH . 'upgrade-to-pro.php';