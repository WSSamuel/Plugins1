<?php
/**
 * This file controls programing logic for the the output.
 *
 * printf('<pre>%s</pre>',print_r($post_formats,true));
 */
global $post;

//First define descriptive text for each format
$format_text = array(
    'standard'  => __('This is the standard, all-purpose format. Perfect for most blog posts.', 'betterformats'),
    'aside'     => __('A text-only post with no visible title. It is similar to a Facebook post.', 'betterformats'),
    'audio'     => __('Post an audio snippet or podcast, with optional text.', 'betterformats'),
    'chat'      => __('Post a chat transcript.', 'betterformats'),
    'gallery'   => __('Post an image gallery, with an optional description.', 'betterformats'),
    'image'     => __('Post a single, large image with optional text.', 'betterformats'),
    'link'      => __('Post a web link/url with an optional description.', 'betterformats'),
    'quote'     => __('Post a simple quote and, optionally, an author or source.', 'betterformats'),
    'status'    => __('A very short, text-only format. Similar to a Twitter post.', 'betterformats'),
    'video'     => __('Post a single video with an optional description.', 'betterformats'),
);

//See post_format_meta_box() for reference
if ( current_theme_supports('post-formats') && post_type_supports($post->post_type, 'post-formats') )
{
    // Get all formats that this theme supports
    $post_formats = get_theme_support('post-formats') ? : array();

    if ( is_array( $post_formats[0] ) )
    {
        // Get the current posts format, or default to 'standard'
        $current_format = get_post_format($post->ID) ? : 'standard';

        // If current format isn't in theme-supported array, add it
        if ( $current_format && !in_array( $current_format, $post_formats[0] ) )
        {
            $post_formats[0][] = $current_format;
        }

        // If standard is already there, move it to the front of the array
        $stdkey = array_search( 'standard', $post_formats[0] );
        unset( $post_formats[0][$stdkey] );
        array_unshift( $post_formats[0], 'standard' );
    }

}
?>
<!-- begin template -->
<div id="bf-info" class="clearfix <?php echo (get_option('bf-hide-verbose')) ? 'no-verbose' : ''; ?>">

    <?php
    $i = 0;
    foreach ($post_formats[0] as $format) {
        $i++; ?>

    <div class="bf-opt clearfix <?php echo ($i % 2 == 0) ? 'even' : 'odd'; ?> <?php echo ($current_format === $format)?'selected':''; ?>" data-format="<?php echo esc_attr( $format ); ?>">
        <a href="#" onclick="return false;">
            <div class="bf-icon bf-<?php echo esc_attr( $format ); ?>"></div>
            <div class="bf-text">
                <div class="bf-title"><?php echo esc_html( get_post_format_string($format) ); ?></div>
                <div class="bf-descr"><?php echo esc_html( $format_text[$format] ); ?></div>
            </div>
        </a>
        <!--<a class="bf-help thickbox" href="<?php echo betterformats_URL ?>/admin/pages/betterformats-help.php/?TB_iframe=true&width=800&height=550">?</a>-->
        <a class="bf-help thickbox" href="#TB_inline?width=800&height=550&inlineId=bf-help-<?php echo esc_attr( strtolower( $format ) ); ?>">?</a>
    </div>

    <?php } //foreach ?>

    <div class="bf-intro">
        <?php _e('Post formats are a simple way to change how a post is displayed by your <a href="http://codex.wordpress.org/Post_Formats">your theme</a>.', 'betterformats'); ?>
    </div>

</div>
