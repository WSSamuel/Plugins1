<?php

/**
 * Class Weather_Forecast_Widget
 */
class Weather_Forecast_Widget extends WP_Widget {

    function __construct() {

        $widget_ops = array(
            'classname' => 'weather_forecast',
            'description' => __( 'This widget is to display weather.', 'weather-forecast' ),
            'customize_selective_refresh' => true,
        );
        $control_ops = array(
            'width' => 400,
            'height' => 350,
        );
        parent::__construct( 'weather_forecast', __( 'Weather Forcast', 'weather-forecast' ), $widget_ops, $control_ops );

    }

    /*-------------------------------------------------------
    *				Front-end display of widget
    *-------------------------------------------------------*/

    function widget( $args, $instance ) {

        extract( $args );
        $title                    = apply_filters( 'widget_title', $instance['title'] );
        $location_weather_id      = $instance['location_weather_id'];
        $location_weather_city    = $instance['location_weather_city'];
        $location_weather_country = $instance['location_weather_country'];

        echo $before_widget;


        $output = '';
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        $output .= '<div class="weather-forecast-widget">';
        $output .= '<div id="weather-forecast-' . $location_weather_id . '"></div>';
        $output .= '</div><!--/#widget-->';
        $output .= "<script>

        /*
         * Location weather
         */
         jQuery(document).ready(function() {
                loadWeatherWidget$location_weather_id('$location_weather_city','$location_weather_country'); //@params location, woeid
            });

            function loadWeatherWidget$location_weather_id(location, woeid) {
                jQuery.simpleWeather({
                    location: location,
                    woeid: woeid,
                    unit: 'c',
                    success: function(weather) {
                      html = '<ul class=\"current-weather\" style=\"background-image:url(\''+weather.image+'\');\">';
                      html += '<li><h6>'+weather.city+' Today</h5></li>';
                      html += '<li>'+weather.temp+' '+weather.units.temp+'</li>';
                      html += '<li>'+weather.currently+'</li>';
                      html += '<li>High: '+weather.high+'| Low: '+weather.low+'</li>';
                      html += '<li>Humidity: '+weather.humidity+'</li>';
                      html += '<li>Visbility: '+weather.visibility+'</li>';
                      html += '<li>Sunrise: '+weather.sunrise+'</li>';
                      html += '<li>Sunset: '+weather.sunset+'</li>';
                      html += '</ul>';
                      for(var i=0;i<weather.forecast.length;i++) {
                      html += '<div class=\"weather-forecast-days\">';
                        html += '<figure>';
                        html += '<img src=\"'+weather.forecast[i].thumbnail+'\"/>';
                        html += '</figure>';
                        html += '<ul class=\"forcast-day day-'+i+'\">';
                        html += '<li>'+weather.forecast[i].day+'</li>';
                        html += '<li>'+weather.forecast[i].date+'</li>';
                        html += '<li>'+weather.forecast[i].text+'</li>';
                        html += '<li>High: '+weather.forecast[i].high +' Low: '+ weather.forecast[i].low +'</li>';
                        html += '</ul>';
                        html += '</div>';
                      }

                      jQuery('#weather-forecast-$location_weather_id').html(html);

                    },
                    error: function(error) {
                      jQuery('#weather-forecast-$location_weather_id').html('<p>'+error.message+'</p>');
                    }
                  });
                }
            </script>";


        echo $output;

        echo $after_widget;

    }


    function update( $new_instance, $old_instance ) {
        $instance                             = $old_instance;
        $instance['title']                    = strip_tags( $new_instance['title'] );
        $instance['location_weather_id']      = strip_tags( $new_instance['location_weather_id'] );
        $instance['location_weather_city']    = strip_tags( $new_instance['location_weather_city'] );
        $instance['location_weather_country'] = strip_tags( $new_instance['location_weather_country'] );

        return $instance;
    }

    function form( $instance ) {
        $defaults = array(
            'title'                    => '',
            'location_weather_id'      => 1,
            'location_weather_city'    => 'london',
            'location_weather_country' => 'uk',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'weather-forecast' ); ?>
                <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       class="widefat"
                       type="text"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                       value="<?php echo $instance['title']; ?>"/>
            </label>
        </p>
        <p>
            <label
                for="<?php echo esc_attr( $this->get_field_id( 'location_weather_id' ) ); ?>"><?php _e( 'ID', 'weather-forecast' ); ?>
                <input id="<?php echo esc_attr( $this->get_field_id( 'location_weather_id' ) ); ?>"
                       class="widefat"
                       type="text"
                       name="<?php echo esc_attr( $this->get_field_name( 'location_weather_id' ) ); ?>"
                       value="<?php echo $instance['location_weather_id']; ?>"/>
            </label>
        </p>
        <p>
            <label
                for="<?php echo esc_attr( $this->get_field_id( 'location_weather_city' ) ); ?>"><?php _e( 'City', 'weather-forecast' ); ?>
                <input id="<?php echo esc_attr( $this->get_field_id( 'location_weather_city' ) ); ?>"
                       class="widefat"
                       type="text"
                       name="<?php echo esc_attr( $this->get_field_name( 'location_weather_city' ) ); ?>"
                       value="<?php echo esc_attr( $instance['location_weather_city'] ); ?>"/>
            </label>
        </p>
        <p>
            <label
                for="<?php echo esc_attr( $this->get_field_id( 'location_weather_country' ) ); ?>"><?php _e( 'Country', 'weather-forecast' ); ?>
                <input id="<?php echo esc_attr( $this->get_field_id( 'location_weather_country' ) ); ?>"
                       class="widefat"
                       type="text"
                       name="<?php echo esc_attr( $this->get_field_name( 'location_weather_country' ) ); ?>"
                       value="<?php echo esc_attr( $instance['location_weather_country'] ); ?>"/>
            </label>
        </p>
        <?php
    }
}

register_widget( 'Weather_Forecast_Widget' );