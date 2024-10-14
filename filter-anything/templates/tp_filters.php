<?php

use Vardaam\FilterAnything\Helpers;

/** @var WP_Post $directory */

$submitUrl = ( ! empty( $args['submit_url'] ) && filter_var( $args['submit_url'], FILTER_VALIDATE_URL ) ) ? $args['submit_url'] : ''; ?>
<div
        class="wfa-filter-form-container"
        id="wfa-filter-form-container-<?php echo (int) $directory->ID; ?>"
	<?php if ( 'sidebar_filter' === carbon_get_post_meta( $directory->ID, 'filter_layout' ) ) : ?>
        style="
                width: <?php echo carbon_get_post_meta( $directory->ID, 'sidebar_width' ) . '%'; ?>;
                padding: 0 20px 0;
                border-right: 1px solid #ccc;
		<?php if ( empty( $filters ) ) {
			esc_attr_e( 'display: none;' );
		} ?>
                "
	<?php else: ?>
        style="
                border-bottom: 1px solid #ccc;
                margin-bottom: 30px;
		<?php if ( empty( $filters ) ) {
			esc_attr_e( 'display: none;' );
		} ?>
                "
	<?php endif; ?>
>
    <form
            action="<?php echo ! empty( $submitUrl ) ? $submitUrl : ''; ?>"
            method="<?php echo ! empty( $submitUrl ) ? 'get' : 'post'; ?>"
            id="wfa-filter-form-<?php echo (int) $directory->ID; ?>"
            class="wfa-filter-form <?php empty( $submitUrl ) ? esc_attr_e( 'wfa-filter-ajax-submit' ) : esc_attr_e( '' ); ?>"
    >
		<?php if ( empty( $submitUrl ) ) : ?>
            <input type="hidden" name="action" value="get_directory_results">
            <input type="hidden" name="directory" value="<?php echo (int) $directory->ID; ?>">
            <input type="hidden" name="nonce"
                   value="<?php echo wp_create_nonce( "directory_nonce_" . (int) $directory->ID ); ?>">
		<?php endif; ?>

		<?php if ( false === empty( $filters ) ) : ?>
			<?php if ( 'sidebar_filter' === carbon_get_post_meta( $directory->ID, 'filter_layout' ) ) : ?>
				<?php include_once plugin_dir_path( __FILE__ ) . 'tp_filter_actions.php'; ?>
			<?php endif; ?>

			<?php foreach ( $filters as $filter ) : ?>
                <div class="wfa-width-<?php 'sidebar_filter' === carbon_get_post_meta( $directory->ID, 'filter_layout' ) ? esc_attr_e( 'full' ) : esc_attr_e( $filter['width'] ); ?>">
                    <div class="wfa-form-group">
						<?php if ( false === carbon_get_post_meta( $directory->ID, 'show_labels_as_placeholders' ) ) : ?>
                            <label for="<?php esc_attr_e( $filter['name'] ); ?>"><?php _e( $filter['label'] ); ?></label>
						<?php endif; ?>
						<?php $selectedValue = Helpers::get_sanitized_selected_value( $filter ); ?>
						<?php include plugin_dir_path( __FILE__ ) . '/fields/' . $filter['input_type'] . '.php'; ?>
                    </div>
                </div>
			<?php endforeach; ?>

			<?php if ( 'horizontal_full_width_filter' === carbon_get_post_meta( $directory->ID, 'filter_layout' ) ) : ?>
				<?php include_once plugin_dir_path( __FILE__ ) . 'tp_filter_actions.php'; ?>
			<?php endif; ?>
		<?php endif; ?>
    </form>
</div>

