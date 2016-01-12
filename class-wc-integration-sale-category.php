<?php
/**
 * Integration WooCommerce Sale Category.
 *
 * @package  WC_Integration_Sale_Category
 * @category Integration
 * @author   Juraj Kiss (Webikon)
 */
if ( ! class_exists( 'WC_Integration_Sale_Category' ) ) :
class WC_Integration_Sale_Category extends WC_Integration {
	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		global $woocommerce;
		$this->id                 = 'sale-category';
		$this->method_title       = __( 'Sale category', 'woocommerce-sale-category' );
		$this->method_description = __( 'Automatically assign products on sale to a category.', 'woocommerce-sale-category' );
		// Load the settings.

		$this->init_settings();
		// Define user set variables.
		$this->sale_category = intval( $this->get_option( 'sale_category' ) );
		$this->bulk_process = $this->get_option( 'bulk_process' );
		// Actions.
		add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) ); // save form data
    add_action( 'init', array( $this, 'init_form_fields' ) ); // set up form fields
    add_action( 'updated_postmeta', array( $this, 'assign_sale_category' ), 30, 4 ); // assign/unassign sale category on post meta update. needed for planned sales.
		add_action( 'init', array( $this, 'bulk_process_products' ), 40 ); // bulk process products
	}
	/**
	 * Initialize integration settings form fields.
	 */
	public function init_form_fields() {
		$categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );
    if ( is_wp_error( $categories) ) {
      return;
    }
		$options = array();
		foreach ( $categories as $category ) {
			$options[$category->term_id] = $category->name;
		}

		$this->form_fields = array(
			'sale_category' => array(
				'title'             => __( 'Sale category', 'woocommerce-sale-category' ),
				'type'              => 'select',
        'options' => $options,
				'description'       => __( 'Select the category to which products on sale will be assigned', 'woocommerce-sale-category' ),
			),
			'bulk_process' => array(
				'title'             => __( 'Process existing products', 'woocommerce-sale-category' ),
				'type'              => 'checkbox',
				'description'       => __( 'Assign existing sale products to the selected category', 'woocommerce-sale-category' ),
			)
		);
	}
  /**
	 * Assign/unassign the sale category after post meta was updated.
	 */
  public function assign_sale_category( $meta_id, $post_id, $meta_key, $meta_value ) {
    if ( $meta_key != '_price' ) {
      return; // do nothing, if the meta key is not _price
    }
    if ( wp_get_post_parent_id( $post_id ) ) {
      return; // bail if this is a variation
    }
    $product = wc_get_product( $post_id );
    if ( $product->is_on_sale() ) {
      // product is on sale, let's assign the sale category
      wp_set_object_terms( $post_id, $this->sale_category, 'product_cat', true );
    } else {
      // product is not on sale, let's remove the sale category
      wp_remove_object_terms( $post_id, $this->sale_category, 'product_cat' );
    }
  }

	/**
	* Bulk processing for existing posts
	*/
	public function bulk_process_products() {
		if( !isset( $_POST['woocommerce_sale-category_bulk_process'] ) ) {
			return;
		}
		if ( !$this->sale_category && !isset( $_POST['woocommerce_sale-category_sale_category'] ) ) {
			$this->errors[] = __( 'Please select your sale category, if you want to bulk process your existing products', 'woocommerce-sale-category' );
			return;
		}
		if ( isset( $_POST['woocommerce_sale-category_sale_category'] ) ) {
			$sale_category = intval( $_POST['woocommerce_sale-category_sale_category'] );
		} else {
			$sale_category = $this->sale_category;
		}
		$products = wc_get_product_ids_on_sale();
		if ( !$products ) {
			WC_Admin_Settings::add_error( __( 'No products on sale found', 'woocommerce-sale-category' ) );
			return;
		}
		foreach ( $products as $post_id) {
			wp_set_object_terms( $post_id, $sale_category, 'product_cat', true );
		}
		WC_Admin_Settings::add_message( __( count($products) . ' products processed', 'woocommerce-sale-category' ) );
	}

	/**
	 * Display errors by overriding the display_errors() method
	 * @see display_errors()
	 */
	public function display_errors( ) {
		// loop through each error and display it
		foreach ( $this->errors as $error ) {
			?>
			<div class="error">
				<p><?php echo $error; ?></p>
			</div>
			<?php
		}
	}


}
endif;
