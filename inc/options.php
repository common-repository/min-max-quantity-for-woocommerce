<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if (!class_exists('wcmmqty_Settings_API')):
    class wcmmqty_Settings_API {

        private $settings_api;

        public function __construct() {
            $this->settings_api = new WeDevs_Settings_API;

            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
          

        }
     

        public function admin_init() {

            //set the settings
            $this->settings_api->set_sections($this->get_settings_sections());
            $this->settings_api->set_fields($this->get_settings_fields());

            //initialize settings
            $this->settings_api->admin_init();
            /**
             * If not, return the standard settings
             **/

        }

        public function admin_menu() {
            // add_options_page( 'Settings API', 'Settings API', 'delete_posts', 'settings_api_test',  );
            add_submenu_page('woocommerce', 'Min & Max Settings', 'Min & Max Settings', 'delete_posts', 'wcmmqty_options', array($this, 'wcmmqty_plugin_page'));
        }

        public function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'wcmmqty_settings',
                    'title' => __('Woocommerce Min & Max Settings', 'wpgs'),
                ),

            );
            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        public function get_settings_fields() {
            $settings_fields = array(
                'wcmmqty_settings'   => array(
                    array(
                        'name'              => 'min_messge_fw',
                        'label'             => __('Minimum Quantity', 'wc-mmqty'),
                        'desc'              => __( 'Enter Minimum Quantity Message. <br>
                             keep <span class="codelas">%s = min_qty</span> for get dynamic value.',
                                    'wc-mmqty' ),

                        'type'              => 'text',
                        'default'           => 'Minimum Quantity is %s',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    array(
                        'name'              => 'max_messge_fw',
                        'label'             => __('Maximum Quantity', 'wc-mmqty'),
                        'desc'              => __( 'Enter Maximum Quantity Message. <br>
                             keep <span class="codelas">%s = max_qty</span> for get dynamic value.',
                                    'wc-mmqty' ),

                        'type'              => 'text',
                        'default'           => 'Maximum Quantity is %s',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    array(
                        'name'              => 'step_messge_fw',
                        'label'             => __( 'Quantity Step', 'wc-mmqty' ),
                        'desc'               => __( 'Quantity Step Message. <br>
                                            keep <span class="codelas">%s = step_qty</span> for get dynamic value.',
                                            'wc-mmqty' ),
                        'type'              => 'text',
                        'default'           => 'Step is %s',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),

                    array(
                        'name'              => 'max_notice_fw',
                        'label'             => __( 'Max Quantity Exceed', 'wc-mmqty' ),
                            'desc'          => __( 'This Notice will show on single product page if buyer exceed the limit.<br>
                             keep <span class="codelas">%1$s = max_qty & %2$s = product_name</span> for get dynamic value.',
                                    'wc-mmqty' ),
                        'type'              => 'text',
                        'default'           => 'Maximum quantity is %1$s for "%2$s"',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),

                    array(
                        'name'              => 'incart_notice_fw',
                        'label'             => __( 'Already Cart', 'wc-mmqty' ),
                            'desc'          => __( 'This Notice will show on single product page if buyer has the product already in the cart.<br>
                             keep <span class="codelas">%1$s = cart_qty & %2$s = product_name</span> for get dynamic value.
                             ',
                                    'wc-mmqty' ),
                        'type'              => 'text',
                        'default'           => '%1$s item of "%2$s" is already in your cart.',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                  
                   
                    
                ),
            );

            return $settings_fields;
        }

        public function wcmmqty_plugin_page() {
            echo '<div class="wrap">';

            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
?>

<div class="multistep-ads metabox-holder">
	
 <h2>
<img draggable="false" class="emoji" alt="🎉" src="https://s.w.org/images/core/emoji/11/svg/1f389.svg"> Product Gallery Slider for Woocommerce</h2>
 <p class="about-description">Too Many Product Images in your Product? Product gallery slider for woocommerce allows you add a carousel in woocommerce default Gallery section.</p>
  <a target="_blank" href="https://wordpress.org/plugins/woo-product-gallery-slider/" class="button button-primary">Install Now</a>
</div>

<div class="multistep-ads metabox-holder">
	
 <h2>
<img draggable="false" class="emoji" alt="🎉" src="https://s.w.org/images/core/emoji/11/svg/1f389.svg"> Multistep Checkout for Woocommerce</h2>
 <p class="about-description">With <a href="https://wordpress.org/plugins/multistep-checkout-for-woocommerce-by-codeixer/">Multistep Checkout Plugin</a> the Buyers of your website will get a new step by step User Interface for checkout page.</p>
 <a target="_blank" href="https://wordpress.org/plugins/multistep-checkout-for-woocommerce-by-codeixer/" class="button button-primary">Install Now</a>
</div>

<div class="twist_pro metabox-holder">
	
 <h2 style="text-align: left;">Get Woocommerce Min & Max Pro Version Now (14$)</h2>
 <p>Pro version features are listed below:</p>
<ul>
    <li>Exclude Product from Rules</li>
    <li>Set product quantities for all products</li>
    <li>Quantity notice Settings option</li>
</ul> 
 <a target="_blank" href="https://1.envato.market/29J7D" class="button button-primary">Buy Now</a>


</div>


</div>

    <style>
    .multistep-ads{

    float: right;
    width: 435px;
    margin-bottom: 15px;

}
    .metabox-holder {
background: #fff;
    padding: 20px;
        padding-top: 20px;
    border-radius: 3px;

}
    .twist_oofer {

    width: 470px;
    height: 85px;

}
    .offer_txt {

    position: relative;
    top: -69px;
    left: 70px;

}
        .twist_oofer img{margin-top:10px;width:60px;}
    </style>
<?php
        }

       

    }
endif;
