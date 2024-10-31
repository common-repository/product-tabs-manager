<?php
/**
 * Export / Import Settings.
 *
 * @since 1.0.0
 * @package WooCommerceProductTabsManager
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wcptm-upcoming wcptm-pro">
	<div>
		<h1><?php esc_html_e( 'Export / Import Tabs', 'product-tabs-manager' ); ?></h1>
		<p><?php esc_html_e( 'Easily export and import tab settings to backup configurations or transfer them between sites', 'product-tabs-manager' ); ?></p>
	</div>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<div class="">
			<div class="column-1">
				<div class="bk-card">
					<div class="bk-card__header">
						<h2 class=""><?php echo esc_html__( 'Export Tabs', 'product-tabs-manager' ); ?></h2>
					</div>
					<div class="bk-card__body form-inline !tw-px-3 wcptm-all-tab-list">
						<div class="tw-flex tw-gap-2 tw-items-center">
							<h3><?php esc_html_e( 'Select Option:', 'product-tabs-manager' ); ?></h3>
							<div class="tw-flex tw-gap-4">
								<label class="tw-text-sm">
									<input type="radio" name="wcptm_export_tabs">
									<?php esc_html_e( 'All', 'product-tabs-manager' ); ?>
								</label>
								<label class="tw-text-sm">
									<input type="radio" name="wcptm_export_tabs">
									<?php esc_html_e( 'Active', 'product-tabs-manager' ); ?>
								</label>
								<label class="tw-text-sm">
									<input type="radio" name="wcptm_export_tabs">
									<?php esc_html_e( 'In-Active', 'product-tabs-manager' ); ?>
								</label>
							</div>
						</div>
						<div class="tw-pt-3">
							<?php wp_nonce_field( 'wcptm_export' ); ?>
							<input name="action" value="wcptm_export" type="hidden">
							<button type="submit" class="button button-primary"><?php echo esc_html__( 'Export Tabs', 'product-tabs-manager' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<div class="">
			<div class="column-1">
				<div class="bk-card">
					<div class="bk-card__header">
						<h2 class=""><?php echo esc_html__( 'Export Tabs', 'product-tabs-manager' ); ?></h2>
					</div>
					<div class="bk-card__body form-inline !tw-p-4 wcptm-all-tab-list">
						<div class="tw-flex tw-gap-2 tw-items-center">
							<h3><?php esc_html_e( 'Upload CSV File:', 'product-tabs-manager' ); ?></h3>
							<label>
								<input name="upload" type="file" required="required" accept="text/csv">
							</label>
						</div>
						<div class="tw-pt-3">
							<?php wp_nonce_field( 'wcptm_import' ); ?>
							<input name="action" value="wcptm_import" type="hidden">
							<button type="submit" class="button button-primary"><?php echo esc_html__( 'Import CSV', 'product-tabs-manager' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="wcptm-upcoming-pro-features tw-flex tw-justify-center tw-items-center">
		<h3 class="tw-text-[#ff0000] tw-text-2xl"><?php esc_html_e( 'Upcoming Pro Features', 'product-tabs-manager' ); ?></h3>
	</div>
</div>
<?php
require_once WCPTM_TEMPLATE_PATH . 'upgrade-to-pro.php';
