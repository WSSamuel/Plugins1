<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

defined( 'ABSPATH' ) || exit;

class Haru_Video_Tags_Widget extends Haru_Vidi_Widget {

    /**
     * Constructor.
     */

    public function __construct() {
        $this->widget_cssclass    = 'widget-video-tags';
        $this->widget_description = esc_html__( 'Widget display video tags.', 'haru-vidi' );
        $this->widget_id          = 'haru_widget_video_tags';
        $this->widget_name        = esc_html__( 'Haru Video Tags', 'haru-vidi' );
        $this->cached             = false;
        $this->settings = array(
            'title'         => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Video tags', 'haru-vidi' ),
                'label' => esc_html__( 'Title', 'haru-vidi' )
            ),
            'style'         => array(
                'type'    => 'select',
                'std'     => 'default',
                'label'   => esc_html__( 'Style', 'haru-vidi' ),
                'options' => array(
                    'default' => esc_html__( 'Default', 'haru-vidi' ),
                )
            ),
        );

        parent::__construct();
    }
    
    public function widget( $args, $instance ) {
        global $wp_query;

        ob_start();
        extract( $args );

        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $style          = isset( $instance['style'] ) ? $instance['style'] : $this->settings['style']['std'];

        $current_taxonomy = $this->get_current_taxonomy( $instance );

        if ( empty( $instance['title'] ) ) {
            $taxonomy          = get_taxonomy( $current_taxonomy );
            $instance['title'] = $taxonomy->labels->name;
        }

        echo $before_widget;

            if ( $title ) echo $before_title . $title . $after_title;

            echo '<div class="tagcloud ' . esc_attr( $style ) . '">';

            wp_tag_cloud(
                array(
                    'taxonomy'                  => $current_taxonomy,
                    'topic_count_text_callback' => array( $this, 'topic_count_text' ),
                )
            );

            echo '</div>';

        echo $after_widget;

        $content = ob_get_clean();
        echo $content;
    }

    /**
     * Return the taxonomy being displayed.
     *
     * @param  object $instance Widget instance.
     * @return string
     */
    public function get_current_taxonomy( $instance ) {
        return 'video_tag';
    }

    /**
     * Returns topic count text.
     *
     * @param int $count Count text.
     * @return string
     */
    public function topic_count_text( $count ) {
        /* translators: %s: video count */
        return sprintf( _n( '%s video', '%s videos', $count, 'haru-vidi' ), number_format_i18n( $count ) );
    }

}
if ( !function_exists('haru_register_widget_video_tags') ) {
    function haru_register_widget_video_tags() {
        register_widget( 'Haru_Video_Tags_Widget' );
    }
    add_action( 'widgets_init', 'haru_register_widget_video_tags' );
}