/**
 * All of the code for your admin-facing JavaScript source
 * should reside in this file.
 *
 * Note: It has been assumed you will write jQuery code here, so the
 * $ function reference has been prepared for usage within the scope
 * of this function.
 *
 * This enables you to define handlers, for when the DOM is ready:
 *
 * $(function() {
 *
 * });
 *
 * When the window is loaded:
 *
 * $( window ).load(function() {
 *
 * });
 *
 * ...and/or other possibilities.
 *
 * Ideally, it is not considered best practise to attach more than a
 * single DOM-ready or window-load handler for a particular page.
 * Although scripts in the WordPress core, Plugins and Themes may be
 * practising this, we should strive to set a better example in our own work.
 */
	jQuery( document ).ready(
		function($) {
			$( "#wholesale_inventory_checkbox" ).change(
				function(){
					$( ".forminp-radio" ).hide();
					$( ".titledesc" ).hide();
					var checked1 = $( this ).is( ":checked" );
					if (checked1) {
						$( ".forminp-radio" ).show();
					}
				}
			);
			$( 'input[name="wholesale_inventory_radio"]' ).change(
				function(){
					$check2 = $( 'input[name="wholesale_inventory_radio"]:checked' ).val();
					if ($check2 == "no") {
						$( "#setcommon_wholesale_textfield" ).show();
					} else {
						$( "#setcommon_wholesale_textfield" ).hide();
					}
				}
			)

			$( "#approve_wholesaler" ).change(
				function(){
					var userid = $( "#userid" ).val();
					jQuery.ajax(
						{
							type:'POST',
							url:frontendajax.ajaxurl,
							data:{
								action:'brand_action',
								userid:userid,
							},
							success:function(data){
								console.log( data );
								$( "#user-" + userid ).find( "td:eq(3)" ).text( "wholesaler" );
								$( "#user-" + userid ).find( "td:eq(5)" ).text( "__" );
							}
						}
					)
				}
			);

			$( '.forminp-text' ).append( '<span class="notice"></span>' );
			$( ".woocommerce-save-button" ).click(
				function(e) {
					e.preventDefault();
					var num = $( "#setcommon_wholesale_textfield" ).val();
					num     = parseInt( num );

					if (num < 10) {

						$( ".notice" ).css( "color", "red" );
						$( ".notice" ).css( "border", "none" );
						$( ".forminp-text" )
						$( ".notice" ).html( "value should be greater or equal to 10" );

					} else {

						$( ".woocommerce-save-button" ).off();
					}

				}
			);
			$( "._wholesallers_price_field" ).append( '<span class="notice1"></span>' );
			$( "#publish" ).click(
				function(e){
					e.preventDefault();
					var reg_price   = $( "#_regular_price" ).val();
					var whole_price = $( "#_wholesallers_price" ).val();
					var invn        = $( "#_wholesallers_price_inventory" ).val();
					reg_price       = parseInt( reg_price );
					whole_price     = parseInt( whole_price );
					invn            = parseInt( invn );
					if (whole_price > reg_price) {
						$( ".notice1" ).css( "color", "red" );
						$( ".notice1" ).css( "border", "none" );
						$( ".notice1" ).html( "value should be greater or equal to Regular price" );
					} else if (invn < 0) {
						$( ".notice1" ).css( "color", "red" );
						$( ".notice1" ).css( "border", "none" );
						$( ".notice1" ).html( "Inventory should be greater or equal to 0" );
					} else {
						$( "#post" ).submit();
					}
				}
			)
			$( ".save-variation-changes" ).after( '<span class="notice2"></span>' );

		}
	);
