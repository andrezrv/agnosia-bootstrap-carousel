<?php

/**
 * @package Agnosia_Bootstrap_Carousel
 * @version 0.3
 */

/*
Plugin Name: Agnosia Bootstrap Carousel by AuSoft
Plugin URI: http://wordpress.org/extend/plugins/agnosia-bootstrap-carousel/
Description: Hooks the <code>[gallery]</code> shortcode with attribute <code>type="carousel"</code> in order to show a <a href="http://twitter.github.io/bootstrap/javascript.html#carousel" target="_blank">Bootstrap Carousel</a> based on the selected images and their titles and descriptions. <strong>Very important:</strong> this plugin assumes either your theme includes the necessary Bootstrap Javascript and CSS files to display the carousel properly, or that you have included the files on your own. It will not include the files for you, so if they are not present, the carousel will not work.
Author: AuSoft, Andr&eacute;s Villarreal
Author URI: http://aufieroinformatica.com/wordpress/
Version: 0.3
*/

/**
 * Hook the gallery default HTML.
 */
add_filter( 'post_gallery', 'agnosia_bootstrap_carousel_gallery_shortcode', 10, 4 );

function agnosia_bootstrap_carousel_gallery_shortcode( $output = '', $atts, $content = false, $tag = false ) {

	/* Define data by given attributes. */
	$shortcode_atts = shortcode_atts( array(
		'ids' => false,
		'type' => '',
		'name' => 'agnosia-bootstrap-carousel', /* Any name. String will be sanitize to be used as HTML ID. Recomended when you want to have more than one carousel in the same page. Default: agnosia-bootstrap-carousel. */
		'width' => '',  /* Carousel container width, in px or % */
		'height' => '', /* Carousel item height, in px or % */
		'indicators' => 'before-inner',  /* Accepted values: before-inner, after-inner, after-control, false. Default: before-inner. */
		'control' => 'true', /* Accepted values: true, false. Default: true. */
		'interval' => 5000,  /* The amount of time to delay between automatically cycling an item. If false, carousel will not automatically cycle. */
		'pause' => 'hover', /* Pauses the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave. */
		'titletag' => 'h4', /* Define tag for image title. Default: h4. */
		'title' => 'true', /* Show or hide image title. Set false to hide. Default: true. */
		'text' => 'true', /* Show or hide image text. Set false to hide. Default: true. */
		'wpautop' => 'true', /* Auto-format text. Default: true. */
		'containerclass' => '', /* Extra class for container. */
		'itemclass' => '', /* Extra class for item. */
		'captionclass' => '' /* Extra class for caption. */
	), $atts );

	extract( $shortcode_atts );

	$name = sanitize_title( $name );

	/* Validate for necessary data */
	if ( isset( $ids ) 
		and ( ( isset( $type ) and 'carousel' == $type ) 
			or ( 'carousel-gallery' == $tag ) 
		) 
	) :

		/* Obtain HTML. */
		$output = agnosia_bootstrap_carousel_get_html_from( $shortcode_atts );

	/* If attributes could not be validated, execute default gallery shortcode function */
	else : $output = '';

	endif;

	return $output;

}



function agnosia_bootstrap_carousel_get_html_from( $shortcode_atts ) {

	/* Obtain posts array by given ids. Then construct HTML. */

	extract( $shortcode_atts );

	$images = agnosia_bootstrap_carousel_make_array( $ids );

	$output = '';

	if ( is_array( $images ) and !empty( $images ) ) :

		$posts = array();

		foreach ( $images as $image_id ) :

			$posts[] = get_post( intval( $image_id ) , ARRAY_A );

		endforeach;

		if ( is_array( $posts ) and !empty( $posts ) ) :

			$output = agnosia_bootstrap_carousel_make_html_from( $shortcode_atts , $posts );

		endif;

	endif;

	return $output;

}



function agnosia_bootstrap_carousel_make_html_from( $shortcode_atts , $posts ) {

	/* The important stuff happens here! */

	extract( $shortcode_atts );

	/* Define width of carousel container */
	$container_style = '';
	if ( $width ) :
		$container_style = 'style="';
		if ( $width ) : $container_style .= 'width:' . $width . ';' ; endif;
		$container_style .= '"';
	endif;

	/* Define height of carousel item */
	$item_style = '';
	if ( $height ) :
		$item_style = 'style="';
		if ( $height ) : $item_style .= 'height:' . $height . ';' ; endif;
		$item_style .= '"';
	endif;

	/* Initialize carousel HTML. */
	$output = '<div id="' . $name . '" class="carousel slide ' . $containerclass . '" ' . $container_style . '>';

	/* Try to obtain indicators before inner. */
	$output .= ( $indicators == 'before-inner' ) ? agnosia_bootstrap_carousel_make_indicators_html_from( $posts , $name ) : '' ;

	/* Initialize inner. */
	$output .= '<div class="carousel-inner">';

	/* Start counter. */
	$i = 0;

	/* Process each item into $posts array and obtain HTML. */
	foreach ( $posts as $post ) :

		if ( $post['post_type'] == 'attachment' ) : /* Make sure to include only attachments into the carousel */

			$image = wp_get_attachment_image_src( $post['ID'] , 'full' );

			$class = ( $i == 0 ) ? 'active ' : '';

			$output .= '<div class="' . $class . 'item ' . $itemclass . '" data-slide-no="' . $i . '" ' . $item_style . '>';

			$output .= '<img alt="' . $post['post_title'] . '" src="' . $image[0] . '" />';

			if ( $title != 'false' or $text != 'false' ) :

				$output .= '<div class="carousel-caption ' . $captionclass . '">';

				if ( $title != 'false' ) : $output .= '<'. $titletag .'>' . $post['post_title'] . '</' . $titletag . '>'; endif;

				if ( $text != 'false' ) : $output .= ( $wpautop != 'false' ) ? wpautop( $post['post_excerpt'] ) : $post['post_excerpt'] ; endif;

				$output .= '</div>';

			endif;

			$output .= '</div>';

			$i++;

		endif;

	endforeach;

	/* End inner. */
	$output .= '</div>';

	/* Try to obtain indicators after inner. */
	$output .= ( $indicators == 'after-inner' ) ? agnosia_bootstrap_carousel_make_indicators_html_from( $posts , $name ) : '' ;

	$output .= ( $control != 'false' ) ? agnosia_bootstrap_carousel_make_control_html_with( $name ) : '' ;

	/* Try to obtain indicators after control. */
	$output .= ( $indicators == 'after-control' ) ? agnosia_bootstrap_carousel_make_indicators_html_from( $posts , $name ) : '' ;

	/* End carousel HTML. */
	$output .= '</div>';

	/* Obtain javascript for carousel. */
	$output .= '<script type="text/javascript">// <![CDATA[
jQuery(document).ready( function() { jQuery(\'#' . $name . '\').carousel( { interval : ' . $interval . ' , pause : "' . $pause . '" } ); } );
// ]]></script>';

	return $output;

}


/* Obtain indicators from $posts array. */
function agnosia_bootstrap_carousel_make_indicators_html_from( $posts , $name ) {

	$output = '<ol class="carousel-indicators">';

	$i = 0;

	foreach ( $posts as $post ) :

		if ( $post['post_type'] == 'attachment' ) : /* Make sure to include only attachments into the carousel */

			$class = ( $i == 0 ) ? 'active' : '';

			$output .= '<li data-target="#' . $name . '" data-slide-to="' . $i . '" class="' . $class . '"></li>';

			$i++;

		endif;

	endforeach;

	$output .= '</ol>';

	return $output;

}


/* Obtain control links. */
function agnosia_bootstrap_carousel_make_control_html_with( $name ) {

	$output = '<a class="carousel-control left" href="#' . $name . '" data-slide="prev">&lsaquo;</a>';
	$output .= '<a class="carousel-control right" href="#' . $name . '" data-slide="next">&rsaquo;</a>';

	return $output;

}



/* Obtain array of id given comma-separated values in a string. */
function agnosia_bootstrap_carousel_make_array( $string ) {

	$array = explode( ',' , $string );
	return $array;

}



?>
