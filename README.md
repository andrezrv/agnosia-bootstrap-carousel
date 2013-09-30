# Agnosia Bootstrap Carousel by AuSoft

A tool that hooks the `[gallery]` shortcode with attribute `type="carousel"` in order to show a **[Bootstrap Carousel](http://twitter.github.io/bootstrap/javascript.html#carousel)** based on the selected images and their titles and descriptions.

This plugin assumes either your theme includes the necessary **Bootstrap** javascript and CSS files to display the carousel properly, or that you have included those files on your own. It will not include the files for you, so if they are not present, the carousel will not work and you will only obtain its bare HTML.

#### Basic examples:


`[gallery type="carousel" ids="61,60,59"]`


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
*   **size:** size for image attachment. **Accepted values:** *thumbnail*, *medium*, *large*, *full*. **Default:** *full*. See [wp_get_attachment_image_src()](http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src) for further reference. **Example:** `[gallery type="carousel" ids="61,60,59" size="full"]`

For more information, visit <http://aufieroinformatica.com/wordpress/agnosia-bootstrap-carousel-by-ausoft/>

## Installation

1. Run `git clone git@github.com:andrezrv/agnosia-bootstrap-carousel.git` into your plugins folder. You can also download the plugin in zip format either from [Github](https://github.com/andrezrv/agnosia-bootstrap-carousel/archive/master.zip) and the [WordPress Plugin Repository](http://wordpress.org/plugins/agnosia-bootstrap-carousel/), then open the file and upload the `agnosia-bootstrap-carousel` folder to your `plugins` directory.
2. Activate the plugin through the **"Plugins"** menu in WordPress.
3. Start using the `[gallery]` shortcode to show a [Bootstrap Carousel](http://twitter.github.io/bootstrap/javascript.html#carousel).

## Changelog

#### 0.3.1
Added new *size* attribute. Thanks to [blogrammierer](http://wordpress.org/support/profile/blogrammierer)!

#### 0.3
Fixed compatibility issues.

#### 0.2
**New optional attributes:** `width`, `height`, `titletag`, `wpautop`, `title`, `text`, `itemclass`, `containerclass`, `captionclass`.

#### 0.1
First release! Only available at the [WordPress Plugin Repository](http://wordpress.org/plugins/agnosia-bootstrap-carousel/)
