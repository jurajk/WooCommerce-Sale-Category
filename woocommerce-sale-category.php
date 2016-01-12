<?php
/**
 * Plugin Name: WooCommerce Sale Category
 * Plugin URI: https://webikon.sk/en/
 * Description: Automatically assign products on sale to a specified category
 * Author: Webikon (Juraj Kiss)
 * Author URI: https://twitter.com/jur4jk
 * Version: 0.1
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
if ( ! class_exists( 'WC_Sale_Category' ) ) :
class WC_Sale_Category {
	/**
	* Construct the plugin.
	*/
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}
	/**
	* Initialize the plugin.
	*/
	public function init() {
		// Checks if WooCommerce is installed.
		if ( class_exists( 'WC_Integration' ) ) {
			// Include our integration class.
			include_once 'class-wc-integration-sale-category.php';
			// Register the integration.
			add_filter( 'woocommerce_integrations', array( $this, 'add_integration' ) );
		} else {
			// throw an admin error if you like
		}
	}
	/**
	 * Add a new integration to WooCommerce.
	 */
	public function add_integration( $integrations ) {
		$integrations[] = 'WC_Integration_Sale_Category';
		return $integrations;
	}
}
$WC_Sale_Category = new WC_Sale_Category( __FILE__ );
endif;
