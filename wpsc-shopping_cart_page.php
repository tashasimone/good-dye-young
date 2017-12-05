<?php
global $wpsc_cart, $wpdb, $wpsc_checkout, $wpsc_gateway, $wpsc_coupons, $wpsc_registration_error_messages;
$wpsc_checkout = new wpsc_checkout();
$alt = 0;
$coupon_num = wpsc_get_customer_meta( 'coupon' );
if( $coupon_num )
   $wpsc_coupons = new wpsc_coupons( $coupon_num );

if(wpsc_cart_item_count() < 1) :
   echo __('Oops, there is nothing in your cart.', 'wp-e-commerce') . '<a href=' . esc_url( get_option( 'product_list_url', '' ) ) . ">" . __('Please visit our shop', 'wp-e-commerce') . '</a>';
   return;
endif;
?>
<div id="checkout_page_container">
    
    
<div class="col-md-7 col-xs-12">
        
<h3><?php _e('Review your order', 'wp-e-commerce'); ?></h3>
<table class="checkout_cart table table-striped table-hover">
   <tr class="header">
      <th colspan="2"  style="text-align:left;"><?php _e('Product', 'wp-e-commerce'); ?></th>
      <th style="text-align:left;"><?php _e('Quantity', 'wp-e-commerce'); ?></th>
      <th style="text-align:left;"><?php _e('Price', 'wp-e-commerce'); ?></th>
      <th style="text-align:left;" class="hidden-xs"><?php _e('Total', 'wp-e-commerce'); ?></th>
        <th>&nbsp;</th>
   </tr>
   <?php while (wpsc_have_cart_items()) : wpsc_the_cart_item(); ?>
      <?php
       $alt++;
       if ($alt %2 == 1)
         $alt_class = 'alt';
       else
         $alt_class = '';
       ?>
      <?php  //this displays the confirm your order html ?>

     <?php do_action ( "wpsc_before_checkout_cart_row" ); ?>
      <tr class="product_row product_row_<?php echo wpsc_the_cart_item_key(); ?> <?php echo $alt_class;?>">

         <td class="firstcol hidden-xs wpsc_product_image wpsc_product_image_<?php echo wpsc_the_cart_item_key(); ?>">
         <?php if('' != wpsc_cart_item_image()): ?>
         <?php do_action ( "wpsc_before_checkout_cart_item_image" ); ?>
            <img src="<?php echo wpsc_cart_item_image(); ?>" alt="<?php echo wpsc_cart_item_name(); ?>" title="<?php echo wpsc_cart_item_name(); ?>" class="product_image" />
         <?php do_action ( "wpsc_after_checkout_cart_item_image" ); ?>
         <?php else:
         /* I dont think this gets used anymore,, but left in for backwards compatibility */
         ?>
            <div class="item_no_image">
            <?php do_action ( "wpsc_before_checkout_cart_item_image" ); ?>
               <a href="<?php echo esc_url( wpsc_the_product_permalink() ); ?>">
               <span><?php _e('No Image','wp-e-commerce'); ?></span>

               </a>
            <?php do_action ( "wpsc_after_checkout_cart_item_image" ); ?>
            </div>
         <?php endif; ?>
         </td>

         <td class="wpsc_product_name wpsc_product_name_<?php echo wpsc_the_cart_item_key(); ?>">
         <?php do_action ( "wpsc_before_checkout_cart_item_name" ); ?>
            <a href="<?php echo esc_url( wpsc_cart_item_url() );?>"><?php echo wpsc_cart_item_name(); ?></a>
         <?php do_action ( "wpsc_after_checkout_cart_item_name" ); ?>
         </td>

         <td class="wpsc_product_quantity wpsc_product_quantity_<?php echo wpsc_the_cart_item_key(); ?>">
            <form action="<?php echo esc_url( get_option( 'shopping_cart_url' ) ); ?>" method="post" class="adjustform qty">
               <input type="text" name="quantity" size="2" value="<?php echo wpsc_cart_item_quantity(); ?>" />
               <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
               <input type="hidden" name="wpsc_update_quantity" value="true" />
               <input type='hidden' name='wpsc_ajax_action' value='wpsc_update_quantity' />
               <input type="submit" value="<?php _e('Update', 'wp-e-commerce'); ?>" class="btn btn-primary btn-sm hidden-xs" />
            </form>
         </td>


            <td><?php echo wpsc_cart_single_item_price(); ?></td>
         <td class="hidden-xs wpsc_product_price wpsc_product_price_<?php echo wpsc_the_cart_item_key(); ?>"><span class="pricedisplay"><?php echo wpsc_cart_item_price(); ?></span></td>

         <td class="wpsc_product_remove wpsc_product_remove_<?php echo wpsc_the_cart_item_key(); ?>">
            <form action="<?php echo esc_url( get_option( 'shopping_cart_url' ) ); ?>" method="post" class="adjustform remove">
               <input type="hidden" name="quantity" value="0" />
               <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
               <input type="hidden" name="wpsc_update_quantity" value="true" />
               <input type='hidden' name='wpsc_ajax_action' value='wpsc_update_quantity' />
               <input type="submit" value="<?php _e('Remove', 'wp-e-commerce'); ?>" class="btn btn-primary btn-sm"/>
            </form>
         </td>
      </tr>
	  <?php do_action ( "wpsc_after_checkout_cart_row" ); ?>
   <?php endwhile; ?>
   <?php //this HTML displays coupons if there are any active coupons to use ?>

	<?php do_action ( 'wpsc_after_checkout_cart_rows' ); ?>

   
   </table>
        
       <table class='wpsc_checkout_table wpsc_checkout_table_totals'>
      <?php if(wpsc_uses_shipping()) : ?>
	      <tr class="total_price total_shipping">
	         <td class='wpsc_totals'>
	            <?php _e('Total Shipping:', 'wp-e-commerce'); ?>
	         </td>
	         <td class='wpsc_totals'>
	            <span id="checkout_shipping" class="pricedisplay checkout-shipping"><?php echo wpsc_cart_shipping(); ?></span>
	         </td>
	      </tr>
      <?php endif; ?>

    
   <tr class='total_price'>
      <td class='wpsc_totals'>
      <?php _e('Total Price:', 'wp-e-commerce'); ?>
      </td>
      <td class='wpsc_totals'>
         <span id='checkout_total' class="pricedisplay checkout-total"><?php echo wpsc_cart_total(); ?></span>
      </td>
   </tr>
   </table>
</div>
   <!-- cart contents table close -->
  <?php if(wpsc_uses_shipping()): ?>
	   <p class="wpsc_cost_before"></p>
   <?php endif; ?>
   <?php  //this HTML dispalys the calculate your order HTML   ?>

   

   <?php if(isset($_SESSION['WpscGatewayErrorMessage']) && $_SESSION['WpscGatewayErrorMessage'] != '') :?>
      <p class="validation-error"><?php echo $_SESSION['WpscGatewayErrorMessage']; ?></p>
   <?php
   endif;
   ?>

   <?php do_action('wpsc_before_shipping_of_shopping_cart'); ?>

   <div id="wpsc_shopping_cart_container" class="col-md-5 col-xs-12">
   <?php if(wpsc_uses_shipping()) : ?>
      <h2><?php _e('Calculate Shipping Price', 'wp-e-commerce'); ?></h2>
      <table class="productcart">
         <tr class="wpsc_shipping_info">
            <td colspan="5">
               <?php _e('Please specify shipping location below to calculate your shipping costs', 'wp-e-commerce'); ?>
            </td>
         </tr>

         
         <tr class='wpsc_change_country'>
            <td colspan='5'>
               <form name='change_country' id='change_country' action='' method='post'>
                  <?php echo wpsc_shipping_country_list();?>
                  <input type='hidden' name='wpsc_update_location' value='true' />
                  <input type='submit' name='wpsc_submit_zipcode' value='<?php esc_attr_e( 'Calculate', 'wp-e-commerce' ); ?>' />
               </form>
            </td>
         </tr>



         <?php if (!wpsc_have_shipping_quote()) : // No valid shipping quotes ?>
               </table>
               </div>
</div>


            <?php return; ?>
         <?php endif; ?>
   <?php endif;  ?>

   <?php
      $wpec_taxes_controller = new wpec_taxes_controller();
      if($wpec_taxes_controller->wpec_taxes_isenabled()):
   ?>
      <table class="productcart">
         <tr class="total_price total_tax">
            <td colspan="3">
               <?php echo wpsc_display_tax_label(true); ?>
            </td>
            <td colspan="2">
               <span id="checkout_tax" class="pricedisplay checkout-tax"><?php echo wpsc_cart_tax(); ?></span>
            </td>
         </tr>
      </table>
   <?php endif; ?>
   <?php do_action('wpsc_before_form_of_shopping_cart'); ?>


	


<div>
	<form class='wpsc_checkout_forms form-horizontal' action='<?php echo esc_url( get_option( 'shopping_cart_url' ) ); ?>' method='post' enctype="multipart/form-data">
      <?php
      /**
       * Both the registration forms and the checkout details forms must be in the same form element as they are submitted together, you cannot have two form elements submit together without the use of JavaScript.
      */
      ?>

    <?php if(wpsc_show_user_login_form()):
          global $current_user;
          get_currentuserinfo();   ?>

        <div class="clear"></div>
   <?php endif; // closes user login form
      $misc_error_messages = wpsc_get_customer_meta( 'checkout_misc_error_messages' );
      if( ! empty( $misc_error_messages ) ): ?>
         <div class='login_error'>
            <?php foreach( $misc_error_messages as $user_error ){?>
               <p class='validation-error'><?php echo $user_error; ?></p>
               <?php } ?>
         </div>

      <?php
      endif;
      ?>
<?php ob_start(); ?>
   <ul class='wpsc_checkout_table table-1'>
      <?php $i = 0;
      while (wpsc_have_checkout_items()) : wpsc_the_checkout_item(); ?>

        <?php if(wpsc_checkout_form_is_header() == true){
               $i++;
               //display headers for form fields ?>
               <?php if($i > 1):?>
                  </ul>
                  <ul class='wpsc_checkout_table table-<?php echo $i; ?>'>
               <?php endif; ?>

               <li <?php echo wpsc_the_checkout_item_error_class();?>>
                  <div <?php wpsc_the_checkout_details_class(); ?> colspan='2'>
                     <h4><?php echo wpsc_checkout_form_name();?></h4>
                  </div>
               </li>
               <?php if(wpsc_is_shipping_details()):?>
               <li  class="control-label" class='same_as_shipping_row'>
                  <div colspan ='2'>
                  <?php $checked = '';
                  $shipping_same_as_billing = wpsc_get_customer_meta( 'shipping_same_as_billing' );
                  if(isset($_POST['shippingSameBilling']) && $_POST['shippingSameBilling'])
                     $shipping_same_as_billing = true;
                  elseif(isset($_POST['submit']) && !isset($_POST['shippingSameBilling']))
                  	$shipping_same_as_billing = false;
                  wpsc_update_customer_meta( 'shipping_same_as_billing', $shipping_same_as_billing );
                  	if( $shipping_same_as_billing )
                  		$checked = 'checked="checked"';
                   ?>
					<label  class="control-label" for='shippingSameBilling'><?php _e('Same as billing address:','wp-e-commerce'); ?></label>
					<input type='checkbox'  data-wpsc-meta-key="shippingSameBilling" value='true' class= "wpsc-visitor-meta form-control" name='shippingSameBilling' id='shippingSameBilling' <?php echo $checked; ?> />
					<br/><span id="shippingsameasbillingmessage"><?php _e('Your order will be shipped to the billing address', 'wp-e-commerce'); ?></span>
                  </div>
               </li>
               <?php endif;

            // Not a header so start display form fields
            }elseif( $wpsc_checkout->checkout_item->unique_name == 'billingemail'){ ?>
               <?php $email_markup =
               "<div class='clearfix wpsc_email_address'>
                  <p class='" . wpsc_checkout_form_element_id() . "'>
                     <label class='wpsc_email_address control-label' for='" . wpsc_checkout_form_element_id() . "'>
                     " . __('Enter your email address', 'wp-e-commerce') . "
                     </label>
                  <p class='wpsc_email_address_p'>
                  <img src='https://secure.gravatar.com/avatar/empty?s=60&amp;d=mm' id='wpsc_checkout_gravatar' />
                  " . wpsc_checkout_form_field();

                   if(wpsc_the_checkout_item_error() != '')
                      $email_markup .= "<p class='validation-error'>" . wpsc_the_checkout_item_error() . "</p>";
               $email_markup .= "</div>";
             }else{ ?>
			<li>
               <div class='<?php echo wpsc_checkout_form_element_id(); ?>'>
                  <label for='<?php echo wpsc_checkout_form_element_id(); ?>'>
                  <?php echo wpsc_checkout_form_name();?>
                  </label>
               </div>
               <div>
                  <?php echo wpsc_checkout_form_field();?>
                   <?php if(wpsc_the_checkout_item_error() != ''): ?>
                          <p class='validation-error'><?php echo wpsc_the_checkout_item_error(); ?></p>
                  <?php endif; ?>
               </div>
            </li>

         <?php }//endif; ?>

      <?php endwhile; ?>

<?php
	$buffer_contents = ob_get_contents();
	ob_end_clean();
	if(isset($email_markup))
		echo $email_markup;
	echo $buffer_contents;
?>

      <?php if (wpsc_show_find_us()) : ?>
      <li>
         <div><label for='how_find_us'><?php _e('How did you find us' , 'wp-e-commerce'); ?></label></td>
         <div>
            <select name='how_find_us'>
               <option value='Word of Mouth'><?php _e('Word of mouth' , 'wp-e-commerce'); ?></option>
               <option value='Advertisement'><?php _e('Advertising' , 'wp-e-commerce'); ?></option>
               <option value='Internet'><?php _e('Internet' , 'wp-e-commerce'); ?></option>
               <option value='Customer'><?php _e('Existing Customer' , 'wp-e-commerce'); ?></option>
            </select>
         </div>
      </li>
      <?php endif; ?>
      <?php do_action('wpsc_inside_shopping_cart'); ?>

      <?php  //this HTML displays activated payment gateways   ?>
      <?php if(wpsc_gateway_count() > 1): // if we have more than one gateway enabled, offer the user a choice ?>
         <li>
            <div colspan='2' class='wpsc_gateway_container'>
               <h3><?php _e('Payment Type', 'wp-e-commerce');?></h3>
               <?php wpsc_gateway_list(); ?>
               </div>
         </li>
      <?php else: // otherwise, there is no choice, stick in a hidden form ?>
         <li>
            <div colspan="2" class='wpsc_gateway_container'>
               <?php wpsc_gateway_hidden_field(); ?>
            </div>
         </li>
      <?php endif; ?>

      <?php if(wpsc_has_tnc()) : ?>
         <li>
            <div colspan='2'>
                <label for="agree"><input id="agree" type='checkbox' value='yes' name='agree' /> <?php printf(__("I agree to the <a class='thickbox' target='_blank' href='%s' class='termsandconds'>Terms and Conditions</a>", 'wp-e-commerce'), esc_url( home_url( "?termsandconds=true&amp;width=360&amp;height=400" ) ) ); ?> <span class="asterix">*</span></label>
               </div>
         </li>
      <?php endif; ?>
      </ul>

<!-- div for make purchase button -->
      <div class='wpsc_make_purchase'>
         <span>
            <?php if(!wpsc_has_tnc()) : ?>
               <input type='hidden' value='yes' name='agree' />
            <?php endif; ?>
               <input type='hidden' value='submit_checkout' name='wpsc_action' />
               <input type='submit' value='<?php _e('Purchase', 'wp-e-commerce');?>' class='make_purchase wpsc_buy_button btn btn-primary' style="margin-top:30px;"/>
         </span>
      </div>

<div class='clear'></div>
</form>
</div>
</div><!--close checkout_page_container-->
<?php
do_action('wpsc_bottom_of_shopping_cart');
