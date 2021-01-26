<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Ced_wholesale_market
 * @subpackage Ced_wholesale_market/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ced_wholesale_market
 * @subpackage Ced_wholesale_market/admin
 * author     cedcoss <woocommerce@cedcoss.com>
 */
class Ced_Wholesale_Market_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_wholesale_market-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_wholesale_market-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'frontendajax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'name'    => 'Ankit',
				'nonce'   => 'ced_ajax',
			)
		);

	}


	/**
	 * Ced_nav_menu_wholesale_market
	 * This is a function for add new setting tab on woocommerce which name is wholesale
	 *
	 * @param  mixed $settings_tabs
	 * @return void
	 * @since 1.0.0
	 */
	public function ced_nav_menu_wholesale_market( $settings_tabs ) {
		$settings_tabs['wholesale'] = __( 'wholesale', 'woocommerce-settings-tab-demo' );
		return $settings_tabs;
	}


	/**
	 * Ced_add_submenus_wholesale_sections
	 * This is a function for add sub menus of setting which name is general and inventory
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function ced_add_submenus_wholesale_sections() {
		global $current_section;

			$sections = array(
				''          => 'General',
				'Inventory' => 'Inventory',
			);

			if ( empty( $sections ) || 1 === count( $sections ) ) {
				return;
			}

			echo '<ul class="subsubsub">';

			$array_keys = array_keys( $sections );

			foreach ( $sections as $id => $label ) {
				echo '<li><a href="' . esc_url( admin_url( 'admin.php?page=wc-settings& tab=wholesale & section=' . sanitize_title( $id ) ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . esc_html( $label ) . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
			}

			echo '</ul><br class="clear" />';
	}


	/**
	 * Get_settings
	 * This is a function for add setting data which will contain general setting and Inventory setting
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function get_settings() {
		global $current_section;
		if ( '' == $current_section ) {

			/**
			 * Filter Plugin Section 2 Settings
			 *
			 * @since 1.0.0
			 * @param array $settings Array of the plugin settings
			 */
			$settings = apply_filters(
				'myplugin_section2_settings',
				array(

					array(
						'name' => __( 'Wholesale_General_settings', 'my-textdomain' ),
						'type' => 'title',
						'desc' => '',
						'id'   => 'wholesale_group1_options',
					),

					array(
						'type'    => 'checkbox',
						'id'      => 'checkbox_wholesale_setting',
						'name'    => __( 'Do a thing?', 'my-textdomain' ),
						'desc'    => __( 'Enable For wholesale pricing setting', 'my-textdomain' ),
						'default' => 'no',
					),

					array(
						'type' => 'sectionend',
						'id'   => 'checkbox_wholesale_setting_options',
					),

					array(
						'name' => __( 'Wholesale_General_settings', 'my-textdomain' ),
						'type' => 'title',
						'desc' => '',
						'id'   => 'wholesale_group2_options',
					),

					array(
						'title'    => __( 'Display wholesale prices', 'woocommerce' ),
						'id'       => 'woocommerce_wholesale_radio_button',
						'default'  => 'no',
						'type'     => 'radio',
						'desc_tip' => __( 'This option is important as it will affect how you will show wholesales prices', 'woocommerce' ),
						'options'  => array(
							'yes' => __( 'For Display Wholesale Price for all users', 'woocommerce' ),
							'no'  => __( 'For Display Wholesale Price for all customers', 'woocommerce' ),
						),
					),
					array(
						'title'       => __( 'what text should be shown with Wholesale Price?', 'woocommerce' ),
						'id'          => 'woocommerce_wholesale_textfield',
						'default'     => '',
						'placeholder' => __( 'N/A', 'woocommerce' ),
						'type'        => 'text',
						'desc_tip'    => __( 'Define text to show after your product prices. This could be, for example, "inc. Vat" to explain your pricing. You can also have prices substituted here using one of the following: {price_including_tax}, {price_excluding_tax}.', 'woocommerce' ),
					),
					array(
						'type' => 'sectionend',
						'id'   => 'wholesale_plugin_demo1',
					),

				)
			);

		} else {

			/**
			 * Filter Plugin Section 1 Settings
			 * This else part will contain Inventory setting
			 *
			 * @since 1.0.0
			 * @param array $settings Array of the plugin settings
			 */
			$settings = apply_filters(
				'myplugin_section1_settings',
				array(

					array(
						'name' => __( 'Wholesale_Inventory_settings', 'my-textdomain' ),
						'type' => 'title',
						'desc' => '',
						'id'   => 'wholesale_inventory_section_setting',
					),

					array(
						'type'    => 'checkbox',
						'id'      => 'wholesale_inventory_checkbox',
						'name'    => __( 'Do a thing?', 'my-textdomain' ),
						'desc'    => __( 'Enable min. qty setting for applying wholesale price', 'my-textdomain' ),
						'default' => 'no',
					),
					array(
						'title'    => __( 'Display wholesale prices', 'woocommerce' ),
						'id'       => 'wholesale_inventory_radio',
						'default'  => 'no',
						'type'     => 'radio',
						'desc_tip' => __( 'This option is important as it will affect how you will show wholesales prices', 'woocommerce' ),
						'options'  => array(
							'yes' => __( 'Set Min qty on product level', 'woocommerce' ),
							'no'  => __( 'Set common min qty for all products.', 'woocommerce' ),
						),
					),
					array(
						'title'       => __( 'what text should be shown with Wholesale Price?', 'woocommerce' ),
						'id'          => 'setcommon_wholesale_textfield',
						'default'     => '',
						'placeholder' => __( 'set common minimum quantity', 'woocommerce' ),
						'type'        => 'text',
						'desc_tip'    => __( 'Define text to show after your product prices. This could be, for example, "inc. Vat" to explain your pricing. You can also have prices substituted here using one of the following: {price_including_tax}, {price_excluding_tax}.', 'woocommerce' ),
					),
					array(
						'type' => 'sectionend',
						'id'   => 'wholesale_plugin_demo2',
					),

				)
			);

		}

		/**
		 * Filter MyPlugin Settings
		 *
		 * @since 1.0.0
		 * @param array $settings Array of the plugin settings
		 */
		return apply_filters( 'woocommerce_get_settings_wholesale', $settings, $current_section );

	}
	/**
	 * Output the settings
	 * This is a output function for display custom settings data
	 *
	 * @since 1.0.0
	 */
	public function output() {

		global $current_section;

		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::output_fields( $settings );
	}


	/**
	 * Save
	 * This is a save function for save all setting data into option table
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function save() {

		global $current_section;

		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::save_fields( $settings );
	}


	/**
	 * Ced_wholesale_display_textfiled
	 * This is a function for display wholesale textfiled on product edit pages of simple products
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function ced_wholesale_display_textfiled() {
		global $post;
		$check_wholesale_setting            = get_option( 'checkbox_wholesale_setting' );
		$check_wholesale_inventory_radio    = get_option( 'wholesale_inventory_radio' );
		$check_wholesale_inventory_checkbox = get_option( 'wholesale_inventory_checkbox' );
		if ( 'yes' == $check_wholesale_setting ) {
			woocommerce_wp_text_input(
				array(
					'id'                => '_wholesallers_price',
					'value'             => get_post_meta( $post->ID, '_wholesallers_price', true ),
					'label'             => __( 'wholesallers', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
					'type'              => 'number',
					'custom_attributes' => array(
						'step' => '1',
						'min'  => '0',
					),
					'data_type'         => 'price',
				)
			);
			woocommerce_wp_text_input(
				array(
					'id'          => 'wholesale_nonce_for_simple',
					'value'       => wp_create_nonce( 'generate_nonce' ),
					'label'       => '',
					'placeholder' => '',
					'type'        => 'hidden',
				)
			);
			if ( 'yes' == $check_wholesale_inventory_radio && 'yes' == $check_wholesale_inventory_checkbox ) {
				woocommerce_wp_text_input(
					array(
						'id'                => '_wholesallers_price_inventory',
						'value'             => get_post_meta( $post->ID, '_wholesallers_price_inventory', true ),
						'label'             => __( 'wholesale Inventory', 'woocommerce' ),
						'type'              => 'number',
						'custom_attributes' => array(
							'step' => '1',
							'min'  => '0',
						),
						'data_type'         => 'price',
					)
				);
			}
		}
	}

	/**
	 * Ced_wholesale_display_textfiled_variable_product
	 * This is a function for display wholesale and inventory filed on each variation of product edit page
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function ced_wholesale_display_textfiled_variable_product( $loop, $variation_data, $variation ) {
		$check_wholesale_setting = get_option( 'checkbox_wholesale_setting' );
		if ( 'yes' == $check_wholesale_setting ) {
			woocommerce_wp_text_input(
				array(
					'id'                => "checkbox_wholesale_setting_input{$loop}",
					'name'              => "checkbox_wholesale_setting_input[{$loop}]",
					'value'             => get_post_meta( $variation->ID, 'checkbox_wholesale_setting_input', true ),
					'label'             => __( 'wholesale', 'woocommerce' ),
					'placeholder'       => __( 'wholesale', 'woocommerce' ),
					'description'       => __( 'Leave blank for unlimited re-downloads.', 'woocommerce' ),
					'type'              => 'number',
					'desc_tip'          => true,
					'custom_attributes' => array(
						'step' => '1',
						'min'  => '0',
					),
					'wrapper_class'     => 'form-row form-row-first',
				)
			);

			woocommerce_wp_text_input(
				array(
					'id'          => 'wholesale_nonce',
					'value'       => wp_create_nonce( 'generate_nonce' ),
					'label'       => '',
					'placeholder' => '',
					'type'        => 'hidden',
				)
			);

			woocommerce_wp_text_input(
				array(
					'id'                => "checkbox_wholesale_setting_input{$loop}",
					'name'              => "checkbox_wholesale_inventory_input[{$loop}]",
					'value'             => get_post_meta( $variation->ID, 'checkbox_wholesale_inventory_input', true ),
					'label'             => __( 'wholesale_Inventory', 'woocommerce' ),
					'placeholder'       => __( 'wholesale', 'woocommerce' ),
					'description'       => __( 'Leave blank for unlimited re-downloads.', 'woocommerce' ),
					'type'              => 'number',
					'desc_tip'          => true,
					'custom_attributes' => array(
						'step' => '1',
						'min'  => '0',
					),
					'wrapper_class'     => 'form-row form-row-first',
				)
			);
		}
	}

	/**
	 * Save_ced_wholesale_display_textfiled
	 * This is a function for save the data of wholesale field for simple product into post_meta table'.
	 *
	 * @param  mixed $post_id
	 * @return void
	 * @since 1.0.0
	 */
	public function save_ced_wholesale_display_textfiled( $post_id ) {
		if ( isset( $_POST['wholesale_nonce_for_simple'] ) && wp_verify_nonce( sanitize_text_field( $_POST['wholesale_nonce_for_simple'], 'wholesale_nonce_for_simple' ) ) ) {
			$product                          = wc_get_product( $post_id );
			$custom_fields_woocommerce_title1 = sanitize_text_field( isset( $_POST['_wholesallers_price'] ) ? $_POST['_wholesallers_price'] : '' );
			$custom_fields_woocommerce_title2 = sanitize_text_field( isset( $_POST['_wholesallers_price_inventory'] ) ? $_POST['_wholesallers_price_inventory'] : '' );
			$regular_price                    = sanitize_text_field( isset( $_POST['_regular_price'] ) ? $_POST['_regular_price'] : '' );
			if ( $regular_price < $custom_fields_woocommerce_title1 ) {
				wp_die( 'wholesale price should be less then or equal to regular price' );
			} elseif ( $custom_fields_woocommerce_title2 < 0 ) {
				wp_die( 'Inventory shoulb be greater then 0' );
			}
			$custom_fields_woocommerce_title1;

			$product->update_meta_data( '_wholesallers_price', sanitize_text_field( $custom_fields_woocommerce_title1 ) );
			$product->update_meta_data( '_wholesallers_price_inventory', sanitize_text_field( $custom_fields_woocommerce_title2 ) );
			$product->save();
		}
	}


	/**
	 * Save_wholesale_display_textfiled_variable_product
	 * This is function for save wholesale filed data of all variation products
	 *
	 * @param  mixed $post_id->this will contain post id
	 * @param  mixed $i->This is for loop start with 0
	 * @return void
	 * @since 1.0.0
	 */
	public function save_wholesale_display_textfiled_variable_product( $post_id, $i ) {
		if ( isset( $_POST['wholesale_nonce'] ) && wp_verify_nonce( sanitize_text_field( $_POST['wholesale_nonce'], 'wholesale_nonce' ) ) ) {
			if ( isset( $_POST['variable_regular_price'][ $i ] ) ) {
				$regularprice = sanitize_text_field( $_POST['variable_regular_price'][ $i ] ? $_POST['variable_regular_price'][ $i ] : '' );
			}
			if ( isset( $_POST['checkbox_wholesale_setting_input'][ $i ] ) ) {
				$woocommerce_text_field1 = sanitize_text_field( $_POST['checkbox_wholesale_setting_input'][ $i ] ? $_POST['checkbox_wholesale_setting_input'][ $i ] : '' );
			}
			if ( isset( $_POST['checkbox_wholesale_inventory_input'][ $i ] ) ) {
				$woocommerce_text_field2 = sanitize_text_field( $_POST['checkbox_wholesale_inventory_input'][ $i ] ? $_POST['checkbox_wholesale_inventory_input'][ $i ] : '' );
			}
			if ( $regularprice < $woocommerce_text_field1 ) {
				// wp_die("wholesale price should be less then or equal to regular price");
				return false;
			} elseif ( $woocommerce_text_field2 < 0 ) {
				// wp_die("Inventory shoulb be greater then 0");
				return false;
			}
			update_post_meta( $post_id, 'checkbox_wholesale_setting_input', esc_attr( $woocommerce_text_field1 ) );
			update_post_meta( $post_id, 'checkbox_wholesale_inventory_input', esc_attr( $woocommerce_text_field2 ) );
		}
	}


	/**
	 * Add_wholesaler_coloumn
	 * This is a function for add custom column in user table which name is wholesale
	 *
	 * @param  mixed $column->will contain column name
	 * @return void
	 * @since 1.0.0
	 */
	public function add_wholesaler_coloumn( $column ) {

		$column['wholesale'] = 'wholesaler';
		return $column;
	}

	/**
	 * Ced_wholesaler_approved_coloumn
	 * This is a function for add custom column data
	 *
	 * @param  mixed $value->This variable will return data which will add on column
	 * @param  mixed $column_name->This will contain all column name of user table
	 * @param  mixed $user_id->This will contain user's ID
	 * @return void
	 * @since 1.0.0
	 */
	public function ced_wholesaler_approved_coloumn( $value, $column_name, $user_id ) {
		if ( 'wholesale' == $column_name ) {
			$getdata   = get_user_meta( $user_id, 'wholesaler_customer', 1 );
			$user_meta = get_userdata( $user_id );
			if ( 'on' == $getdata ) {
				$value = '<input type="hidden" value=' . $user_id . ' id="userid" "><label class="switch"><input type="checkbox" id="approve_wholesaler"><span class="slider round"></span></label>';
			} else {
				$value = '__';
			}
			return $value;
		}
	}
	/**
	 * Ced_wholesale_role
	 * This is a function of add custom role of user which name is wholesaler
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function ced_wholesale_role() {
		add_role(
			'wholesaler',
			'wholesaler',
			array(
				'read'    => true,
				'level_0' => true,
			)
		);
	}
	/**
	 * Add_wholesaler
	 * This is a function for approve user's request for wholesalers
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function add_wholesaler() {
		if ( isset( $_POST['userid'] ) ) {
			$userid = sanitize_text_field( $_POST['userid'] );
		}
		$u                = new WP_User( $userid );
		$get_current_role = get_user_meta( $userid, 'wp_capabilities', 1 );
		update_user_meta( $userid, 'wholesaler_customer', '' );
		$u->remove_role( $get_current_role );
		$u->set_role( 'wholesaler' );
		echo esc_html( $userid );

	}

}
