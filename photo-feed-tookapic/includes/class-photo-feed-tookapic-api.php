<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp-locomotive.com/plugins/tookapic/
	 * @since      0.1.0
 *
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.0
 * @package    photo-feed-tookapic
 * @subpackage photo-feed-tookapic/includes
 * @author     Rafał Osiński <hello@wp-locomotive.com>
 */
class PhotoFeedTookapic_Api {

	/**
	 * @var
	 */
	private $instance;
	/**
	 * @var
	 */
	private $args;
	/**
	 * @var
	 */
	private $unserializedJSON;
	/**
	 * @var
	 */
	private $minutesFromLastApiSave;
	/**
	 * @var
	 */
	private $dataTable;

	/**
	 * @var
	 */
	private $refreshTime;


	/**
	 * PhotoFeedTookapic_Api constructor.
	 */
	public function __construct() {
		$this->refreshTime = 2;
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.1.0
	 */
	public function setArgs( $args ) {
		$this->args = $args;
	}

	/**
	 * @param $instance
	 */
	public function setInstance( $instance ) {
		$this->instance = $instance;
	}

	/**
	 * @param $data
	 */
	public function setDataTable( $data ) {
		$this->dataTable = $data;
	}

	/**
	 * @param mixed $unserializedJSON
	 */
	public function setUnserializedJSON( $unserializedJSON ) {
		$this->unserializedJSON = $unserializedJSON;
	}

	/**
	 * @param mixed $minutesFromLastApiSave
	 */
	public function setMinutesFromLastApiSave( $minutesFromLastApiSave ) {
		$this->minutesFromLastApiSave = $minutesFromLastApiSave;
	}


	/**
	 * @return bool
	 */
	public function checkLastRequest() {

		if ( null !== $this->dataTable && false !== $this->dataTable ) {

			foreach ( $this->dataTable as $id => $item ):

				if ( $id === $this->args[ 'widget_id' ] ) {

					$now = date( "d-m-Y H:i:s", time() );
					$old = date( "d-m-Y H:i:s", $item[ 'last_download_datetime' ] );

					$to_time   = strtotime( $now );
					$from_time = strtotime( $old );

					$this->setMinutesFromLastApiSave( round( abs( $to_time - $from_time ) / 60 ) );

				}

			endforeach;

			return $this->minutesFromLastApiSave;
		}

		return false;

	}

	/**
	 * @return array|mixed|object
	 */
	public function getUnserializedContentFromApi() {
		$json = file_get_contents( "https://api.tookapic.com/users/" . $this->instance[ 'widget_field_photo_feed_tookapic_username' ] . "/photos?sort=" . $this->instance[ 'widget_field_photo_feed_tookapic_sortby' ] );
		$this->setUnserializedJSON( json_decode( $json ) );

		return $this->unserializedJSON;
	}


	/**
	 * @param $tableData
	 */
	public function add( $tableData ) {
		add_option( 'widget_photos_feed_tookapic_data', $tableData );
	}


	/**
	 * update database by current dataTable value
	 */
	public function update() {
		update_option( 'widget_photos_feed_tookapic_data', $this->dataTable );
	}

	/**
	 * @return mixed
	 */
	public function getUserPhotoList() {

		$this->setDataTable( get_option( 'widget_photos_feed_tookapic_data' ) );

		if ( false === $this->dataTable ) {

			$this->getUnserializedContentFromApi();

			$tableData = array();

			$tableData [ $this->args[ 'widget_id' ] ] = array(
				'md5'                    => md5( 'null' ),
				'last_download_datetime' => time(),
				'data'                   => $this->unserializedJSON,
			);

			$this->add( $tableData );

			return $tableData[ $this->args[ 'widget_id' ] ][ 'data' ];

		} else {

			if ( null === $this->checkLastRequest() ) {

				$this->getUnserializedContentFromApi();

				$this->dataTable[ $this->args[ 'widget_id' ] ] = array(
					'md5'                    => md5( 'null' ),
					'last_download_datetime' => time(),
					'data'                   => $this->unserializedJSON,
				);

				$this->update();

				return $this->dataTable[ $this->args[ 'widget_id' ] ][ 'data' ];

			} else if ( $this->checkLastRequest() >= $this->refreshTime ) {

				$this->getUnserializedContentFromApi();

				$this->dataTable[ $this->args[ 'widget_id' ] ] = array(
					'md5'                    => md5( 'null' ),
					'last_download_datetime' => time(),
					'data'                   => $this->unserializedJSON,
				);

				$this->update();

				return $this->dataTable[ $this->args[ 'widget_id' ] ][ 'data' ];

			} else {

				return $this->dataTable[ $this->args[ 'widget_id' ] ][ 'data' ];

			}

		}

	}

}
