<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://codeixer.com
 * @since      1.0.0
 *
 * @package    Wc_Mmqty
 * @subpackage Wc_Mmqty/inc
 */




 // First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
add_filter( 'woocommerce_product_data_tabs', 'cix_min_max_qty' );

function cix_min_max_qty( $original_prodata_tabs) {
    $new_custom_tab['cix-qty'] = array(
        'label' => __( 'Min & Max Qty', 'wc-mmqty' ),
        'target' => 'cix_min_max_qt_product_data',
        'class'     => array( 'show_if_simple', 'show_if_variable'  ),
    );
    $insert_at_position = 5; // Change this for desire position
    $tabs = array_slice( $original_prodata_tabs, 0, $insert_at_position, true ); // First part of original tabs
    $tabs = array_merge( $tabs, $new_custom_tab ); // Add new
    $tabs = array_merge( $tabs, array_slice( $original_prodata_tabs, $insert_at_position, null, true ) ); // Glue the second part of original
    return $tabs;
}

/** CSS To Add Custom tab Icon */
function wcpp_custom_style() {?>
<style>
.cix-error {
    background: #fbf8f8;
    margin: 0 10px;
    margin-top: 10px;
    border: 1px solid #ea6060;
    border-left: 5px solid #ea6060;
}
.cix-error p{
      font-size: 14px;
}
#woocommerce-product-data ul.wc-tabs li.cix-qty_options a:before { font-family: WooCommerce; content: '\e006'; }
</style>
<?php 
}
add_action( 'admin_head', 'wcpp_custom_style' );


// functions you can call to output text boxes, select boxes, etc.
add_action('woocommerce_product_data_panels', 'woocom_custom_product_data_fields');

function woocom_custom_product_data_fields() {
    global $post,$woocommerce;

      


    // Note the 'id' attribute needs to match the 'target' parameter set above
    ?> <div id = 'cix_min_max_qt_product_data'
    class = 'panel woocommerce_options_panel' > <?php
        ?> <div class = 'options_group' > <?php
              // Text Field
  woocommerce_wp_text_input(
    array(
      'id' => '_qty_min',
      'label' => __( 'Minimum Quantity', 'wc-mmqty' ),
     // 'wrapper_class' => 'show_if_simple', //show_if_simple or show_if_variable
      'placeholder' => 'Minium Quantity',
      'desc_tip' => 'true',
      'description' => __( 'Enter the value for Minimum Quantity.', 'wc-mmqty' )
    )
  );
woocommerce_wp_text_input(
    array(
      'id' => '_qty_max',
      'label' => __( 'Maximum Quantity', 'wc-mmqty' ),
     // 'wrapper_class' => 'show_if_simple', //show_if_simple or show_if_variable
      'placeholder' => 'Maximum Quantity',
      'desc_tip' => 'true',
      'description' => __( 'Enter the value for Maximum Quantity.', 'wc-mmqty' )
    )
  );
  woocommerce_wp_text_input(
    array(
      'id' => '_qty_step',
      'label' => __( 'Quantity Step', 'wc-mmqty' ),
     // 'wrapper_class' => 'show_if_simple', //show_if_simple or show_if_variable
      'placeholder' => 'Quantity Step',
      'desc_tip' => 'true',
      'description' => __( 'Enter the value for Quantity Step.', 'wc-mmqty' )
    )
  );
  
        ?> </div>

    </div><?php
}

/** Hook callback function to save custom fields information */
function cix_qty_save_data($post_id) {

  
    // Save _qty_step Field 
    
    $qty_field = sanitize_text_field($_POST['_qty_step']);
    if (!empty($qty_field)) {
        update_post_meta($post_id, '_qty_step', esc_attr($qty_field));
    }
    
    // Save _qty_max Field
    $max_field = sanitize_text_field($_POST['_qty_max']);
    if (!empty($max_field)) {
        update_post_meta($post_id, '_qty_max', esc_attr($max_field));
    }
    // Save _qty_min Field
    $min_field = sanitize_text_field($_POST['_qty_min']);
    if (!empty($min_field)) {
        update_post_meta($post_id, '_qty_min', esc_attr($min_field));
    }

}

add_action( 'woocommerce_process_product_meta_simple', 'cix_qty_save_data'  );

// You can uncomment the following line if you wish to use those fields for "Variable Product Type"
add_action( 'woocommerce_process_product_meta_variable', 'cix_qty_save_data'  );

