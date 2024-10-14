<article id="post-<?php echo esc_attr( /** @var WP_Post $entry */ $entry->ID ); ?>" <?php post_class( '', $entry->ID ); ?>>
    <header>
        <h4><?php echo get_the_title( $entry->ID ); ?></h4>
    </header>
	<?php $excerpt = get_the_excerpt( $entry->ID ); ?>
	<?php if ( ! empty( $excerpt ) ) : ?>
	<section>
		<p><?php echo wp_kses_data( $excerpt ); ?></p>
	</section>
	<?php endif; ?>
    <a href="<?php echo get_the_permalink( $entry->ID ); ?>" target="_blank"><?php _e( 'Read more' ) ?></a>
</article>