<?php
/**
 * Agnosia_Bootstrap_Carousel_Loader
 *
 * Loads Agnosia_Bootstrap_Carousel to display a new carousel when needed. 
 *
 * @package Agnosia_Bootstrap_Carousel
 * @version 1.0
 * @since   1.0
 */
class Agnosia_Bootstrap_Carousel_Loader {

	function __construct() {
		add_filter( 'post_gallery', array( $this, 'gallery_shortcode' ), 10, 4 );
		add_filter( 'jetpack_gallery_types', array( $this, 'gallery_types' ) );
	}

	function gallery_shortcode( $output = '', $atts, $content = false, $tag = false ) {
		$agnosia_bootstrap_carousel = new Agnosia_Bootstrap_Carousel( $atts );
		return $agnosia_bootstrap_carousel->__get( 'output' );
	}

	function gallery_types( $gallery_types ) {
		$gallery_types['carousel'] = 'Bootstrap Carousel';
		return $gallery_types;
	}

}
