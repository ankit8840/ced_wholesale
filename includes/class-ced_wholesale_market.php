<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Ced_wholesale_market
 * @subpackage Ced_wholesale_market/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ced_wholesale_market
 * @subpackage Ced_wholesale_market/includes
 * author     cedcoss <woocommerce@cedcoss.com>
 */
class Ced_wholesale_market {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      Ced_wholesale_market_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CED_WHOLESALE_MARKET_VERSION' ) ) {
			$this->version = CED_WHOLESALE_MARKET_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ced_wholesale_market';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ced_wholesale_market_Loader. Orchestrates the hooks of the plugin.
	 * - Ced_wholesale_market_i18n. Defines internationalization functionality.
	 * - Ced_wholesale_market_Admin. Defines all hooks for the admin area.
	 * - Ced_wholesale_market_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ced_wholesale_market-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ced_wholesale_market-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ced_wholesale_market-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ced_wholesale_market-public.php';

		$this->loader = new Ced_Wholesale_Market_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ced_wholesale_market_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ced_wholesale_market_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ced_Wholesale_Market_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// This is a hook for add custom role of user which name is wholesaler
		$this->loader->add_action( 'admin_init', $plugin_admin, 'ced_wholesale_role' );
		// This is a hook for add setting tab on woocommerce setting page which name is wholesale
		$this->loader->add_filter( 'woocommerce_settings_tabs_array', $plugin_admin, 'ced_nav_menu_wholesale_market', 50, 9 );
		// This is a hook for add sab menus of setting tab which name is general and inventory
		$this->loader->add_action( 'woocommerce_sections_wholesale', $plugin_admin, 'output_sections' );
		// This is a hook for display sab menus setting
		 $this->loader->add_action( 'woocommerce_settings_wholesale', $plugin_admin, 'output' );
		// This is a hook for save all custom settings which name is general and Inventory
		 $this->loader->add_action( 'woocommerce_settings_save_wholesale', $plugin_admin, 'save' );
		// This is a hook for display wholesale settings on simple product edit page
		 $this->loader->add_action( 'woocommerce_product_options_pricing', $plugin_admin, 'ced_wholesale_display_textfiled' );
		// This is a hook for display wholesale settings on each variable product edit page
		 $this->loader->add_action( 'woocommerce_product_after_variable_attributes', $plugin_admin, 'ced_wholesale_display_textfiled_variable_product', 0, 3 );
		// This is a hook for save wholesale setting data of simple product into post meta table
		 $this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'save_ced_wholesale_display_textfiled' );
		// This is a hook for save wholesale setting of each variable
		 $this->loader->add_action( 'woocommerce_save_product_variation', $plugin_admin, 'save_wholesale_display_textfiled_variable_product', 10, 2 );
		// This a hook for add custom column on users table
		 $this->loader->add_filter( 'manage_users_columns', $plugin_admin, 'add_wholesaler_coloumn' );
		// This is a hook for add custom data on custom column which name is wholesaler
		 $this->loader->add_filter( 'manage_users_custom_column', $plugin_admin, 'ced_wholesaler_approved_coloumn', 10, 3 );
		// This is a hook for use ajax which will help for approve wholesalers requests
		 $this->loader->add_action( 'wp_ajax_brand_action', $plugin_admin, 'add_wholesaler' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ced_Wholesale_Market_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		// This is a hook for add checkbox on register page for wholesale customers
		$this->loader->add_action( 'woocommerce_register_form', $plugin_public, 'ced_add_wholesale_registerpage' );
		// This is a hook for register customer if customer register as a wholesaler
		$this->loader->add_action( 'woocommerce_created_customer', $plugin_public, 'ced_register_wholesalebox' );
		// This is a hook for display wholesale price of product this will run on product single page
		$this->loader->add_action( 'woocommerce_single_product_summary', $plugin_public, 'ced_display_wholesale_price', 15 );
		// This is a hook for display wholesale price of product this will run on shop page
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'ced_display_wholesale_price_shoppage' );
		// This is a hook for display wholesale price of each variation product
		$this->loader->add_filter( 'woocommerce_available_variation', $plugin_public, 'variation_price_custom_suffix', 10, 3 );
		// This is a hook for applying wholesale price on cart page if quantity increase
		$this->loader->add_action( 'woocommerce_before_calculate_totals', $plugin_public, 'add_custom_price_of_wholesale', 20, 1 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ced_wholesale_market_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
