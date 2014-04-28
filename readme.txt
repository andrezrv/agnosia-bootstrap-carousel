=== Agnosia Bootstrap Carousel by AuSoft ===
Contributors: andrezrv, aufieroi
Tags: bootstrap, responsive, carousel, images, slider
Requires at least: 3.0
Tested up to: 3.9
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin lets you use the [gallery] shortcode to show a Bootstrap Carousel.

== Description ==

Agnosia Bootstrap Carousel hooks the `[gallery]` shortcode with attribute `type="carousel"` in order to show a [Bootstrap Carousel](http://getbootstrap.com/javascript/#carousel) based on the selected images and their titles and descriptions.

This plugin assumes either your theme includes the necessary Bootstrap javascript and CSS files to display the carousel properly, or that you have included those files on your own. It will not include the files for you, so if they are not present, the carousel will not work and you will only obtain its bare HTML.

#### Basic example:

`[gallery type="carousel" ids="61,60,59"]`

#### Required attributes:

* `type`: it needs to be `type="carousel"`.
* `ids`: you must provide a list of `ids` corresponding to attachments, like `ids="1,2,3"`.

Otherwise, the default `[gallery]` shortcode function will be processed instead of this plugin's one.

#### Optional attributes:

* `name`: any name. String will be sanitize to be used as an HTML ID. Recommended when you want to have more than one carousel in the same page. Default: *agnosia-bootstrap-carousel*. Example: `[gallery type="carousel" ids="61,60,59" name="myCarousel"]`
* `indicators`: indicators position. Accepted values: *before-inner*, *after-inner*, *after-control*, *false* (hides indicators). Default: *before-inner*. Example: `[gallery type="carousel" ids="61,60,59" indicators="after-inner"]`
* `width`: carousel container width, in `px` or `%`. Default: not set. Example: `[gallery type="carousel" ids="61,60,59" width="800px"]`
* `height`: carousel item height, in `px` or `%`. Default: not set. Example: `[gallery type="carousel" ids="61,60,59" height="400px"]`
* `titletag`: define HTML tag for image title. Default: *h4*. Example: `[gallery type="carousel" ids="61,60,59" titletag="h2"]`
* `wpautop`: auto-format text. Default: *true*. Example: `[gallery type="carousel" ids="61,60,59" wpautop="false"]`
* `title`: show or hide image title. Set *false* to hide. Default: *true*. Example: `[gallery type="carousel" ids="61,60,59" title="false"]`
* `text`: show or hide image text. Set *false* to hide. Default: *true*. Example: `[gallery type="carousel" ids="61,60,59" text="false"]`
+ `containerclass`: extra class for carousel container. Default: not set. Example: `[gallery type="carousel" ids="61,60,59" containerclass="container"]`
+ `itemclass`: extra class for carousel item. Default: not set. Example: `[gallery type="carousel" ids="61,60,59" itemclass="container"]`
+ `captionclass`: extra class for item caption. Default: not set. Example: `[gallery type="carousel" ids="61,60,59" captionclass="container"]`
* `control`: control arrows display. Accepted values: *true* (to show), *false* (to hide). Default: *true*. Example: `[gallery type="carousel" ids="61,60,59" control="false"]`
* `interval`: the amount of time to delay between automatically cycling an item. If *false*, carousel will not automatically cycle. Default: *5000*. Example: `[gallery type="carousel" ids="61,60,59" interval="2000"]`
* `pause`: pauses the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave. Default: *"hover"*. Example: `[gallery type="carousel" ids="61,60,59" interval="hover"]`
* `size`: size for image attachment. Accepted values: *thumbnail*, *medium*, *large*, *full*. Default: *full*. See [wp_get_attachment_image_src()](http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src) for further reference. Example: `[gallery type="carousel" ids="61,60,59" size="full"]`

#### Native supported attributes:

* `orderby`: Alternative order for your images. Example: `[gallery type="carousel" ids="61,60,59" orderby="rand"]`
* `link`: where your image titles will link to. Accepted values: *file*, *none* and empty. An empty value will link to your attachment's page. Example: `[gallery type="carousel" ids="61,60,59" link="file"]`

#### Extending

This plugin offers hooks for actions and filters, so you can modify its functionality or add your own.

##### Action hooks:
* `agnosia_bootstrap_carousel_before_init`: Do something before the carousel is loaded.
* `agnosia_bootstrap_carousel_init`: Do something after the carousel is loaded.

##### Filter hooks:
* `agnosia_bootstrap_carousel_attributes`: Modify the attributes passed to the shortcode.
* `agnosia_bootstrap_carousel_posts`: Modify the `$post` objects that the shortcode is using.
* `agnosia_bootstrap_carousel_container_style`: Modify the carousel container style.
* `agnosia_bootstrap_carousel_item_style`: Modify the style of the carousel items.
* `agnosia_bootstrap_carousel_output`: Modify the full HTML output of the carousel.
* `agnosia_bootstrap_carousel_container`: Modify the HTML output of the carousel container tag.
* `agnosia_bootstrap_carousel_inner`: Modify the HTML output of the carousel inner tag.
* `agnosia_bootstrap_carousel_caption_container`: Modify the HTML output of the caption container tag.
* `agnosia_bootstrap_carousel_img_container`: Modify the HTML output of the image container tag.
* `agnosia_bootstrap_carousel_img`: Modify the HTML output of the item image tag.
* `agnosia_bootstrap_carousel_excerpt`: Modify the HTML output of the image caption.
* `agnosia_bootstrap_carousel_indicators`: Modify the HTML output of the indicators element.
* `agnosia_bootstrap_carousel_control`: Modify the HTML output of the control element.
* `agnosia_bootstrap_carousel_javascript`: Modify the output of the carousel Javascript.
* `agnosia_bootstrap_carousel_make_array`: Modify the list of `$post` IDs that the carousel is using.

#### Contributing

You can make suggestions and submit your own modifications to this plugin on [Github](https://github.com/andrezrv/agnosia-bootstrap-carousel).

For more information, visit [our website](http://aufieroinformatica.com).

== Installation ==

1. Unzip `agnosia-bootstrap-carousel.zip` and upload the `agnosia-bootstrap-carousel` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the Plugins menu into WordPress admin area.
3. Start using the `[gallery]` shortcode to show a [Bootstrap Carousel](http://twitter.github.io/bootstrap/javascript.html#carousel).

== Screenshots ==

1. This is how you should use the shortcode.
2. This is how it should appear in your website. Note that your theme styles may override Bootstrap styles.
3. This is an approximation on how the resultant HTML code should look like.

== Changelog ==

= 1.1 =
* Improvements on filters. See [commit](https://github.com/andrezrv/agnosia-bootstrap-carousel/commit/d94762d1) for details.

= 1.0 =
* Support for random order.
* Support for link type ("attachment image", "media file" and "none").
* Add "Bootstrap Carousel" option to gallery types when using Jetpack Tiled Galleries.
* Custom filters and actions.
* Object oriented code.
* Better inline docs.

= 0.3.1 =
Added new *size* attribute. Thanks to [blogrammierer](http://wordpress.org/support/profile/blogrammierer)!

= 0.3 =
Fixed compatibility issues.

= 0.2 =
New optional attributes: `width`, `height`, `titletag`, `wpautop`, `title`, `text`, `itemclass`, `containerclass`, `captionclass`.

= 0.1 =
First release!
