<?php if ( ! empty( $args['id'] ) && $directory = get_post( sanitize_text_field( $args['id'] ) ) ) :
	if ( $directory->post_status === 'publish' ) :
		$css = carbon_get_post_meta( $directory->ID, 'quick_css' );
		if ( ! empty( $css ) ) :
			wp_add_inline_style( 'wfa-style', $css );
		endif;
		?>
        <div class="wfa-directory">
            <div class="wfa-directory-header">
                <h3><?php esc_html_e( get_the_title( $directory ) ); ?></h3>
            </div>
			<?php
			$directory_type = carbon_get_post_meta( $directory->ID, 'directory_type' );
			$filters        = ( 'posts_directory' === $directory_type )
				? carbon_get_post_meta( $directory->ID, 'post_filters' )
				: carbon_get_post_meta( $directory->ID, 'user_filters' );
			?>
            <div class="wfa-directory-container"
                 style="display: <?php echo 'sidebar_filter' === carbon_get_post_meta( $directory->ID, 'filter_layout' ) && false === empty( $filters ) ? 'flex' : 'block'; ?>">
				<?php include_once plugin_dir_path( __FILE__ ) . 'tp_filters.php'; ?>
				<?php if ( carbon_get_post_meta( $directory->ID, 'show_result_on_load' ) ) : ?>
                    <script>
                        function docReady(fn) {
                            // see if DOM is already available
                            if (document.readyState === "complete" || document.readyState === "interactive") {
                                // call on next available tick
                                setTimeout(fn, 1);
                            } else {
                                document.addEventListener("DOMContentLoaded", fn);
                            }
                        }

                        docReady(function () {
                            jQuery('#wfa-filter-form-' + '<?php echo (int) $directory->ID; ?>').trigger('submit');
                        });
                    </script>
				<?php endif; ?>
                <div class="wfa-directory-content"
					<?php if ( 'sidebar_filter' === carbon_get_post_meta( $directory->ID, 'filter_layout' ) && false === empty( $filters ) ) : ?>
                        style="
                                width: <?php echo ( 100 - carbon_get_post_meta( $directory->ID, 'sidebar_width' ) ) . '%'; ?>;
                                padding: 0 0 0 20px;
                                "
					<?php endif; ?>>
					<?php include_once plugin_dir_path( __FILE__ ) . 'tp_filter_sorting.php'; ?>
                    <div class="wfa-directory-errors"></div>
                    <div class="wfa-directory-results"
                         style="grid-template-columns: repeat(<?php echo carbon_get_post_meta( $directory->ID, 'items_per_line' ); ?>, 1fr);"></div>
                    <div class="wfa-directory-loader">
                        <img src="<?php echo plugins_url( '../assets/loader.gif', __FILE__ ); ?>" alt="loading...">
                    </div>
                    <div class="wfa-directory-result-actions">
                        <button type="button"
                                class="wfa-directory-load-more-results"><?php _e( carbon_get_post_meta( $directory->ID, 'load_more_button_text' ) ); ?></button>
                    </div>
                </div>
            </div>
        </div>
	<?php endif;
endif; ?>