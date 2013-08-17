<?php

/**
 * @package Agnosia_Bootstrap_Carousel
 * @version 0.2
 */

/*
Plugin Name: Agnosia Bootstrap Carousel by AuSoft
Plugin URI: http://wordpress.org/extend/plugins/agnosia-bootstrap-carousel/
Description: Hooks the <code>[gallery]</code> shortcode with attribute <code>type="carousel"</code> in order to show a <a href="http://twitter.github.io/bootstrap/javascript.html#carousel" target="_blank">Bootstrap Carousel</a> based on the selected images and their titles and descriptions. <strong>Very important:</strong> this plugin assumes either your theme includes the necessary Bootstrap Javascript and CSS files to display the carousel properly, or that you have included the files on your own. It will not include the files for you, so if they are not present, the carousel will not work.
Author: AuSoft, Andr&eacute;s Villarreal
Author URI: http://aufieroinformatica.com/wordpress/
Version: 0.2
*/

remove_shortcode( 'gallery', 'gallery_shortcode' ); /* Remove original shortcode */
add_shortcode( 'gallery', 'agnosia_bootstrat_carousel_gallery_shortcode' ); /* Add custom shortcode */



function agnosia_bootstrat_carousel_gallery_shortcode( $attr ) {

	/* Validate for necessary data */
	if ( isset( $attr['ids'] ) and isset( $attr['type'] ) and $attr['type'] == 'carousel' ) :

		/* Define data by given attributes. */
		$attr['ids'] = $attr['ids'];
		$attr['name'] = isset( $attr['name'] ) ? sanitize_title( $attr['name'] ) : 'agnosia-bootstrap-carousel' ; /* Any name. String will be sanitize to be used as HTML ID. Recomended when you want to have more than one carousel in the same page. Default: agnosia-bootstrap-carousel. */
		$attr['width'] = isset( $attr['width'] ) ? $attr['width'] : '' ; /* Carousel container width, in px or % */
		$attr['height'] = isset( $attr['height'] ) ? $attr['height'] : '' ; /* Carousel item height, in px or % */
		$attr['indicators'] = isset( $attr['indicators'] ) ? $attr['indicators'] : 'before-inner' ; /* Accepted values: before-inner, after-inner, after-control, false. Default: before-inner. */		
		$attr['control'] = isset( $attr['control'] ) ? $attr['control'] : 'true' ; /* Accepted values: true, false. Default: true. */
		$attr['interval'] = isset( $attr['interval'] ) ? $attr['interval'] : 5000 ; /* The amount of time to delay between automatically cycling an item. If false, carousel will not automatically cycle. */
		$attr['pause'] = isset( $attr['pause'] ) ? $attr['pause'] : 'hover' ; /* Pauses the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave. */
		$attr['titletag'] = isset( $attr['titletag'] ) ? $attr['titletag'] : 'h4' ; /* Define tag for image title. Default: h4. */
		$attr['title'] = isset( $attr['title'] ) ? $attr['title'] : 'true' ; /* Show or hide image title. Set false to hide. Default: true. */
		$attr['text'] = isset( $attr['text'] ) ? $attr['text'] : 'true' ; /* Show or hide image text. Set false to hide. Default: true. */
		$attr['wpautop'] = isset( $attr['wpautop'] ) ? $attr['wpautop'] : 'true' ; /* Auto-format text. Default: true. */
		$attr['containerclass'] = isset( $attr['containerclass'] ) ? $attr['containerclass'] : '' ; /* Extra class for container. */
		$attr['itemclass'] = isset( $attr['itemclass'] ) ? $attr['itemclass'] : '' ; /* Extra class for item. */
		$attr['captionclass'] = isset( $attr['captionclass'] ) ? $attr['captionclass'] : '' ; /* Extra class for caption. */

		/* Obtain HTML. */
		$output = agnosia_bootstrat_carousel_get_html_from( $attr );

	/* If attributes could not be validated, execute default gallery shortcode function */
	else : $output = gallery_shortcode( $attr ) ;

	endif;

	return $output;

}



function agnosia_bootstrat_carousel_get_html_from( $attr ) {

	/* Obtain posts array by given ids. Then construct HTML. */

	$images = agnosia_bootstrat_carousel_make_array( $attr['ids'] );

	$output = '';

	if ( is_array( $images ) and !empty( $images ) ) :

		$posts = array();

		foreach ( $images as $image_id ) :

			$posts[] = get_post( intval( $image_id ) , ARRAY_A );

		endforeach;

		if ( is_array( $posts ) and !empty( $posts ) ) :

			$output = agnosia_bootstrat_carousel_make_html_from( $attr , $posts );

		endif;

	endif;

	return $output;

}



function agnosia_bootstrat_carousel_make_html_from( $attr , $posts ) {

	/* The important stuff happens here! */

	/* Define width of carousel container */
	$container_style = '';
	if ( $attr['width'] ) :
		$container_style = 'style="';
		if ( $attr['width'] ) : $container_style .= 'width:' . $attr['width'] . ';' ; endif;
		$container_style .= '"';
	endif;

	/* Define height of carousel item */
	$item_style = '';
	if ( $attr['height'] ) :
		$item_style = 'style="';
		if ( $attr['height'] ) : $item_style .= 'height:' . $attr['height'] . ';' ; endif;
		$item_style .= '"';
	endif;

	/* Initialize carousel HTML. */
	$output = '<div id="' . $attr['name'] . '" class="carousel slide ' . $attr['containerclass'] . '" ' . $container_style . '>';

	/* Try to obtain indicators before inner. */
	$output .= ( $attr['indicators'] == 'before-inner' ) ? agnosia_bootstrat_carousel_make_indicators_html_from( $posts , $attr['name'] ) : '' ;

	/* Initialize inner. */
	$output .= '<div class="carousel-inner">';

	/* Start counter. */
	$i = 0;

	/* Process each item into $posts array and obtain HTML. */
	foreach ( $posts as $post ) :

		if ( $post['post_type'] == 'attachment' ) : /* Make sure to include only attachments into the carousel */

			$image = wp_get_attachment_image_src( $post['ID'] , 'full' );

			$class = ( $i == 0 ) ? 'active ' : '';

			$output .= '<div class="' . $class . 'item ' . $attr['itemclass'] . '" data-slide-no="' . $i . '" ' . $item_style . '>';

			$output .= '<img alt="' . $post['post_title'] . '" src="' . $image[0] . '" />';

			if ( $attr['title'] != 'false' or $attr['text'] != 'false' ) :

				$output .= '<div class="carousel-caption ' . $attr['captionclass'] . '">';

				if ( $attr['title'] != 'false' ) : $output .= '<'. $attr['titletag'] .'>' . $post['post_title'] . '</' . $attr['titletag'] . '>'; endif;

				if ( $attr['text'] != 'false' ) : $output .= ( $attr['wpautop'] != 'false' ) ? wpautop( $post['post_excerpt'] ) : $post['post_excerpt'] ; endif;

				$output .= '</div>';

			endif;

			$output .= '</div>';

			$i++;

		endif;

	endforeach;

	/* End inner. */
	$output .= '</div>';

	/* Try to obtain indicators after inner. */
	$output .= ( $attr['indicators'] == 'after-inner' ) ? agnosia_bootstrat_carousel_make_indicators_html_from( $posts , $attr['name'] ) : '' ;

	$output .= ( $attr['control'] != 'false' ) ? agnosia_bootstrat_carousel_make_control_html_with( $attr['name'] ) : '' ;

	/* Try to obtain indicators after control. */
	$output .= ( $attr['indicators'] == 'after-control' ) ? agnosia_bootstrat_carousel_make_indicators_html_from( $posts , $attr['name'] ) : '' ;

	/* End carousel HTML. */
	$output .= '</div>';

	/* Obtain javascript for carousel. */
	$output .= '<script type="text/javascript">// <![CDATA[
jQuery(document).ready( function() { jQuery(\'#' . $attr['name'] . '\').carousel( { interval : ' . $attr['interval'] . ' , pause : "' . $attr['pause'] . '" } ); } );
// ]]></script>';

	return $output;

}


/* Obtain indicators from $posts array. */
function agnosia_bootstrat_carousel_make_indicators_html_from( $posts , $name ) {

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
function agnosia_bootstrat_carousel_make_control_html_with( $name ) {

	$output = '<a class="carousel-control left" href="#' . $name . '" data-slide="prev">&lsaquo;</a>';
	$output .= '<a class="carousel-control right" href="#' . $name . '" data-slide="next">&rsaquo;</a>';

	return $output;

}



/* Obtain array of id given comma-separated values in a string. */
function agnosia_bootstrat_carousel_make_array( $string ) {

	$array = explode( ',' , $string );
	return $array;

}



?>
