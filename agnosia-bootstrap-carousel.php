<?php
/**
 * Agnosia Bootstrap Carousel by AuSoft
 *
 * Hooks the `[gallery]` shortcode with attribute `type="carousel"` in order to
 * show a Bootstrap Carousel (http://getbootstrap.com/javascript/#carousel)
 * based on the selected images and their titles and descriptions. It's
 * important to note that this plugin assumes either your theme includes the
 * necessary Bootstrap Javascript and CSS files to display the carousel
 * properly, or that you have included the files on your own. It will not
 * include the files for you, so if they are not present, the carousel will not
 * work.
 *
 * @package   Agnosia_Bootstrap_Carousel
 * @version   1.1
 * @author    Andrés Villarreal <andrezrv@gmail.com>
 * @license   GPL-2.0
 * @link      http://github.com/andrezrv/agnosia-bootstrap-carousel
 * @copyright 2013-2014 Andrés Villarreal
 *
 * @wordpress-plugin
 * Plugin Name: Agnosia Bootstrap Carousel by AuSoft
 * Plugin URI: http://wordpress.org/extend/plugins/agnosia-bootstrap-carousel/
 * Description: Hooks the <code>[gallery]</code> shortcode with attribute <code>type="carousel"</code> in order to show a <a href="http://getbootstrap.com/javascript/#carousel" target="_blank">Bootstrap Carousel</a> based on the selected images and their titles and descriptions. <strong>Very important:</strong> this plugin assumes either your theme includes the necessary Bootstrap Javascript and CSS files to display the carousel properly, or that you have included the files on your own. It will not include the files for you, so if they are not present, the carousel will not work.
 * Author: Andr&eacute;s Villarreal, AuSoft
 * Author URI: http://aufieroinformatica.com/wordpress/
 * Version: 1.1
 */
// Load Agnosia Bootstrap Carousel class.
require( dirname( __FILE__ ) . '/agnosia-bootstrap-carousel.class.php' );
// Load Agnosia Bootstrap Carousel Loader class.
require( dirname( __FILE__ ) . '/agnosia-bootstrap-carousel-loader.class.php' );
// Load Agnosia Bootstrap Carousel.
new Agnosia_Bootstrap_Carousel_Loader;
