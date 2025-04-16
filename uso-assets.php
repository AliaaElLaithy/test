<?php
if ( ! defined( 'ABSPATH' ) ) exit();

// Plugin Assets Url
define( 'USO_ASSETS'         , USO_URL  . 'assets/' );
define( 'USO_FRONT_ASSETS'         , USO_URL  . 'assets/front-end/' );
define( 'USO_ADMIN_ASSETS'   , USO_URL  . 'assets/admin/' );

if ( ! function_exists( 'uso_frontend_scripts' ) ) {
    add_action('wp_enqueue_scripts', 'uso_frontend_scripts');
    function uso_frontend_scripts()
    {
        global $uso_sms_status , $uso_shipping_condition , $uso_shipping_type;

        /* Load Modal CSS */
        if(is_user_logged_in() && is_account_page()){
		    wp_enqueue_style('uso-modal-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css');
        }
        
        //Load main css file
        wp_enqueue_style( 'uso-frontend-style' , USO_FRONT_ASSETS . 'css/style.css', false, USO_VERSION );
        if ($uso_shipping_condition == 'yes') {
            //Load Places css file
            wp_enqueue_style('uso-place-style', USO_FRONT_ASSETS . 'css/place-style.css', false, USO_VERSION);
        }

        //Load JS Files
        if(is_user_logged_in() && is_account_page()){
            wp_enqueue_script( 'uso-modal-js' , 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js');
        }
        wp_enqueue_script( 'uso-frontend-script' , USO_FRONT_ASSETS . 'js/main.js' , array('jquery') , USO_VERSION , true);

        /* Load Shipping Place JS */
        if ($uso_shipping_condition == 'yes') {

            if (in_array('states-cities-and-places-for-woocommerce/states-cities-and-places-for-woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                wp_dequeue_script('wc-city-select');
                wp_enqueue_script('wc-city-select', USO_FRONT_ASSETS . 'js/place-select.js', array('jquery', 'woocommerce'), USO_VERSION, true);
            }
        }

        global $uso_rememberme;

        // Load AJAX Request
        wp_localize_script( 'uso-frontend-script' , 'uso_ajax_object' , [
                'ajax_url'              => admin_url( 'admin-ajax.php' ),
                'ajax_nonce'            => wp_create_nonce( 'uso_ajax_requests' ),
                'login_state'           => is_user_logged_in() ? true : false,
                'uso_login_rememberme'  => $uso_rememberme,
            ]
        );

        if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) && $uso_sms_status === 'yes' )
            echo '<style> #uso_step_1 #user_phone_field + p, #uso_step_2 #uso_resend_btn, .woocommerce-privacy-policy-text + p , #uso_loading { display : none } </style>';

        $onyx_receipt_status  = ( function_exists( 'onyx_get_receipt_status' ) ) ? onyx_get_receipt_status() : '';
        if ( $onyx_receipt_status === 'active' )
            echo '<style> #uso_shipping_method_field { display : none } </style>';

    }
}

if ( ! function_exists( 'uso_admin_scripts' ) ) {
    add_action( 'admin_enqueue_scripts' , 'uso_admin_scripts' );
    function uso_admin_scripts()
    {
        global $uso_shipping_condition;

        global $uso_shipping_condition;

        // Style Css
        wp_enqueue_style( 'uso-admin-style' , USO_ADMIN_ASSETS . 'css/style.css', false, USO_VERSION );

        // Admin Place Style Css
        wp_enqueue_style( 'uso-admin-place-style' , USO_ADMIN_ASSETS . 'css/admin-place-style.css', false, USO_VERSION );

        // admin global variables
        wp_enqueue_script( 'uso-admin-global-variables-script' , USO_ADMIN_ASSETS . 'js/global/global_variables.js', array(), USO_VERSION , true);
      
        // Admin Shipping js
        if ($uso_shipping_condition == 'yes') {
            wp_enqueue_script( 'uso-admin-shipping-script' , USO_ADMIN_ASSETS . 'js/shipping/shipping.js', array('jquery'), USO_VERSION , true);
        }
      
        // Main JS
        wp_enqueue_script( 'uso-admin-main-script' , USO_ADMIN_ASSETS . 'js/main.js', array('jquery'), USO_VERSION , true);

        wp_localize_script( 'uso-admin-global-variables-script' , 'uso_admin_ajax_object' , [
                'ajax_url'    => admin_url( 'admin-ajax.php' ),
            ]
        );
//        wp_localize_script( 'uso-admin-main-script' , 'uso_admin_ajax_object' , [
//                'ajax_url'    => admin_url( 'admin-ajax.php' ),
//                'ajax_nonce'  => wp_create_nonce( 'uso_ajax_requests' ),
//                'login_state' => is_user_logged_in() ? true : false,
//            ]
//        );
    }
}

/**************************************** Login Page Design Start *********************************************/
if (!function_exists('uso_custom_login_logo')) {
    add_action('login_head', 'uso_custom_login_logo');
    function uso_custom_login_logo()
    {
        ?>
        <input id="logoInput" type="hidden" value="<?php echo USO_ADMIN_ASSETS . 'images/logo.png'; ?>">
        <input id="userNameIcon" type="hidden" value="<?php echo USO_ADMIN_ASSETS . 'images/sms.png'; ?>">
        <input id="userPassIcon" type="hidden" value="<?php echo USO_ADMIN_ASSETS . 'images/lock.png'; ?>">
        <?php
    }
}

if (!function_exists('uso_login_assets')) {
    add_action('login_enqueue_scripts', 'uso_login_assets');
    function uso_login_assets()
    {
        wp_enqueue_style('uso-custom-login', USO_ADMIN_ASSETS . 'css/style-login.css');
        wp_enqueue_script('uso-login-jquery-js', USO_ADMIN_ASSETS . 'js/jquery-3.6.0.min.js');
        wp_enqueue_script('uso-custom-login-js', USO_ADMIN_ASSETS . 'js/style-login.js');
    }
}
/**************************************** Login Page Design End *********************************************/
// make javascript files type = module
if (!function_exists('uso_add_module_to_my_script')) {
    add_filter("script_loader_tag", "uso_add_module_to_my_script", 10, 3);
    function uso_add_module_to_my_script($tag, $handle, $src)
    {
        if ("uso-admin-main-script" == $handle || "uso-admin-shipping-script" == $handle || "uso-admin-global-variables-script" == $handle) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }// end func
}// end if