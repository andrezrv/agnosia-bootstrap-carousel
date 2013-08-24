=== Agnosia Bootstrap Carousel by AuSoft ===
Contributors: andrezrv, aufieroi
Donate link: http://aufieroinformatica.com/wordpress/agnosia-bootstrap-carousel-by-ausoft/
Tags: bootstrap, responsive, carousel, images, slider
Requires at least: 3.0
Tested up to: 3.6
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin lets you use the [gallery] shortcode to show a Bootstrap Carousel.

== Description ==

**Agnosia Bootstrap Carousel** hooks the `[gallery]` shortcode with attribute `type="carousel"` in order to show a **[Bootstrap Carousel](http://twitter.github.io/bootstrap/javascript.html#carousel)** based on the selected images and their titles and descriptions.

This plugin assumes either your theme includes the necessary **Bootstrap** javascript and CSS files to display the carousel properly, or that you have included those files on your own. It will not include the files for you, so if they are not present, the carousel will not work and you will only obtain its bare HTML.

#### Basic example:


`[gallery type="carousel" ids="61,60,59"]`
`[carousel-gallery ids="61,60,59"]`


#### Required attributes:


*	**type:** it needs to be `type="carousel"`.
*	**ids:** you must provide a list of `ids` corresponding to attachments, like `ids="1,2,3"`.

Otherwise, the default `[gallery]` shortcode function will be processed instead of this plugin's one.


#### Optional attributes:


*	**name:** any name. String will be sanitize to be used as an HTML ID. Recomended when you want to have more than one carousel in the same page. **Default:** *agnosia-bootstrap-carousel*. **Example:** `[gallery type="carousel" ids="61,60,59" name="myCarousel"]`
*	**indicators:** indicators position. **Accepted values:** *before-inner*, *after-inner*, *after-control*, *false* (hides indicators). **Default:** *before-inner*. **Example:** `[gallery type="carousel" ids="61,60,59" indicators="after-inner"]`
*	**width:** carousel container width, in `px` or `%`. **Default:** not set. **Example:** `[gallery type="carousel" ids="61,60,59" width="800px"]`
*	**height:** carousel item height, in `px` or `%`. **Default:** not set. **Example:** `[gallery type="carousel" ids="61,60,59" height="400px"]`
*	**titletag:** define HTML tag for image title. **Default:** *h4*. **Example:** `[gallery type="carousel" ids="61,60,59" titletag="h2"]`
*	**wpautop:** auto-format text. **Default:** *true*. **Example:** `[gallery type="carousel" ids="61,60,59" wpautop="false"]`
*	**title:** show or hide image title. Set *false* to hide. **Default:** *true*. **Example:** `[gallery type="carousel" ids="61,60,59" title="false"]`
*	**text:** show or hide image text. Set *false* to hide. **Default:** *true*. **Example:** `[gallery type="carousel" ids="61,60,59" text="false"]`
+	**containerclass:** extra class for carousel container. **Default:** not set. **Example:** `[gallery type="carousel" ids="61,60,59" containerclass="container"]`
+	**itemclass:** extra class for carousel item. **Default:** not set. **Example:** `[gallery type="carousel" ids="61,60,59" itemclass="container"]`
+	**captionclass:** extra class for item caption. **Default:** not set. **Example:** `[gallery type="carousel" ids="61,60,59" captionclass="container"]`
*	**control:** control arrows display. **Accepted values:** *true* (to show), *false* (to hide). **Default:** *true*. **Example:** `[gallery type="carousel" ids="61,60,59" control="false"]`
*	**interval:** the amount of time to delay between automatically cycling an item. If *false*, carousel will not automatically cycle. **Default:** *5000*. **Example:** `[gallery type="carousel" ids="61,60,59" interval="2000"]`
*	**pause:** pauses the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave. **Default:** *"hover"*. **Example:** `[gallery type="carousel" ids="61,60,59" interval="hover"]`

For more information, visit <http://aufieroinformatica.com/wordpress/agnosia-bootstrap-carousel-by-ausoft/>

== Installation ==

1. Unzip `agnosia-bootstrap-carousel.zip` and upload the `agnosia-bootstrap-carousel` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the **"Plugins"** menu in WordPress.
3. Start using the `[gallery]` shortcode to show a [Bootstrap Carousel](http://twitter.github.io/bootstrap/javascript.html#carousel).

== Screenshots ==

1. This is how you should use the shortcode.
2. This is how it should appear in your website. Note that your theme styles may override Bootstrap styles.
3. This is an approximation on how the resultant HTML code should look like.

== Changelog ==

= 0.3 =
Fixed compatibility issues.

= 0.2 =
**New optional attributes:** `width`, `height`, `titletag`, `wpautop`, `title`, `text`, `itemclass`, `containerclass`, `captionclass`.

= 0.1 =
First release!
