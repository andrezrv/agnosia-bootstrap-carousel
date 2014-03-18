<?php
/**
 * Agnosia_Bootstrap_Carousel
 *
 * Display a Bootstrap Carousel based on selected images and their titles and
 * descriptions. You need to include the Bootstrap CSS and Javascript files on
 * your own; otherwise the class will not work.
 *
 * @package Agnosia_Bootstrap_Carousel
 * @version 1.0
 * @since   1.0
 */
class Agnosia_Bootstrap_Carousel {

	private $attributes = array();
	private $posts = array();
	private $container_style = '';
	private $item_style = '';
	private $output = '';

	function __construct( $atts ) {
		$this->attributes = $this->obtain_attributes( $atts );
		$this->output = '';
		if ( $this->validate_data() ) {
			do_action( 'agnosia_bootstrap_carousel_before_init' );
			$this->container_style = $this->get_container_style();
			$this->item_style      = $this->get_item_style();
			$this->posts           = $this->get_posts();
			$this->output          = $this->get_output();
			do_action( 'agnosia_bootstrap_carousel_init' );
		}
	}

	public function __get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->$property;
		}
	}

	public function __set( $property, $value ) {
		if ( property_exists( $this, $property ) ) {
			$this->$property = $value;
		}
		return $this;
	}

	/**
	 * Obtain shortcode attributes.
	 *
	 * @return array Mixed array of shortcode attributes.
	 */
	private function obtain_attributes( $atts ) {
		// Define data by given attributes.
		$attributes = shortcode_atts( array(
			/* Ids for the images to use. */
			'ids' => false,
			/* Type of gallery. If it's not "carousel", nothing will be done. */
			'type' => '',
			/* Alternative appearing order of images. */
			'orderby' => '',
			/* Any name. String will be sanitize to be used as HTML ID. Recomended 
			 * when you want to have more than one carousel in the same page. 
			 * Default: agnosia-bootstrap-carousel. */
			'name' => 'agnosia-bootstrap-carousel',
			/* Carousel container width, in px or % */
			'width' => '', 
			/* Carousel item height, in px or % */
			'height' => '',
			/* Accepted values: before-inner, after-inner, after-control, false.
			 * Default: before-inner. */
			'indicators' => 'before-inner',
			/* Accepted values: true, false. Default: true. */
			'control' => 'true',
			/* The amount of time to delay between automatically cycling an item.
			 * If false, carousel will not automatically cycle. */
			'interval' => 5000,
			/* Pauses the cycling of the carousel on mouseenter and resumes the
			 * cycling of the carousel on mouseleave. */
			'pause' => 'hover',
			/* Define tag for image title. Default: h4. */
			'titletag' => 'h4',
			/* Show or hide image title. Set false to hide. Default: true. */
			'title' => 'true',
			/* Type of link to show if "title" is set to true. */
			'link' => '',
			/* Show or hide image text. Set false to hide. Default: true. */
			'text' => 'true',
			/* Auto-format text. Default: true. */
			'wpautop' => 'true',
			/* Extra class for container. */
			'containerclass' => '',
			/* Extra class for item. */
			'itemclass' => '',
			/* Extra class for caption. */
			'captionclass' => '',
			/* Size for image attachment. Accepted values: thumbnail, medium,
			 * large, full. Default: full. See wp_get_attachment_image_src() for
			 * further reference. */ 
			'size' => 'full'
		), $atts );
		$attributes = apply_filters( 'agnosia_bootstrap_carousel_attributes', $attributes );
		return $attributes;
	} 

	/**
	 * Check if the received data can make a valid carousel.
	 *
	 * @return boolean
	 */
	private function validate_data() {
		// Initialize boolean.
		$bool = false;
		// Convert attributes to variables.
		extract( $this->attributes );
		/* Validate for necessary data */
		if (   isset( $ids ) 
			&& isset( $type )
			&& 'carousel' == $type 
		) {
			$bool = true;
		}
		return $bool;
	}

	/**
	 * Obtain posts array by given IDs.
	 *
	 * @return array Array of WordPress $post objects.
	 */
	private function get_posts() {
		$posts = array();
		extract( $this->attributes );
		$images = $this->make_array( $ids, $orderby );
		if ( is_array( $images ) and !empty( $images ) ) {
			foreach ( $images as $image_id ) {
				$posts[] = get_post( intval( $image_id ) , ARRAY_A );
			}
		}
		$posts = apply_filters( 'agnosia_bootstrap_carousel_posts', $posts, $this->attributes );
		return $posts;
	}

	/**
	 * Define width of carousel container.
	 *
	 * @return string HTML result.
	 */
	private function get_container_style() {
		extract( $this->attributes );
		$container_style = '';
		if ( $width ) {
			$container_style = 'style="width:' . $width . ';"';
		}
		$container_style = apply_filters( 'agnosia_bootstrap_carousel_container_style', $container_style, $this->attributes );
		return $container_style;
	}

	/**
	 * Define height of carousel item.
	 *
	 * @return string HTML result.
	 */
	private function get_item_style() {
		extract( $this->attributes );
		$item_style = '';
		if ( $height ) {
			$item_style = 'style="height:' . $height . ';"' ;
		}
		$item_style = apply_filters( 'agnosia_bootstrap_carousel_item_style', $item_style, $this->attributtes );
		return $item_style;
	}

	/**
	 * Obtain complete HTML output for carousel.
	 * 
	 * @return string HTML result.
	 */
	private function get_output() {

		// Convert attributes to variables.
		extract( $this->attributes );
		// Initialize carousel HTML.
		$output = $this->get_carousel_container( 'start' );
		// Try to obtain indicators before inner.
		$output .= ( 'before-inner' == $indicators ) ? $this->get_indicators() : '' ;
		// Initialize inner.
		$output .= $this->get_carousel_inner( 'start' );
		// Start counter for posts iteration.
		$i = 0;

		// Process each item into $this->posts array and create HTML.
		foreach ( $this->posts as $post ) {
			// Make sure to include only attachments into the carousel.
			if ( 'attachment' == $post['post_type'] ) {
				$class = ( 0 == $i ) ? 'active ' : '';
				$output .= $this->get_img_container( 'start', $i );
				$output .= $this->get_img( $post );
				if ( 'false' !== $title || 'false' !== $text ) {
					$output .= $this->get_caption_container( 'start' );
					$output .= $this->get_title( $post );
					$output .= $this->get_excerpt( $post );
					$output .= $this->get_caption_container( 'end' );
				}
				$output .= $this->get_img_container( 'end' );
				$i++;
			}
		}

		// End inner.
		$output .= $this->get_carousel_inner( 'end' );
		// Try to obtain indicators after inner.
		$output .= ( 'after-inner' == $indicators ) ? $this->get_indicators() : '' ;
		// Obtain links for carousel control.
		$output .= ( 'false' !== $control ) ? $this->get_control() : '' ;
		// Try to obtain indicators after control. */
		$output .= ( 'after-control' == $indicators ) ? $this->get_indicators() : '' ;
		// End carousel HTML.
		$output .= $this->get_carousel_container( 'end' );
		// Obtain javascript for carousel.
		$output .= $this->get_javascript();

		$output = apply_filters( 'agnosia_bootstrap_carousel_output', $output, $this->attributes );

		return $output;

	}

	/**
	 * Get starting and ending HTML tag for carousel container.
	 * 
	 * @param  string $position Indicator for starting or ending tag.
	 * @return string           HTML result.
	 */
	private function get_carousel_container( $position ) {
		$output = '';
		switch ( $position ) {
			case 'start':
				extract( $this->attributes );
				$output .= '<div id="' . $name . '" class="carousel slide ' . $containerclass . '" ' . $this->container_style . '>';
				break;
			case 'end':
				$output .= '</div>';
				break;
			default:
				// Do nothing.
				break;
		}
		$output = apply_filters( 'agnosia_bootstrap_carousel_container', $output, $this->attributes );
		return $output;
	}

	/**
	 * Get starting and ending HTML tag for carousel inner element.
	 *
	 * @param  string $position Indicator for starting or ending tag.
	 * @return string           HTML result.
	 */
	private function get_carousel_inner( $position ) {
		$output = '';
		switch ( $position ) {
			case 'start':
				extract( $this->attributes );
				$output = '<div class="carousel-inner">';
				break;
			case 'end':
				$output = '</div>';
				break;
			default:
				// Do nothing.
				break;
		}
		$output = apply_filters( 'agnosia_bootstrap_carousel_inner', $output, $this->attributes );
		return $output;
	}

	/**
	 * Get starting and ending HTML tag for container of a caption.
	 *
	 * @param  string $position Indicator for starting or ending tag.
	 * @return string           HTML result.
	 */
	private function get_caption_container( $position ) {
		$output = '';
		switch ( $position ) {
			case 'start':
				extract( $this->attributes );
				$output .= '<div class="carousel-caption ' . $captionclass . '">';
				break;
			case 'end':
				$output .= '</div>';
				break;
			default:
				// Do nothing.
				break;
		}
		$output = apply_filters( 'agnosia_bootstrap_carousel_caption_container', $output, $this->attributes );
		return $output;
	}

	/**
	 * Get starting and ending HTML tag for container of a gallery item.
	 *
	 * @param  string  $position Indicator for starting or ending tag.
	 * @param  integer $i        Position of the current item into carousel.
	 * @return string            HTML result.
	 */
	private function get_img_container( $position, $i = 0 ) {
		$output = '';
		switch ( $position ) {
			case 'start':
				extract( $this->attributes );
				$class = ( $i == 0 ) ? 'active ' : '';
				$output .= '<div class="' . $class . 'item ' . $itemclass . '" data-slide-no="' . $i . '" ' . $this->item_style . '>';
				break;
			case 'end':
				$output .= '</div>';
				break;
			default:
				// Do nothing.
				break;
		}
		$output = apply_filters( 'agnosia_bootstrap_carousel_img_container', $output, $this->attributes );
		return $output;
	}

	/**
	 * Get HTML-formatted image for a carousel item.
	 *
	 * @param  array $post A WordPress $post object.
	 * @return string      HTML result.
	 */
	private function get_img( $post ) {
		extract( $this->attributes );
		$output = '';
		$image = wp_get_attachment_image_src( $post['ID'] , $size );
		$output .= '<img alt="' . $post['post_title'] . '" src="' . $image[0] . '" />';
		$output = apply_filters( 'agnosia_bootstrap_carousel_img', $output, $image[0], $this->attributes, $post );
		return $output;
	}

	/**
	 * Obtain the HTML-formatted title for an image.
	 *
	 * @return string HTML result.
	 */
	private function get_title( $post ) {
		extract( $this->attributes );
		$output = '';
		if ( $title != 'false' ) :
			switch ( $link ) {
			 	case 'file':
			 		$post_title = '<a href="' . $post['guid'] . '">' . $post['post_title'] . '</a>';
			 		break;
			 	case 'none':
			 		$post_title = $post['post_title'];
			 		break;
			 	default:
			 		$post_title = '<a href="' . get_permalink( $post['ID'] ) . '">' . $post['post_title'] . '</a>';
			 		break;
			 } 
			$output .= '<'. $titletag .'>' . $post_title . '</' . $titletag . '>';
		endif;
		$output = apply_filters( 'agnosia_bootstrap_carousel_title', $output, $this->attributes );
		return $output;
	}

	/**
	 * Get the excerpt for an image.
	 *
	 * @return string HTML result.
	 */
	private function get_excerpt( $post ) {
		extract( $this->attributes );
		$output = '';
		if ( 'false' !== 'text' ) {
			$output .= ( $wpautop != 'false' ) ? wpautop( $post['post_excerpt'] ) : $post['post_excerpt'];
		}
		$output = apply_filters( 'agnosia_bootstrap_carousel_excerpt', $output, $this->attributes );
		return $output;
	}


	/**
	 * Obtain indicators from $this->posts array.
	 *
	 * @return string HTML result.
	 */
	private function get_indicators() {
		extract( $this->attributes );
		$output = '<ol class="carousel-indicators">';
		$i = 0;
		foreach ( $this->posts as $post ) {
			// Make sure to include only attachments into the carousel.
			if ( 'attachment' == $post['post_type'] ) {
				$class = ( $i == 0 ) ? 'active' : '';
				$output .= '<li data-target="#' . $name . '" data-slide-to="' . $i . '" class="' . $class . '"></li>';
				$i++;
			}
		}
		$output .= '</ol>';
		$output = apply_filters( 'agnosia_bootstrap_carousel_indicators', $output, $this->attributes );
		return $output;
	}


	/**
	 * Obtain control links.
	 *
	 * @return string HTML result.
	 */
	private function get_control() {
		extract( $this->attributes );
		$output = '<a class="carousel-control left" href="#' . $name . '" data-slide="prev">&lsaquo;</a>';
		$output .= '<a class="carousel-control right" href="#' . $name . '" data-slide="next">&rsaquo;</a>';
		$output = apply_filters( 'agnosia_bootstrap_carousel_control', $output, $this->attributes );
		return $output;
	}

	/**
	 * Get Javascript for carousel.
	 *
	 * @return string HTML script tag.
	 */
	private function get_javascript() {
		extract( $this->attributes );
		$output = '<script type="text/javascript">// <![CDATA[
jQuery(document).ready( function($) { $(\'#' . $name . '\').carousel( { interval : ' . $interval . ' , pause : "' . $pause . '" } ); } );
// ]]></script>';
		$output = apply_filters( 'agnosia_bootstrap_carousel_javascript', $output, $this->attributes );
		return $output;
	}

	/**
	 * Obtain array of id given comma-separated values in a string.
	 * 
	 * @param  string $string  Comma-separated IDs of posts.
	 * @param  string $orderby Alternative order for array to be returned.
	 * @return array           Array of WordPress post IDs.
	 */
	private function make_array( $string, $orderby = '' ) {
		$array = explode( ',' , $string );
		// Support for random order.
		if ( 'rand' == $orderby ) {
			shuffle( $array );
		}
		$array = apply_filters( 'agnosia_bootstrap_carousel_make_array', $array, $this->attributes );
		return $array;
	}

}
