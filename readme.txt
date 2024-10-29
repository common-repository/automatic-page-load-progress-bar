=== Automatic Page Load Progress Bar ===
Donate link:
Contributors: atilbian
Tags: pace, progress bar, loading bar, design, spinning wheel, load, loading page, user experience, waiting wheel,
Requires at least: 3.0.1
Tested up to: 5.6
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embed beautiful loading bar on your wordpress website in just a few clics.

== Description ==
This free plugin give you the ability to add different kind of loading bar for your website. 
Simple admin setting to change color and progress bar theme. You can choose to add them globally to your website or page by page. 

I really like adding nice progress bar to my website, giving user a fancy way to make this boring moment fun !
With this plug and play plugin, I want to help people to add loading effects to their websites easily.

It's a PACE (https://github.hubspot.com/pace/docs/welcome/# , developed by hubspot) wrapper with themes from various authors.


Shortcode give you a way to add specific shortcode for each page. It will override the globally defined progress bar.
Example of use:
[aplpb_shortcode theme="minimal" color="blue"]
If theme or color are not set, the shortcode will use the global defined theme or color.

== Installation ==

1. Upload the zip file into your WP plugin directory OR Install it by the wp plugins market.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Choose your theme and color in the settings.
4. Here you go, now your will see a nice loading bar before your website is fully loaded.

== Frequently Asked Questions ==

= How to change the color ? =
Move to the plugin settings, change your color and save it.

= How to change theme style ? =
Move to the plugin settings, change your theme style and save it.

= How to activate the progress bar for all my website ? =
Move to the plugin settings, check the "static page" and "blog post" boxes and your progress bar will appear everywhere on your website !

= How to create a page specific progress bar ? =
Use the shortcode functionnality so you can create page specific loading bar.
[aplpb_shortcode theme="minimal" color="blue"]

= How to create new smoothy theme ? =
Hey ! You are going in the right direction. Go to the plugin repository(https://gitlab.com/atilb/automatic-page-load-progress-bar-wordpress-plugin), fork it and give me some nice pull requests ! :D

== Screenshots ==

1. Settings panel for the plugin
2. Choose color and theme
3. Examples of loading screen/bar/wheel
4. Example of shortcode use

== Changelog ==
= 1.1.2 =
* Custom post can now display the progress bar

= 1.1.1 =
* Flat top theme added, and small optimization(css minifying)

= 1.1.0 =
* Settings screen updated

= 1.0.6 =
* Useless themes cleaned

= 1.0.5 =
* Media queries support added, you can now choose to hide progress bar for specific device type

= 1.0.4 =
* Progress bar can now be shown on selected content type(page, post, or both), and added a new plugin logo ! :D

= 1.0.3 =
* Shortcodes can now override globally defined progress bar

= 1.0.2 =
* Shortcode functionnality added