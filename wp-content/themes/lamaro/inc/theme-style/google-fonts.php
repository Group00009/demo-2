<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Including google fonts
 */

if ( !function_exists('lamaro_get_google_fonts') ) {

	function lamaro_get_google_fonts($css = array()) {

		$google_subsets = $google_fonts = array();
		foreach ( array('font_main', 'font_headers', 'font_subheaders') as $type ) {

			$typefix = str_replace('_', '-', $type);

			$font = fw_get_db_settings_option( $typefix );
			$font_weights = fw_get_db_settings_option( $typefix . '-weights' );

			if ( !empty($font) ) {

				$font['variation'] = str_replace('regular', '400', $font['variation']);
				$google_fonts[$font['family']][$font['variation']] = true;

				if ( !empty($font_weights) ) {

					$lamaro_items = explode(',', $font_weights);
					foreach ( $lamaro_items as $item) {

						$google_fonts[$font['family']][$item] = true;
					}
				}

				$google_subsets[$font['subset']] = true;

				$css[$type] = esc_attr($font['family']);
			}
		}

		if ( !empty($google_fonts) ) {

			$family = $subset = '';
			foreach ( $google_fonts as $font => $styles ) {

				if ( !empty($family) ) $family .= "%7C";
			    $family .= str_replace( ' ', '+', $font ) . ':' . implode( ',', array_keys($styles) );
			}

			foreach ( $google_subsets as $subset_ => $val ) {

				if ( !empty($subset) ) $subset .= ",";
			    if ( !empty($subset_) ) $subset .= $subset_;
			}

			$query_args = array( 'family' => $family, 'subset' => $subset );
			wp_enqueue_style( 'lamaro_google_fonts', esc_url( add_query_arg( $query_args, '//fonts.googleapis.com/css' ) ), array(), null );
		}

		return $css;
	}
}


