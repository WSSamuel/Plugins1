<article>
    <header>
        <h4><?php echo esc_html( /** @var WP_User $entry */ $entry->display_name ); ?></h4>
        <h5><?php echo "Member Since: " . date( 'F j, Y', strtotime( get_the_author_meta( 'registered', $entry->ID ) ) ); ?></h5>
    </header>
    <section>
		<?php $description = $entry->description; ?>
		<?php if ( ! empty( $description ) ) : ?>
            <p><?php echo wp_kses_data( $description ); ?></p>
		<?php endif; ?>
    </section>
    <a href="<?php echo get_author_posts_url( $entry->ID ); ?>" target="_blank"><?php _e( 'Read more' ); ?></a>
</article>