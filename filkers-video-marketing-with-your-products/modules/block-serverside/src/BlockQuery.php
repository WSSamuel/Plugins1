<?php

namespace Filkers\Blocks;

use WP_Query;

class BlockQuery extends WP_Query {

	public function __construct( $query = '' ) {
		if ( ! empty( $query ) ) {
			$this->init();
			$this->query      = wp_parse_args( $query );
			$this->query_vars = $this->query;
			$this->parse_query_vars();
		}
	}

	public function get_cached_posts( $transient_version = '' ) {
		$hash            = md5( wp_json_encode( $this->query_vars ) );
		$transient_name  = 'wc_blocks_query_' . $hash;
		$transient_value = get_transient( $transient_name );

		if ( isset( $transient_value, $transient_value['version'], $transient_value['value'] ) && $transient_value['version'] === $transient_version ) {
			return $transient_value['value'];
		}

		$results = $this->get_posts();

		set_transient(
			$transient_name,
			array(
				'version' => $transient_version,
				'value'   => $results,
			),
			DAY_IN_SECONDS * 30
		);

		return $results;
	}
}


