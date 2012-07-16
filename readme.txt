=== Carousel slideshow ===

Contributors: wpslideshow.com
Author URI: http://wpslideshow.com/carousel-slideshow/
Tags: carousel slideshow, wp carousel, carousel slider
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: trunk

Carousel slideshow can be shown in the posts using the short code [carousel]. You can display this slideshow multiple instances. It is also possible to display specific categories and images with their ID's in this slideshow.

== Description ==

Carousel slideshow can be shown in the posts using the short code [carousel]. You can display this slideshow multiple instances. It is also possible to display specific categories and images with their ID's in this slideshow.

**Features**
* Customizable Enable/Disable Snow Effect on the slideshow
* Customizable slideshow main_image height & width
* Customizable slideshow background color
* Customizable autoslide option
* Customizable slideshow transition speed
* Customizable Transition type     
* Customizable options for Description 
* Customizable corner readious option

Installation Video: https://www.youtube.com/watch?v=wTrnNunHd74

For working demo : http://wpslideshow.com/carousel-slideshow/



Requirements/Restrictions:
-------------------------
 * Works with Wordpress 3.0, WPMU (Wordpress 3.0+ is highly recommended)
 * PHP5 


== Installation ==

1. Install automatically through the `Plugins`, `Add New` menu in WordPress, or upload the `wp-carousel-slideshow` folder to the `/wp-content/plugins/` directory. 

2. Activate the plugin through the `Plugins` menu in WordPress. Look for the "Carousel slideshow Settings" link  on left side menu to configure the Options. 

3. Click on `Settings` on leftside menu under Carousel to change colors and other configurations.

= short codes =
* <code>[carousel]</code> - Use this short code in the content / post to display all images under all categories which are not disabled.

* <code>[carousel cats=2,3]</code> - Use this short code in the content / post to display all images under the categories with ID's 2,3.

* <code>[carousel imgs=1,2,3]</code> - Use this short code in the content / post to display images which has ID's 1,2,3.


* <code><?php echo do_shortcode('[carousel]');?></code> - Use this short code in the template (php file) to display all images under all categories which are not disabled.

* <code><?php echo do_shortcode('[carousel cats=2,3]');?></code> - Use this short code in the template (php file) to display all images under the categories with ID's 2,3.

* <code><?php echo do_shortcode('[carousel imgs=1,2,3]');?></code> - Use this short code in the template (php file) to display images which has ID's 1,2,3.

If you facing any issues in using this plugin please contact our support at addons@wpslideshow.com

Installation Video: https://www.youtube.com/watch?v=wTrnNunHd74

For working demo : http://wpslideshow.com/carousel-slideshow/

== Screenshots ==

1. screenshot-1.jpg - Slideshow front end. 

2. screenshot-2.gif - Add new album / category.

3. screenshot-3.gif - Edit image.

4. screenshot-4.gif - bulk upload.

5. screenshot-5.gif - edit album / category.

6. screenshot-6.gif - short code to be placed in the content.


Installation Video: https://www.youtube.com/watch?v=wTrnNunHd74


== change log ==

=1.0=
Initial released version

=2.0=
Added customizable option for enable/disbale snow effect on the slidehsow.

=3.0=
fixed bug enable/disable description on the slideshow.

=3.5=
This is entirely new build. It is not possible to upgrade from old version to this version. You need to uninstall old version an dinstall the new version.

=3.6=
Fixed few settings

=3.7=
Fixed security issues.

=3.9=
Where ever you place the short code, there only the slider shows. Previously it use to show on top of content.

=3.10=
Fixed security bugs.