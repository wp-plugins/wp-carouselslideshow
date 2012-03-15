=== Carousel slideshow ===

Contributors: wpslideshow.com
Author URI: http://wpslideshow.com/carousel-slideshow/
Tags: carousel slideshow, flash slideshow
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: trunk

Carousel slideshow is a plugin that used to display a slideshow on your website.It is also allow us to use as a widget. You can also enable Carousel slideshow on your wordpress site by placing code snippet in your template php file.

== Description ==

Carousel slideshow is a plugin that used to display a slideshow on your website.It is also allow us to use as a widget. You can also enable Carousel slideshow on your wordpress site by placing code snippet in your template php file.

**Features**
* Customizable Enable/Disable Snow Effect on the slideshow
* Customizable slideshow main_image height & width
* Customizable slideshow background color
* Customizable autoslide option
* Customizable slideshow transition speed
* Customizable Transition type     
* Customizable options for Description 
* Customizable corner readious option

Requirements/Restrictions:
-------------------------
 * Works with Wordpress 3.0, WPMU (Wordpress 3.0+ is highly recommended)
 * PHP5 

For working demo : http://wpslideshow.com/carousel-slideshow/

== Installation ==

1. Install automatically through the `Plugins`, `Add New` menu in WordPress, or upload the `wp-carousel-slideshow` folder to the `/wp-content/plugins/` directory. 

2. Activate the plugin through the `Plugins` menu in WordPress. Look for the "Settings" link  on left side menu under 'carousel' to configure the Options. 

3. Click on `Carousel slideshow Settings` on leftside menu, you can find "make config.xml" on right side panel bottom location, click on it. 

4. Add the shortcode `[carousel_slideshow]` in a Page, Post. Here is how: Log into your blog admin dashboard. Click `Pages`, click `Add New`, add a title to your page, enter the shortcode `[carousel_slideshow]` in the page, click `Publish`.

5. Still if you facing any issues in using this plugin please contact our support at addons@wpslideshow.com

For working demo : http://wpslideshow.com/carousel-slideshow/

== Screenshots ==

1. screenshot-1.png is the front-end slideshow page.

2. screenshot-2.png is the  tab on the `Admin Plugins` page.

3. screenshot-3.png is the settings of the slideshow page.

4. screenshot-4.png adding the shortcode `[carousel_slideshow]` in a Page.


== How to use it as a widget ==

After install `wp-carouselslideshow` plugin in your theme just follow below instructions.

1. Go to Appearance > Widgets, we can simply drag & drop `Carousel Slideshow` widget where ever you want to display it.

2. To configure your slideshow settings click on  `Carousel slideshow Settings` on the leftside, and edit settings and click on `make config.xml` button.

3. If you want display this widget on any certain pages of your site just you need to install 
"widget-context" (http://wordpress.org/extend/plugins/widget-context/) plugin . 


== How to use plug-in in the template code ==

After install `wp-carouselslideshow` plugin, follow the instructions below.

1. Open your theme php file and add the line <code><?php echo do_shortcode('[carousel_slideshow]');?> </code> where ever you like to show the slide show.

== change log ==

1.0
 Initial released version

2.0
Added customizable option for enable/disbale snow effect on the slidehsow.

3.0
fixed bug enable/disable description on the slideshow.

