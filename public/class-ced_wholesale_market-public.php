<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Ced_wholesale_market
 * @subpackage Ced_wholesale_market/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ced_wholesale_market
 * @subpackage Ced_wholesale_market/public
 * author     cedcoss <woocommerce@cedcoss.com>
 */
class Ced_Wholesale_Market_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_wholesale_market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_wholesale_market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_wholesale_market-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_wholesale_market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_wholesale_market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_wholesale_market-public.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Ced_add_wholesale_registerpage
	 * This is a  function for add checkbox in register page for apply as a wholesale customer
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function ced_add_wholesale_registerpage(){?>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="for_wholesalers"><input type="checkbox" name="wholesaler"/>wholesaler</label>
			</p>
			<?php
	}
	/**
	 * Ced_register_wholesalebox
	 * This is a function for save register form checkbox data using update_user_meta
	 *
	 * @since 1.0.0
	 * @param  mixed $customer_id
	 * @return void
	 */
	public function ced_register_wholesalebox( $customer_id ) {
		if ( isset( $_POST['wholesaler'] ) ) {
			update_user_meta( $customer_id, 'wholesaler_customer', sanitize_text_field( $_POST['wholesaler'] ) );
		}

	}


	/**
	 * Ced_display_wholesale_price
	 * This is a function for display wholesale price of simple product on single product page
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function ced_display_wholesale_price() {
		global $post;

		$showdata = get_option( 'woocommerce_wholesale_radio_button' );
		$mess     = get_option( 'woocommerce_wholesale_textfield' );
		if ( 'yes' == $showdata ) {
			$data = get_post_meta( $post->ID, '_wholesallers_price', true );
		} elseif ( 'yes' != $showdata && is_user_logged_in() ) {
			$data = get_post_meta( $post->ID, '_wholesallers_price', true );
		} else {
			$data = '';
		}
		?>
		<p><h2>wholesale Price:-</h2><?php echo esc_html( $data ); ?> <?php echo esc_html( $mess ); ?></p>
		<?php
	}


	/**
	 * Ced_display_wholesale_price_shoppage
	 * This is a function for display wholesale price of simple product on single product page
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function ced_display_wholesale_price_shoppage() {
		global $post;
		$showdata = get_option( 'woocommerce_wholesale_radio_button' );
		if ( 'yes' == $showdata ) {
			$data  = 'wholesalePrice  ';
			$data .= get_post_meta( $post->ID, '_wholesallers_price', true );
		} elseif ( 'yes' != $showdata && is_user_logged_in() ) {
			$data = get_post_meta( $post->ID, '_wholesallers_price', true );
		} else {
			$data = '';
		}
		?>
			<span class="amount"><?php echo esc_html( $data ); ?></span><br>
											<?php

	}


	/**
	 * Variation_price_custom_suffix
	 * This is function for add wholesale price on pariation product
	 *
	 * @param  mixed $variation_data->This will contain all data of variation
	 * @param  mixed $product->contain all product
	 * @param  mixed $variation
	 * @return void
	 * @since 1.0.0
	 */
	public function variation_price_custom_suffix( $variation_data, $product, $variation ) {

		$variation_id                  = $variation_data['variation_id'];
		$wholeprice                    = get_post_meta( $variation_id, 'checkbox_wholesale_setting_input', 1 );
		$variation_data['price_html'] .= ' <span class="price-suffix">' . __( 'wholesaleprice ' . $wholeprice, 'woocommerce' ) . '</span>';
		return $variation_data;
	}


	/**
	 * Add_custom_price_of_wholesale
	 * This is a function for add wholesale price on cart page when product quantity will increase
	 *
	 * @param  mixed $cart_obj
	 * @return void
	 * @since 1.0.0
	 */
	public function add_custom_price_of_wholesale( $cart_obj ) {
		global $post;
		foreach ( $cart_obj->get_cart() as $cart_item ) {
			$product_type = $cart_item['data']->get_type();
			if ( 'simple' == $product_type ) {
				$check_wholesale_inventory = get_option( 'wholesale_inventory_radio' );
				if ( 'no' == $check_wholesale_inventory ) {
					$common_invn  = get_option( 'setcommon_wholesale_textfield' );
					$common_value = get_post_meta( $cart_item['data']->get_id(), '_wholesallers_price', true );
					if ( $cart_item['quantity'] >= $common_invn ) {
						$cart_item['data']->set_price( $common_value );

					}
				} else {
					$common_value     = get_post_meta( $cart_item['data']->get_id(), '_wholesallers_price', true );
					$common_inventory = get_post_meta( $cart_item['data']->get_id(), '_wholesallers_price_inventory', true );
					if ( $cart_item['quantity'] >= $common_inventory ) {
						$cart_item['data']->set_price( $common_value );
					}
				}
			}

			if ( 'variation' == $product_type ) {
				$check_wholesale_inventory = get_option( 'wholesale_inventory_radio' );
				if ( 'no' == $check_wholesale_inventory ) {
					$common_invn  = get_option( 'setcommon_wholesale_textfield' );
					$common_value = get_post_meta( $cart_item['data']->get_id(), 'checkbox_wholesale_setting_input', true );
					if ( $cart_item['quantity'] >= $common_invn ) {
						$cart_item['data']->set_price( $common_value );
					}
				} else {
					$common_value     = get_post_meta( $cart_item['data']->get_id(), 'checkbox_wholesale_setting_input', true );
					$common_inventory = get_post_meta( $cart_item['data']->get_id(), 'checkbox_wholesale_inventory_input', true );
					if ( $cart_item['quantity'] >= $common_inventory ) {
						$cart_item['data']->set_price( $common_value );
					}
				}
			}
		}

	}


	/**
	 * Wholesale_add_to_cart_message
	 * This is function for show admin notices when wholesale price applied
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function wholesale_add_to_cart_message() {
		?>
			<div class="woocommerce-message">
				<p>Wholesale price Applied</p>
			</div>
		<?php
	}
}
