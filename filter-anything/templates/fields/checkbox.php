<?php

use Vardaam\FilterAnything\Helpers;

/** @var array $filter */

if ( carbon_get_post_meta( /** @var WP_Post $directory */ $directory->ID, 'show_labels_as_placeholders' ) ) : ?>
    <label for=""><?php _e( $filter['label'] ); ?>:</label>
<?php endif; ?>
<div>
	<?php $choices = Helpers::get_choices_array( $filter ); ?>
	<?php if ( ! empty( $choices ) && is_array( $choices ) ) : ?>
		<?php foreach ( $choices as $k => $v ) : ?>
			<?php
			$checked = '';
			if ( is_array( /** @var array|string $selectedValue */ $selectedValue ) && in_array( $k, $selectedValue ) ) :
				$checked = 'checked="checked"';
			else :
				if ( $k == $selectedValue ) {
					$checked = 'checked="checked"';
				}
			endif;
			?>
            <label>
                <input
                        type="checkbox"
                        name="<?php esc_attr_e( $filter['name'] ) . esc_attr_e( '[]' ); ?>"
                        value="<?php esc_attr_e( $k ); ?>"
					<?php echo $checked; ?>
                />
				<?php _e( $v ); ?>
            </label>
		<?php endforeach; ?>
	<?php else: ?>
        <label><input type="checkbox" name="<?php esc_attr_e( $filter['name'] ); ?>" value=""
                      disabled/><?php _e( 'Select' ); ?></label>
	<?php endif; ?>
</div>
