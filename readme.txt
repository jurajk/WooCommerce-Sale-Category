=== Plugin Name ===
Contributors: jurajk
Tags: woocommerce, sale, on sale, product category
Requires at least: 4.2
Tested up to: 4.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically assign products on sale to a specified category

== Description ==

Ever wanted a category that listed only discounted products?
Sure, you could use the [sale] shortcode, but this solution includes the link in category list.

Every time a product price is changed, this plugin checks if it is on sale and assigns/unassigns it to a category you can pick in WooCommerce Integration settings.

Already have products on sale? There is a bulk action!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/woocommerce-sale-category` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Create an empty category, name it Sale, Discounts or whatever you like
1. Use the Woocommerce->Integration screen to select the desired sale category

== Frequently Asked Questions ==

= I already have many products on sale, is there a bulk action? =

Yep! Just select your sale category and check the Process existing products box.
Be careful if you have a lot of products.

= What happens if a schedule a sale? =

Your products will magically appear in the discounted category when the time comes.
And disappear when the time passes.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.1 =
First version.
