<?php
    /**
     * @TODO: This is not yet implemented.
     *
     * This is partially based on /wp-admin/media-upload.php to ensure that necessary WordPress
     * admin functionality is loaded and available for the page, but without the WordPress admin
     * UI. This is particularly handy for use with ThickBox's iframes.
     *
     * wp-admin/admin-post.php + add_action + iframe_header() + echo body + iframe_footer(); I can't say it any simpler.
     */

    $format_data = array(
        'standard' => array(
            'title'   => __( 'Standard', 'nouveau' ),
            'descr'   => __( 'Most blog posts will use the standard format, which is the default for all new WordPress posts. This is the most flexible type of post format, and usually includes a title, author, text, optional images or embeded media (like videos), and a list of associated tags and categories.', 'nouveau' ),
            'usage'   => __( 'There are no special rules for working with the standard post format. This format gives you maximum flexibility and a post that uses it can be edited like a document in your favorite office software.', 'nouveau' ),
            'example' => 0,
            'sample'  => 0,
        ),
        'aside'    => array(
            'title'   => __( 'Aside', 'nouveau' ),
            'descr'   => __( "This is similar to the <em>standard</em> format, except that it doesn't include a title. This is generally used for medium sized, text-only posts. It is somewhat similar to a Facebook post.", 'nouveau' ),
            'usage'   => __( 'You may specify a title, but the title will not be displayed on the webpage.', 'nouveau' ),
            'example' => 0,
            'sample'  => 0,
        ),
        'audio'    => array(
            'title'   => __( 'Audio', 'nouveau' ),
            'descr'   => __( "This This format is ideal for podcasts. This format will show a title, the an embedded audio snippet or download link (from a service of your choice), and some optional text if you choose to add some. ", 'nouveau' ),
            'usage'   => __( 'Although this type is mostly treated like the <em>standard</em> format, additional features are available.', 'nouveau' ),
            'example' => 0,
            'sample'  => '<your embed link here>\r\nYour description here.',
        ),
    );
?>

<div id="bf-help" style="display:none;">
    <div id="bf-help-standard">
        <h2>
            Standard Format
        </h2>
    </div>
    <div id="bf-help-aside">
        <h2>
            Aside Format
        </h2>
    </div>
    <div id="bf-help-audio">
        <h2>
            Audio Format
        </h2>
    </div>
</div>