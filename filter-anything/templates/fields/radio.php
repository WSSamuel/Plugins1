<div>
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
                <label>
                    <input
                            type="radio"
                            name="<?php esc_attr_e( $filter['name'] ); ?>"
                            value="<?php esc_attr_e( $k ); ?>"
						<?php /** @var array|string $selectedValue */
						echo $selectedValue !== '' && $k == $selectedValue ? 'checked="checked"' : ''; ?>
                    />
					<?php _e( $v ); ?>
                </label>
			<?php endforeach; ?>
		<?php else: ?>
            <label><input type="radio" name="<?php esc_attr_e( $filter['name'] ); ?>" value=""
                          disabled/><?php _e( 'Select' ); ?></label>
		<?php endif; ?>
    </div>
</div>
