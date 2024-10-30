<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @link       http://codeixer.com
 * @since      1.0.0
 *
 * @package    Wc_Mmqty
 * @subpackage Wc_Mmqty/inc
 */

add_action('woocommerce_after_add_to_cart_button', 'cix_qty_messages');
add_action('woocommerce_after_shop_loop_item', 'cix_qty_messages');



/*
 * Content below "Add to cart" Button.
 */

function cix_qty_messages(){

    


 $product_id = get_the_ID();

 $min_qty = !empty(get_post_meta( $product_id, '_qty_min', true )) ? get_post_meta( $product_id, '_qty_min', true ) : wc_mmqty_option('min_mmqty_fw') ;  // Minium quantity 

 $max_qty = !empty(get_post_meta( $product_id, '_qty_max', true )) ? get_post_meta( $product_id, '_qty_max', true ) : wc_mmqty_option('max_mmqty_fw');  // Minium quantity 

 $step_qty = !empty(get_post_meta( $product_id, '_qty_step', true )) ? get_post_meta( $product_id, '_qty_step', true ) : wc_mmqty_option('qty_mmqty_fw');  // Step quantity 


  $min_messge = !empty($min_qty) ? wc_mmqty_option('min_messge_fw').'</br>' : '';
  $max_messge = !empty($max_qty) ? wc_mmqty_option('max_messge_fw') .'</br>': '';
  $step_messge = !empty($step_qty) ? wc_mmqty_option('step_messge_fw').'</br>' : '';
 


    echo '<div class="qty-message"><p>'. sprintf($min_messge, $min_qty);

    echo  sprintf($max_messge, $max_qty);

    echo  sprintf($step_messge, $step_qty).'</p></div>'; 

  
}

 add_filter( 'woocommerce_quantity_input_args', 'cix_quantity_input_args', 10, 2 );

add_filter( 'woocommerce_loop_add_to_cart_link', 'cix_add_cart_link_atts', 10, 2 );
function cix_add_cart_link_atts( $link, $product ) {

	// Get default button classes
	if ( $product ) {
		$defaults = array(
			'quantity' => 1,
			'class' => implode( ' ', array_filter( array(
				'button',
				'product_type_' . $product->get_type(),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			) ) ),
		);
	}
    $class = apply_filters( 'woocommerce_loop_add_to_cart_args', $defaults )['class'];


    $product_id = get_the_ID();

    $min_qty = !empty(get_post_meta( $product_id, '_qty_min', true )) ? get_post_meta( $product_id, '_qty_min', true ) : wc_mmqty_option('min_mmqty_fw') ;  // Minium quantity 


    
    $quantity = $min_qty ;

	// WC versions before 3.3 did not have the product description aria-label
	if ( version_compare( get_option( 'woocommerce_version' ), '3.3.0', '<' ) ) {

		$link = sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" data-custom_attribute="%s" class="%s">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( 'some_value' ),
			esc_attr( isset( $class ) ? $class : 'button' ),
			esc_html( $product->add_to_cart_text() )
		);

	} else {

		$link = sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" data-custom_attribute="%s" class="%s" aria-label="%s">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_url( 'some_value' ),
			esc_attr( isset( $class ) ? $class : 'button' ),
			esc_attr( $product->add_to_cart_description() ),
			esc_html( $product->add_to_cart_text() )
		);
	}

	return $link;
}

function cix_quantity_input_args( $args, $product ) {



  global $post,$woocommerce;
  $product_id = $post->ID;
  //  $args['input_value'] = get_post_meta( $product_id, '_qty_min', true );

 
	

    if(is_cart() ){

        if( $product->get_type() == 'variation' ){

            $product_id = $product->get_parent_id();

        }
        else{

            $product_id = $product->get_id();
        }

    
    }
  
    
        $min_qty = get_post_meta( $product_id, '_qty_min', true );  // Minium quantity 

        $max_qty = get_post_meta( $product_id, '_qty_max', true ); // Minium quantity 

        $step_qty = get_post_meta( $product_id, '_qty_step', true );  // Step quantity 
        
        $args['min_value'] =  $min_qty;
        $args['max_value'] = $max_qty;
        $args['step'] =  $step_qty ;

        if($args['input_value'] > $args['max_value'] || $args['input_value'] < $args['min_value']){

         
        }

       
    
       return $args;
    


              
       
}


// define the woocommerce_add_to_cart_validation callback 
function cix_add_to_cart_validation( $true, $product_id, $quantity ) { 

    global $woocommerce;
     // Checking cart items
    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $item_id = $cart_item['data']->get_id();


        $max_qty = get_post_meta( $item_id, '_qty_max', true );  // Maxium quantity 

    
        $cart_item_qty = $max_qty ;
 
       

        
     
      if($product_id == $item_id && $cart_item['quantity'] >= $cart_item_qty) {
         
            $product_name = $cart_item['data']->get_title();

             wc_add_notice( 'Maximum quantity is '.$cart_item_qty .' for "'.$product_name.'"', 'error' );

              wc_add_notice( ''.$cart_item['quantity'].' item of "'.$product_name.'" already in your cart.<a href="'. wc_get_cart_url().'" class="button wc-forward">View cart</a>
              ', 'notice' );

              

             // fw_print($cart_item['data']);
              return; 
      }
   
    
        
    }

    return $true; 
    
}; 
         
// add the filter 
add_filter( 'woocommerce_add_to_cart_validation', 'cix_add_to_cart_validation', 10, 3 ); 


add_action('woocommerce_before_calculate_totals', 'cix_cart_item_quantities', 10, 2 );

function cix_cart_item_quantities ( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;
        

    // HERE below define your specific products IDs
    

    // Checking cart items
       // Checking cart items

    foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_id = $cart_item['data']->get_id();
          

        $min_qty = get_post_meta( $product_id, '_qty_min', true );  // Minium quantity 

        $max_qty = get_post_meta( $product_id, '_qty_max', true ); // Minium quantity 

        $step_qty = get_post_meta( $product_id, '_qty_step', true );  // Step quantity 


       

    
        if(!empty($max_qty) ){
           $new_qty = $max_qty;  // New quantity
           if($cart_item['quantity'] > $new_qty ){

            $cart->set_quantity( $cart_item_key, $new_qty ); // Change quantity

            }
            elseif($cart_item['quantity'] < $min_qty){
                $cart->set_quantity( $cart_item_key, $min_qty ); // Change quantity
            }
       
       

        } else {
          $new_qty = $cart_item['quantity'] ;
        }

        
    }
    
}


