<?php
if ( ! defined( 'ABSPATH' ) ) exit();

// INC
define( 'USO_INC'   , USO_PATH . 'inc/' );
define( 'USO_FRONT' , USO_INC . 'front-end/' );
define( 'USO_ADMIN' , USO_INC . 'admin/' );
define( 'USO_JSON'  , USO_INC . 'admin/json/' );

// Template
define( 'USO_TEM'   , USO_PATH . 'template/' );

/* * * * *
 *  Prof Functions
 * */
if ( ! function_exists( 'uso_is_active' ) ) {
    function uso_is_active()
    {
        return 'yes';
    }
}

if ( ! function_exists( 'prof_print_r' ) ) {
    function prof_print_r($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

/* prof Check Language
** Check If Language Ar Echo Ar Text Or Language En Echo En Text */
if ( ! function_exists( 'prof_the_switch_language' ) ) {
    function prof_the_switch_language( $ar, $en )
    {
        $current_lang = substr( get_locale (), 0, 2 );
        if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
            $current_lang = apply_filters( 'wpml_current_language', NULL );
        }

        if ( $current_lang == "ar") {
            echo $ar;
        }else{
            echo $en;
        }
    }
}

if ( ! function_exists( 'prof_get_switch_language' ) ) {
    function prof_get_switch_language( $ar, $en )
    {
        $current_lang = substr( get_locale (), 0, 2 );
        if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
            $current_lang = apply_filters( 'wpml_current_language', NULL );
        }
        if ( $current_lang == "ar") {
            return $ar;
        }
        return $en;
    }
}

$onyx_is_active         = ( function_exists( 'onyx_is_active' ) )       ? onyx_is_active()                          : 'no';

/* ****************** */
/* ٍ  Global Variables */
/* ****************** */
global $uso_shipping_condition;

$uso_settings           = get_option( 'uso_settings' );

// -- Activation --
$uso_activation_code    = get_option( 'uso_active' )['uso_activation'] ?? '';

// -- General Settings --
$uso_sms_status         = ! empty( $uso_settings['uso_sms_status'] )            ? $uso_settings['uso_sms_status']           : 'no';
$uso_shipping_condition    = ! empty( $uso_settings['uso_shipping_condition'] )       ? $uso_settings['uso_shipping_condition']      : 'no';
//$uso_dashboard_status   = ! empty( $uso_settings['uso_dashboard_status'] )      ? $uso_settings['uso_dashboard_status']     : 'no';

/* Required Plugin Message */
if (!function_exists('uso_scapfw_msg')) {
    function uso_scapfw_msg()
    {
        echo '<div class="uso-scapfw-msg">You should add and active <a href="https://wordpress.org/plugins/states-cities-and-places-for-woocommerce/">[States, Cities, and Places for WooCommerce]</a> plugin
                with ultimate options plugin to make shipping work correctly.</div>';
    }
}

// Compatibility with High-Performance Order Storage (HPOS)
if (in_array('states-cities-and-places-for-woocommerce/states-cities-and-places-for-woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    add_action('before_woocommerce_init', function(){
        if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', WP_PLUGIN_DIR."/states-cities-and-places-for-woocommerce/states-cities-and-places-for-woocommerce.php", true );
        }
    });
}

// include states & places [front & admin]
if ($uso_shipping_condition == 'yes') {
    /* Check for states-cities-and-places-for-woocommerce Plugin & Include Countries Files */
    if (in_array('states-cities-and-places-for-woocommerce/states-cities-and-places-for-woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

        // states
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/DZ.php');// Algeria
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/BH.php');// Bahrain
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/CN.php');// China
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/DJ.php');// Djibouti
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/EG.php');// Egypt
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/IN.php');// India
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/ID.php');// Indonesia
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/IQ.php');// Iraq
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/JO.php');// Jordan
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/KE.php');// kenya
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/KW.php');// Kuwait
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/LY.php');// Libya
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/MY.php');// Malaysia
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/NE.php');// Niger
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/QA.php');// Qatar
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/SA.php');// Saudi Arabia
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/SO.php');// Somalia
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/SD.php');// Sudan
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/TZ.php');// Tanzania
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/TR.php');// Turkey
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/AE.php');// United Arab Emirates
        include(plugin_dir_path(__FILE__) . 'inc/front-end/states/YE.php');// Yemen

        if(in_array('ultimate-asyad-express-shipping/ultimate-asyad-express-shipping.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            include(plugin_dir_path(__FILE__) . 'inc/front-end/states/OM-ASYAD.php');// Oman-asyad
        }else{
            include(plugin_dir_path(__FILE__) . 'inc/front-end/states/OM.php');
        }

        // places
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/DZ.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/BH.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/CN.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/DJ.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/EG.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/ID.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/IQ.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/JO.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/KE.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/KW.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/LY.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/MY.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/NE.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/QA.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/SA.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/SO.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/SD.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/TZ.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/TR.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/AE.php');
        include(plugin_dir_path(__FILE__) . 'inc/front-end/places/YE.php');

        if(in_array('ultimate-asyad-express-shipping/ultimate-asyad-express-shipping.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            include(plugin_dir_path(__FILE__) . 'inc/front-end/places/OM-ASYAD.php');// Oman-asyad
        }else{
            include(plugin_dir_path(__FILE__) . 'inc/front-end/places/OM.php');
        }

    } else {
        add_action('admin_notices', "uso_scapfw_msg");
    }
}


/* prof Check Value
** Check If Value True Echo Checked */
if ( ! function_exists( 'prof_check_value' ) ) {
    function prof_check_value( $check , $value , $type = "checked" ) {
        if( ! empty( $check ) && ! empty( $value ) ) {
            if ( $check == $value ) {
                echo $type;
            }
        }
    }
}

if ( ! function_exists( 'prof_get_check_value' ) ) {
    function prof_get_check_value( $check , $value , $type = "checked" ) {
        if( ! empty( $check ) && ! empty( $value ) ) {
            if ($check == $value) {
                return $type;
            }
        }
    }
}



/* * * * * *
 * USO System Notifications [ Success And Error Messages ]
 * * * * * */
if ( ! function_exists( 'uso_sys_notifications' ) ) {
    function uso_sys_notifications( $msg , $type = 'success' , $style = '' )
    {
        $alert_type = 'uso-alert-success';
        if ( $type == 'error' )
            $alert_type = 'uso-alert-error';

        echo '<div class="'.$alert_type.'" style="text-align: center; margin: 0 0 16px 0;font-weight: bold;">' . $msg . '</div>';
    }
}

if( ! function_exists( 'uso_get_var_product_by_sku' ) ) {
    function uso_get_var_product_by_sku( $var_sku )
    {
        $args = array(
            'post_type'     => 'product_variation',
            'meta_query'    => array(
                'relation'  => 'AND',
                array(
                    'key'       => '_sku',
                    'value'     => $var_sku,
                    'compare'   => '='
                )
            )
        );
        $search_query = new WP_Query( $args );
        if ( isset( $search_query->posts ) ) {
            return $search_query->posts[0]->ID;
        } else {
            return null;
        }
    }
}

// -- Products --
$uso_product_images     = ! empty( $uso_settings['uso_product_images'] )    ? $uso_settings['uso_product_images']       : 'no';
$uso_qty_limit          = ! empty($uso_settings['uso_qty_limit']) ? $uso_settings['uso_qty_limit'] : 'no';

if ( $onyx_is_active === 'yes' )
    $uso_product_images     = 'no';

$uso_price_after_text_ar = ! empty( $uso_settings['uso_price_after_text']['ar'] ) ? $uso_settings['uso_price_after_text']['ar'] : '';
$uso_price_after_text_en = ! empty( $uso_settings['uso_price_after_text']['en'] ) ? $uso_settings['uso_price_after_text']['en'] : '';
$uso_products_show_full_title_option  = ! empty( $uso_settings['uso_products_show_full_title_option'] ) ? $uso_settings['uso_products_show_full_title_option']    : 'no';
$uso_display_new_sar_currency_symbol  = ! empty( $uso_settings['uso_display_new_sar_currency_symbol'] ) ? $uso_settings['uso_display_new_sar_currency_symbol']    : 'no';


// -- Single Product --
$uso_single_product_more_details_option     = ! empty( $uso_settings['uso_single_product_more_details_option'] )    ? $uso_settings['uso_single_product_more_details_option']       : 'no';
$uso_single_product_remove_title_from_breadcrumbs_option     = ! empty( $uso_settings['uso_single_product_remove_title_from_breadcrumbs_option'] )    ? $uso_settings['uso_single_product_remove_title_from_breadcrumbs_option']       : 'no';


// -- Cart --
$uso_product_weight     = ! empty( $uso_settings['uso_product_weight'] )    ? $uso_settings['uso_product_weight']       : 'no';
$uso_max_weight         = ! empty( $uso_settings['uso_max_weight'] )        ? $uso_settings['uso_max_weight']           : '0';

// -- Checkout --
$uso_map_status         = ! empty( $uso_settings['uso_map_status'] )        ? $uso_settings['uso_map_status']           : 'no';
$uso_map_key            = ! empty( $uso_settings['uso_map_key'] )           ? $uso_settings['uso_map_key']              : '';
$uso_map_default_lat    = ! empty( $uso_settings['uso_map_default_lat'] )   ? $uso_settings['uso_map_default_lat']      : '24.046463326483025';
$uso_map_default_lng    = ! empty( $uso_settings['uso_map_default_lng'] )   ? $uso_settings['uso_map_default_lng']      : '45.933837500000024';
$uso_map_address        = ! empty( $uso_settings['uso_map_address'] )        ? $uso_settings['uso_map_address']           : 'no';
$uso_map_zoom           = ! empty( $uso_settings['uso_map_zoom'] )        ? $uso_settings['uso_map_zoom']           : '5';

if ( ! function_exists( 'uso_get_map_status' ) ) {
    function uso_get_map_status()
    {
        global $uso_map_status;
        return $uso_map_status;
    }
}

$uso_vat_status         = ! empty( $uso_settings['uso_vat_status'] )        ? $uso_settings['uso_vat_status']           : 'no';
$uso_vat_type           = ! empty( $uso_settings['uso_vat_type'] )          ? $uso_settings['uso_vat_type']             : '';
$uso_vat_pattern        = ! empty( $uso_settings['uso_vat_pattern'] )       ? $uso_settings['uso_vat_pattern']          : 'price_with_vat';
$uso_vat_text           = ! empty( $uso_settings['uso_vat_text'] )          ? $uso_settings['uso_vat_text']             : 'default';
$uso_vat_amount         = ! empty( $uso_settings['uso_vat_amount'] )        ? $uso_settings['uso_vat_amount']           : 0;
$uso_vat_shipping_type  = ! empty( $uso_settings['uso_vat_shipping_type'] ) ? $uso_settings['uso_vat_shipping_type']    : '';
$uso_tax_number         = ! empty( $uso_settings['uso_tax_number'] )        ? $uso_settings['uso_tax_number']           : '';

if ( ! function_exists( 'uso_get_vat_status' ) ) {
    function uso_get_vat_status()
    {
        global $uso_vat_status;
        return $uso_vat_status;
    }
}

if ( ! function_exists( 'uso_get_vat_type' ) ) {
    function uso_get_vat_type()
    {
        global $uso_vat_type;
        return $uso_vat_type;
    }
}

if ( ! function_exists( 'uso_get_vat_pattern' ) ) {
    function uso_get_vat_pattern()
    {
         global $uso_vat_pattern;
         return $uso_vat_pattern;
    }
}

if ( ! function_exists( 'uso_get_vat_amount' ) ) {
    function uso_get_vat_amount()
    {
        global $uso_vat_amount;
        return $uso_vat_amount;
    }
}

if ( ! function_exists( 'uso_get_vat_shipping_type' ) ) {
    function uso_get_vat_shipping_type()
    {
        global $uso_vat_shipping_type;
        return $uso_vat_shipping_type;
    }
}

$district_index = 'uso_checkout_uso_district';

$uso_checkout_fields    = array(
    'uso_checkout_company'      => prof_get_switch_language('الشركة'         ,'Company'),
    'uso_checkout_first_name'   => prof_get_switch_language('الإسم الأول'      ,'First Name'),
    'uso_checkout_last_name'    => prof_get_switch_language('الإسم الأخير'     ,'Last Name'),
    'uso_checkout_country'      => prof_get_switch_language('الدولة'         ,'Country'),
    'uso_checkout_state'        => prof_get_switch_language('المنطقة'        ,'Region'),
    'uso_checkout_city'         => prof_get_switch_language('المدينة'        ,'City'),
    $district_index             => prof_get_switch_language('الحي'           ,'District'),
    'uso_checkout_address_1'    => prof_get_switch_language('العنوان 1'      ,'Address 1'),
    'uso_checkout_address_2'    => prof_get_switch_language('العنوان 2'      ,'Address 2'),
    'uso_checkout_email'        => prof_get_switch_language('البريد الإلكترونى' ,'Email'),
    'uso_checkout_phone'        => prof_get_switch_language('الجوال'         ,'Phone'),
    'uso_checkout_postcode'     => prof_get_switch_language('الرمز البريدي'  ,'Postcode'),
);

$uso_checkout_inputs = [];

if ( is_array( $uso_checkout_fields ) && ! empty( $uso_checkout_fields ) ) {

    foreach ( $uso_checkout_fields as $uso_checkout_field_key => $uso_checkout_field ) {

        $uso_checkout_popup_inputs = [];

        $field_status       = $uso_checkout_field_key.'[status]';
        $field_status_value = ! empty( $uso_settings[$uso_checkout_field_key]['status'] ) ? $uso_settings[$uso_checkout_field_key]['status']  : 'no';

        $uso_checkout_popup_inputs[$field_status] = array(
            'label'         => prof_get_switch_language('إخفاء','Hide'),
            'type'          => 'radio',
            'options'       => array(
                'yes'       => prof_get_switch_language( 'نعم' , 'Yes' ),
                'no'        => prof_get_switch_language( 'لا' , 'No' ),
            ),
            'default'   => $field_status_value,
            'tooltip'   => prof_get_switch_language('',''),
        );

        $field_label    = $uso_checkout_field_key.'[label]';

        $field_label_ar = ! empty( $uso_settings[$uso_checkout_field_key]['label']['ar'] ) ? $uso_settings[$uso_checkout_field_key]['label']['ar']  : '';
        $field_label_en = ! empty( $uso_settings[$uso_checkout_field_key]['label']['en'] ) ? $uso_settings[$uso_checkout_field_key]['label']['en']  : '';

        $uso_checkout_popup_inputs[$field_label] = array(
            'label'     => prof_get_switch_language('إسم الحقل','Name'),
            'name'      => 'label',
            'type'      => 'multi_text',
            'values'    => array(
                'ar'    => $field_label_ar,
                'en'    => $field_label_en
            ),
            'tooltip'   => prof_get_switch_language('',''),
        );

        $field_placeholder    = $uso_checkout_field_key.'[placeholder]';

        $field_placeholder_ar = ! empty( $uso_settings[$uso_checkout_field_key]['placeholder']['ar'] ) ? $uso_settings[$uso_checkout_field_key]['placeholder']['ar'] : '';
        $field_placeholder_en = ! empty( $uso_settings[$uso_checkout_field_key]['placeholder']['en'] ) ? $uso_settings[$uso_checkout_field_key]['placeholder']['en']  : '';

        $uso_checkout_popup_inputs[$field_placeholder] = array(
            'label'     => prof_get_switch_language('النص التوضيحي','Placeholder'),
            'name'      => 'placeholder',
            'type'      => 'multi_text',
            'values'    => array(
                'ar'    => $field_placeholder_ar,
                'en'    => $field_placeholder_en
            ),
            'tooltip'   => prof_get_switch_language('',''),
        );

        $field_priority       = $uso_checkout_field_key.'[priority]';
        $field_priority_value = ! empty( $uso_settings[$uso_checkout_field_key]['priority'] ) ? $uso_settings[$uso_checkout_field_key]['priority']  : '';

        $uso_checkout_popup_inputs[$field_priority] = array(
            'label'     => prof_get_switch_language('إجباري','Required'),
            'type'      => 'radio',
            'options'   => array(
                'yes'       => prof_get_switch_language( 'نعم' , 'Yes' ),
                'no'        => prof_get_switch_language( 'لا' , 'No' ),
            ),
            'default'   => $field_priority_value,
            'tooltip'   => prof_get_switch_language('',''),
        );


        $field_value    = $uso_checkout_field_key.'[value]';

        $field_value_ar = ! empty( $uso_settings[$uso_checkout_field_key]['value']['ar'] ) ? $uso_settings[$uso_checkout_field_key]['value']['ar'] : '';
        $field_value_en = ! empty( $uso_settings[$uso_checkout_field_key]['value']['en'] ) ? $uso_settings[$uso_checkout_field_key]['value']['en']  : '';


        $uso_checkout_popup_inputs[$field_value] = array(
            'label'     => prof_get_switch_language('القيمة الإفتراضية','Default Value'),
            'name'      => 'value',
            'type'      => 'multi_text',
            'values'    => array(
                'ar'    => $field_value_ar,
                'en'    => $field_value_en
            ),
            'tooltip'   => prof_get_switch_language('',''),
        );

        // Popup Input
        $uso_checkout_inputs[$uso_checkout_field_key] = array(
            'label'     => $uso_checkout_field,
            'type'      => 'popup',
            'inputs'    => $uso_checkout_popup_inputs,
            'tooltip'   => prof_get_switch_language('',''),
        );

    }

}

// -- Orders --
$uso_order_default_status = ! empty( $uso_settings['uso_order_default_status'] ) ? $uso_settings['uso_order_default_status'] : 'no';

if ( ! function_exists( 'uso_get_order_default_status' ) ) {
    function uso_get_order_default_status()
    {
        global $uso_order_default_status;
        return $uso_order_default_status;
    }
}

// -- Sms --
$uso_sms_options                = ! empty( $uso_settings['uso_sms_options'] )           ? $uso_settings['uso_sms_options']          : 'phone';

// Phone
$uso_sms_provider               = ! empty( $uso_settings['uso_sms_provider'] )          ? $uso_settings['uso_sms_provider']         : '';
$uso_sms_url                    = ! empty( $uso_settings['uso_sms_url'] )               ? $uso_settings['uso_sms_url']              : '';
$uso_sms_user                   = ! empty( $uso_settings['uso_sms_user'] )              ? $uso_settings['uso_sms_user']             : '';
$uso_sms_password               = ! empty( $uso_settings['uso_sms_password'] )          ? $uso_settings['uso_sms_password']         : '';
$uso_sms_accesskey              = ! empty( $uso_settings['uso_sms_accesskey'] )         ? $uso_settings['uso_sms_accesskey']        : '';
$uso_sms_sender                 = ! empty( $uso_settings['uso_sms_sender'] )            ? $uso_settings['uso_sms_sender']           : '';

// Whatsapp
$uso_wa_sms_provider            = ! empty( $uso_settings['uso_wa_sms_provider'] )       ? $uso_settings['uso_wa_sms_provider']         : '';
$uso_wa_sms_url                 = ! empty( $uso_settings['uso_wa_sms_url'] )            ? $uso_settings['uso_wa_sms_url']              : '';
$uso_wa_sms_user                = ! empty( $uso_settings['uso_wa_sms_user'] )           ? $uso_settings['uso_wa_sms_user']             : '';
$uso_wa_sms_password            = ! empty( $uso_settings['uso_wa_sms_password'] )       ? $uso_settings['uso_wa_sms_password']         : '';
$uso_wa_sms_sender              = ! empty( $uso_settings['uso_wa_sms_sender'] )         ? $uso_settings['uso_wa_sms_sender']           : '';

$uso_sms_order_confirm          = ! empty( $uso_settings['uso_sms_order_confirm'] )             ? $uso_settings['uso_sms_order_confirm']            : 'stop';
$uso_sms_order_confirm_msg_ar   = ! empty( $uso_settings['uso_sms_order_confirm_msg']['ar'] )   ? $uso_settings['uso_sms_order_confirm_msg']['ar']  : '';
$uso_sms_order_confirm_msg_en   = ! empty( $uso_settings['uso_sms_order_confirm_msg']['en'] )   ? $uso_settings['uso_sms_order_confirm_msg']['en']  : '';

if ( ! function_exists( 'uso_get_sms_order_confirm_msg' ) ) {
    function uso_get_sms_order_confirm_msg()
    {
        global $uso_sms_order_confirm_msg_ar,$uso_sms_order_confirm_msg_en;
        $msg    = prof_get_switch_language( $uso_sms_order_confirm_msg_ar , $uso_sms_order_confirm_msg_en );
        return $msg;
    }
}

if ( ! function_exists( 'uso_get_sms_order_confirm' ) ) {
    function uso_get_sms_order_confirm()
    {
        global $uso_sms_order_confirm;
        return $uso_sms_order_confirm;
    }
}

$default_order_statuses = array(
    'wc-pending'    => _x( 'Pending payment', 'Order status', 'woocommerce' ),
    'wc-processing' => _x( 'Processing'     , 'Order status', 'woocommerce' ),
    'wc-on-hold'    => _x( 'On hold'        , 'Order status', 'woocommerce' ),
    'wc-completed'  => _x( 'Completed'      , 'Order status', 'woocommerce' ),
    'wc-cancelled'  => _x( 'Cancelled'      , 'Order status', 'woocommerce' ),
    'wc-refunded'   => _x( 'Refunded'       , 'Order status', 'woocommerce' ),
    'wc-failed'     => _x( 'Failed'         , 'Order status', 'woocommerce' ),
);

$order_statuses     = ( function_exists( 'wc_get_order_statuses' ) ) ? wc_get_order_statuses() : $default_order_statuses ;
$uso_orders_inputs  = $uso_order_statuses = [];

$uso_sms_inputs = [

    'uso_sms_options' => array(
        'label'     => prof_get_switch_language('خيارات الرسائل','Messaging options'),
        'type'      => 'select',
        'options'   => array(
            ''          => prof_get_switch_language('إختر خيارات الرسائل المتاحة'      ,'Choose the available messaging options'),
            'phone'     => prof_get_switch_language( 'الجوال'               , 'Phone' ),
            'whatsapp'  => prof_get_switch_language( 'الواتساب'             , 'Whatsapp' ),
            'both'      => prof_get_switch_language( 'الجوال + الواتساب'    , 'Phone + Whatsapp' ),
        ),
        'default'   => $uso_sms_options,
        'tooltip'   => prof_get_switch_language('',''),
    ),

    'uso_sms_order_confirm' => array(
        'label'     => prof_get_switch_language('تأكيد الطلب','Order Confirm'),
        'type'      => 'radio',
        'options'   => array(
            'send'      => prof_get_switch_language( 'إرسال'    , 'send' ),
            'stop'      => prof_get_switch_language( 'إيقاف'    , 'stop' ),
        ),
        'default'   => $uso_sms_order_confirm,
        'tooltip'   => prof_get_switch_language('',''),
    ),

    'uso_sms_order_confirm_msg' => array(
        'label'     => prof_get_switch_language('رسالة تأكيد الطلب','Order Confirm Msg'),
        'name'      => 'msg',
        'type'      => 'multi_text',
        'values'    => array(
            'ar'        => $uso_sms_order_confirm_msg_ar,
            'en'        => $uso_sms_order_confirm_msg_en
        ),
        'tooltip'   => prof_get_switch_language('يتم إضافة رقم الطلب فى نهاية الرسالة تلقائيا','The order number is added automatically at the end of the message')
    ),

];

if ( is_array( $order_statuses ) && ! empty( $order_statuses ) ) {

    $uso_order_statuses['default'] = prof_get_switch_language( 'الإفتراضي' , 'Default' );

    foreach ( $order_statuses as $key => $value ) {

        $order_status = explode( 'wc-' , $key );
        $uso_order_statuses[$order_status[1]] = $value;

        $input_name     = 'uso_order_'.$order_status[1];

        $order_label    = $input_name.'_label';
        $input_value_ar = ! empty( $uso_settings[$order_label]['ar'] ) ? $uso_settings[$order_label]['ar']  : '';
        $input_value_en = ! empty( $uso_settings[$order_label]['en'] ) ? $uso_settings[$order_label]['en']  : '';

        $uso_orders_inputs[$order_label] = array(
            'label'     => $value,
            'name'      => 'label',
            'type'      => 'multi_text',
            'values'    => array(
                'ar' => $input_value_ar,
                'en' => $input_value_en
            ),
            'tooltip'   => prof_get_switch_language('',''),
        );


        $order_sms_status_name  = $input_name.'_sms_status';
        $order_sms_msg_name     = $input_name.'_sms_msg';
        $order_sms_status       = ! empty( $uso_settings[$order_sms_status_name] )      ? $uso_settings[$order_sms_status_name]     : 'stop';
        $order_sms_msg_ar       = ! empty( $uso_settings[$order_sms_msg_name]['ar'] )   ? $uso_settings[$order_sms_msg_name]['ar']  : '';
        $order_sms_msg_en       = ! empty( $uso_settings[$order_sms_msg_name]['en'] )   ? $uso_settings[$order_sms_msg_name]['en']  : '';

        $uso_sms_inputs[$order_sms_status_name] = array(
            'label'     =>  $value,
            'type'      => 'radio',
            'options'   => array(
                'send'      => prof_get_switch_language( 'إرسال'    , 'send' ),
                'stop'      => prof_get_switch_language( 'إيقاف'    , 'stop' ),
            ),
            'default'   => $order_sms_status,
            'tooltip'   => prof_get_switch_language('',''),
        );

        $uso_sms_inputs[$order_sms_msg_name] = array(
            'label'     => prof_get_switch_language( 'الرسالة'    , 'Massage' ),
            'name'      => 'label',
            'type'      => 'multi_text',
            'values'    => [
                'ar' => $order_sms_msg_ar,
                'en' => $order_sms_msg_en
            ],
            'tooltip'   => prof_get_switch_language('',''),
        );

    }
    $order_status_options = array("no"=>"Default", 'wc-processing'=>'Processing', 'wc-on-hold'=>'On Hold');
    $uso_orders_inputs['uso_order_default_status'] = array(
        'label'     => prof_get_switch_language('الحالة الإفتراضية','Default Status'),
        'type'      => 'select',
        'options'   => $order_status_options,
        'default'   => $uso_order_default_status,
        'tooltip'   => prof_get_switch_language('',''),
    );
}

// -- Payment --
$uso_payment_cod_tax        = ! empty( $uso_settings['uso_payment_cod_tax'] )       ? $uso_settings['uso_payment_cod_tax']      : '';
$uso_bacs_status            = ! empty( $uso_settings['uso_bacs_status'] )           ? $uso_settings['uso_bacs_status']          : '';

if ( ! function_exists( 'uso_get_cod_tax' ) ) {
    function uso_get_cod_tax()
    {
        global $uso_payment_cod_tax;
        return $uso_payment_cod_tax;
    }
}

// -- Dev Mode --
$uso_dev_mode_status        = ! empty( $uso_settings['uso_dev_mode_status'] )       ? $uso_settings['uso_dev_mode_status']      : 'live';

// -- Users --
$uso_default_code           = ! empty( $uso_settings['uso_default_code'] )          ? $uso_settings['uso_default_code']         : '';
//$uso_show_county_code       = ! empty( $uso_settings['uso_show_county_code'] )      ? $uso_settings['uso_show_county_code']     : 'yes';
$uso_county_code_choice     = ! empty( $uso_settings['uso_county_code_choice'] )    ? $uso_settings['uso_county_code_choice']   : 'yes';
$uso_phone_placeholder_ar   = ! empty( $uso_settings['uso_phone_placeholder']['ar'] )  ? $uso_settings['uso_phone_placeholder']['ar'] : '';
$uso_phone_placeholder_en   = ! empty( $uso_settings['uso_phone_placeholder']['en'] )  ? $uso_settings['uso_phone_placeholder']['en'] : '';
$uso_email_status           = ! empty( $uso_settings['uso_email_status'] )          ? $uso_settings['uso_email_status']         : 'required';
$uso_confirm_email_status   = ! empty( $uso_settings['uso_confirm_email'] )          ? $uso_settings['uso_confirm_email']         : 'no';
$uso_first_name_status      = ! empty( $uso_settings['uso_first_name_status'] )     ? $uso_settings['uso_first_name_status']    : 'no';
$uso_last_name_status       = ! empty( $uso_settings['uso_last_name_status'] )      ? $uso_settings['uso_last_name_status']     : 'no';
$uso_full_name_status       = ! empty( $uso_settings['uso_full_name_status'] )      ? $uso_settings['uso_full_name_status']     : 'no';
$uso_company_name_status    = ! empty( $uso_settings['uso_company_name_status'] )      ? $uso_settings['uso_company_name_status']     : 'no';
$uso_ophone_status          = ! empty( $uso_settings['uso_ophone_status'] )         ? $uso_settings['uso_ophone_status']        : 'no';
$uso_password_status        = ! empty( $uso_settings['uso_password_status'] )       ? $uso_settings['uso_password_status']      : 'strong';
$uso_confirm_password       = ! empty( $uso_settings['uso_confirm_password'] )       ? $uso_settings['uso_confirm_password']      : 'no';
$uso_promotions_subscription= ! empty( $uso_settings['uso_promotions_subscription'] ) ? $uso_settings['uso_promotions_subscription']      : 'no';
$sms_user_reg_msg_ar        = ! empty( $uso_settings['sms_user_reg_msg']['ar'] )    ? $uso_settings['sms_user_reg_msg']['ar']   : '';
$sms_user_reg_msg_en        = ! empty( $uso_settings['sms_user_reg_msg']['en'] )    ? $uso_settings['sms_user_reg_msg']['en']   : '';

//$uso_default_country        = ! empty( $uso_settings['uso_default_country'] )       ? $uso_settings['uso_default_country']      : '';
//$uso_default_region         = ! empty( $uso_settings['uso_default_region'] )        ? $uso_settings['uso_default_region']       : '';
//$uso_default_city           = ! empty( $uso_settings['uso_default_city'] )          ? $uso_settings['uso_default_city']         : '';
//$uso_default_district       = ! empty( $uso_settings['uso_default_district'] )      ? $uso_settings['uso_default_district']     : '';

/* Various Tab Variables */
$uso_change_availability_text_ar = !empty($uso_settings['uso_change_availability_text']['ar']) ? $uso_settings['uso_change_availability_text']['ar'] : '';
$uso_change_availability_text_en = !empty($uso_settings['uso_change_availability_text']['en']) ? $uso_settings['uso_change_availability_text']['en'] : '';
$uso_change_product_available_text_ar = !empty($uso_settings['uso_change_product_available_text']['ar']) ? $uso_settings['uso_change_product_available_text']['ar'] : '';
$uso_change_product_available_text_en = !empty($uso_settings['uso_change_product_available_text']['en']) ? $uso_settings['uso_change_product_available_text']['en'] : '';
$uso_long_desc_compare = !empty($uso_settings['uso_long_des_compare']) ? $uso_settings['uso_long_des_compare'] : 'no';
$uso_add_payment_touser = !empty($uso_settings['uso_add_payment_to_user']) ? $uso_settings['uso_add_payment_to_user'] : 'no';
$uso_add_total = !empty($uso_settings['uso_add_total']) ? $uso_settings['uso_add_total'] : 'no';
$uso_hide_shipping_costs = !empty($uso_settings['uso_hide_shipping_costs']) ? $uso_settings['uso_hide_shipping_costs'] : 'no';
$uso_qr_generate = !empty($uso_settings['uso_qr_generate']) ? $uso_settings['uso_qr_generate'] : 'yes';
$uso_product_wo_thumbnail = !empty($uso_settings['uso_product_wo_thumbnail']) ? $uso_settings['uso_product_wo_thumbnail'] : 'display';
$uso_shop_footer_html_blocks = !empty($uso_settings['uso_shop_footer_html_blocks']) ? $uso_settings['uso_shop_footer_html_blocks'] : '';
$uso_cart_footer_html_blocks = !empty($uso_settings['uso_cart_footer_html_blocks']) ? $uso_settings['uso_cart_footer_html_blocks'] : '';
$uso_product_footer_html_blocks = !empty($uso_settings['uso_product_footer_html_blocks']) ? $uso_settings['uso_product_footer_html_blocks'] : '';
$uso_move_product_to_last = !empty($uso_settings['uso_move_product_to_last']) ? $uso_settings['uso_move_product_to_last'] : 'no';
$uso_add_shipped_order_status = !empty($uso_settings['uso_add_shipped_order_status']) ? $uso_settings['uso_add_shipped_order_status'] : 'no';
$uso_use_you_save = !empty($uso_settings['uso_use_you_save']) ? $uso_settings['uso_use_you_save'] : 'no';

/* Extra Fields Variables */
$uso_use_extra_fields = !empty($uso_settings['uso_use_extra_fields']) ? $uso_settings['uso_use_extra_fields'] : 'no';
$uso_extra_fields_columns = !empty($uso_settings['uso_extra_fields_columns']) ? $uso_settings['uso_extra_fields_columns'] : 'one';
$uso_extra_fields_display = !empty($uso_settings['uso_extra_fields_display']) ? $uso_settings['uso_extra_fields_display'] : '';
$uso_extra_field_1_title_ar = ! empty( $uso_settings['uso_extra_field_1_title']['ar'] ) ? $uso_settings['uso_extra_field_1_title']['ar'] : '';
$uso_extra_field_1_title_en = ! empty( $uso_settings['uso_extra_field_1_title']['en'] ) ? $uso_settings['uso_extra_field_1_title']['en'] : '';
$uso_extra_field_2_title_ar = ! empty( $uso_settings['uso_extra_field_2_title']['ar'] ) ? $uso_settings['uso_extra_field_2_title']['ar'] : '';
$uso_extra_field_2_title_en = ! empty( $uso_settings['uso_extra_field_2_title']['en'] ) ? $uso_settings['uso_extra_field_2_title']['en'] : '';
$uso_extra_field_3_title_ar = ! empty( $uso_settings['uso_extra_field_3_title']['ar'] ) ? $uso_settings['uso_extra_field_3_title']['ar'] : '';
$uso_extra_field_3_title_en = ! empty( $uso_settings['uso_extra_field_3_title']['en'] ) ? $uso_settings['uso_extra_field_3_title']['en'] : '';
$uso_extra_field_4_title_ar = ! empty( $uso_settings['uso_extra_field_4_title']['ar'] ) ? $uso_settings['uso_extra_field_4_title']['ar'] : '';
$uso_extra_field_4_title_en = ! empty( $uso_settings['uso_extra_field_4_title']['en'] ) ? $uso_settings['uso_extra_field_4_title']['en'] : '';
$uso_extra_field_5_title_ar = ! empty( $uso_settings['uso_extra_field_5_title']['ar'] ) ? $uso_settings['uso_extra_field_5_title']['ar'] : '';
$uso_extra_field_5_title_en = ! empty( $uso_settings['uso_extra_field_5_title']['en'] ) ? $uso_settings['uso_extra_field_5_title']['en'] : '';
$uso_extra_field_6_title_ar = ! empty( $uso_settings['uso_extra_field_6_title']['ar'] ) ? $uso_settings['uso_extra_field_6_title']['ar'] : '';
$uso_extra_field_6_title_en = ! empty( $uso_settings['uso_extra_field_6_title']['en'] ) ? $uso_settings['uso_extra_field_6_title']['en'] : '';
$uso_extra_field_7_title_ar = ! empty( $uso_settings['uso_extra_field_7_title']['ar'] ) ? $uso_settings['uso_extra_field_7_title']['ar'] : '';
$uso_extra_field_7_title_en = ! empty( $uso_settings['uso_extra_field_7_title']['en'] ) ? $uso_settings['uso_extra_field_7_title']['en'] : '';
$uso_extra_field_8_title_ar = ! empty( $uso_settings['uso_extra_field_8_title']['ar'] ) ? $uso_settings['uso_extra_field_8_title']['ar'] : '';
$uso_extra_field_8_title_en = ! empty( $uso_settings['uso_extra_field_8_title']['en'] ) ? $uso_settings['uso_extra_field_8_title']['en'] : '';
$uso_extra_field_9_title_ar = ! empty( $uso_settings['uso_extra_field_9_title']['ar'] ) ? $uso_settings['uso_extra_field_9_title']['ar'] : '';
$uso_extra_field_9_title_en = ! empty( $uso_settings['uso_extra_field_9_title']['en'] ) ? $uso_settings['uso_extra_field_9_title']['en'] : '';
$uso_extra_field_10_title_ar = ! empty( $uso_settings['uso_extra_field_10_title']['ar'] ) ? $uso_settings['uso_extra_field_10_title']['ar'] : '';
$uso_extra_field_10_title_en = ! empty( $uso_settings['uso_extra_field_10_title']['en'] ) ? $uso_settings['uso_extra_field_10_title']['en'] : '';
$uso_extra_field_11_title_ar = ! empty( $uso_settings['uso_extra_field_11_title']['ar'] ) ? $uso_settings['uso_extra_field_11_title']['ar'] : '';
$uso_extra_field_11_title_en = ! empty( $uso_settings['uso_extra_field_11_title']['en'] ) ? $uso_settings['uso_extra_field_11_title']['en'] : '';
$uso_extra_field_12_title_ar = ! empty( $uso_settings['uso_extra_field_12_title']['ar'] ) ? $uso_settings['uso_extra_field_12_title']['ar'] : '';
$uso_extra_field_12_title_en = ! empty( $uso_settings['uso_extra_field_12_title']['en'] ) ? $uso_settings['uso_extra_field_12_title']['en'] : '';
$uso_extra_field_13_title_ar = ! empty( $uso_settings['uso_extra_field_13_title']['ar'] ) ? $uso_settings['uso_extra_field_13_title']['ar'] : '';
$uso_extra_field_13_title_en = ! empty( $uso_settings['uso_extra_field_13_title']['en'] ) ? $uso_settings['uso_extra_field_13_title']['en'] : '';
$uso_extra_field_14_title_ar = ! empty( $uso_settings['uso_extra_field_14_title']['ar'] ) ? $uso_settings['uso_extra_field_14_title']['ar'] : '';
$uso_extra_field_14_title_en = ! empty( $uso_settings['uso_extra_field_14_title']['en'] ) ? $uso_settings['uso_extra_field_14_title']['en'] : '';
$uso_extra_field_15_title_ar = ! empty( $uso_settings['uso_extra_field_15_title']['ar'] ) ? $uso_settings['uso_extra_field_15_title']['ar'] : '';
$uso_extra_field_15_title_en = ! empty( $uso_settings['uso_extra_field_15_title']['en'] ) ? $uso_settings['uso_extra_field_15_title']['en'] : '';
$uso_extra_field_16_title_ar = ! empty( $uso_settings['uso_extra_field_16_title']['ar'] ) ? $uso_settings['uso_extra_field_16_title']['ar'] : '';
$uso_extra_field_16_title_en = ! empty( $uso_settings['uso_extra_field_16_title']['en'] ) ? $uso_settings['uso_extra_field_16_title']['en'] : '';
$uso_extra_field_17_title_ar = ! empty( $uso_settings['uso_extra_field_17_title']['ar'] ) ? $uso_settings['uso_extra_field_17_title']['ar'] : '';
$uso_extra_field_17_title_en = ! empty( $uso_settings['uso_extra_field_17_title']['en'] ) ? $uso_settings['uso_extra_field_17_title']['en'] : '';
$uso_extra_field_18_title_ar = ! empty( $uso_settings['uso_extra_field_18_title']['ar'] ) ? $uso_settings['uso_extra_field_18_title']['ar'] : '';
$uso_extra_field_18_title_en = ! empty( $uso_settings['uso_extra_field_18_title']['en'] ) ? $uso_settings['uso_extra_field_18_title']['en'] : '';
$uso_extra_field_19_title_ar = ! empty( $uso_settings['uso_extra_field_19_title']['ar'] ) ? $uso_settings['uso_extra_field_19_title']['ar'] : '';
$uso_extra_field_19_title_en = ! empty( $uso_settings['uso_extra_field_19_title']['en'] ) ? $uso_settings['uso_extra_field_19_title']['en'] : '';
$uso_extra_field_20_title_ar = ! empty( $uso_settings['uso_extra_field_20_title']['ar'] ) ? $uso_settings['uso_extra_field_20_title']['ar'] : '';
$uso_extra_field_20_title_en = ! empty( $uso_settings['uso_extra_field_20_title']['en'] ) ? $uso_settings['uso_extra_field_20_title']['en'] : '';

/* login options*/
$uso_rememberme         = ! empty( $uso_settings['uso_rememberme'] )        ? $uso_settings['uso_rememberme']           : 'yes';
$uso_force_login        = ! empty( $uso_settings['uso_force_login'] )       ? $uso_settings['uso_force_login']          : 'no';

$uso_countries_code = array(
    'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
    'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
    'EG'=>array('name'=>'EGYPT','code'=>'20'),
    'OM'=>array('name'=>'OMAN','code'=>'968'),
    'TR'=>array('name'=>'TURKEY','code'=>'90'),
    'AD'=>array('name'=>'ANDORRA','code'=>'376'),
    'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
    'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
    'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
    'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
    'AL'=>array('name'=>'ALBANIA','code'=>'355'),
    'AM'=>array('name'=>'ARMENIA','code'=>'374'),
    'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
    'AO'=>array('name'=>'ANGOLA','code'=>'244'),
    'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
    'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
    'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
    'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
    'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
    'AW'=>array('name'=>'ARUBA','code'=>'297'),
    'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
    'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
    'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
    'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
    'BE'=>array('name'=>'BELGIUM','code'=>'32'),
    'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
    'BG'=>array('name'=>'BULGARIA','code'=>'359'),
    'BI'=>array('name'=>'BURUNDI','code'=>'257'),
    'BJ'=>array('name'=>'BENIN','code'=>'229'),
    'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
    'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
    'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
    'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
    'BR'=>array('name'=>'BRAZIL','code'=>'55'),
    'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
    'BT'=>array('name'=>'BHUTAN','code'=>'975'),
    'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
    'BY'=>array('name'=>'BELARUS','code'=>'375'),
    'BZ'=>array('name'=>'BELIZE','code'=>'501'),
    'CA'=>array('name'=>'CANADA','code'=>'1'),
    'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
    'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
    'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
    'CG'=>array('name'=>'CONGO','code'=>'242'),
    'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
    'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
    'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
    'CL'=>array('name'=>'CHILE','code'=>'56'),
    'CM'=>array('name'=>'CAMEROON','code'=>'237'),
    'CN'=>array('name'=>'CHINA','code'=>'86'),
    'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
    'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
    'CU'=>array('name'=>'CUBA','code'=>'53'),
    'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
    'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
    'CY'=>array('name'=>'CYPRUS','code'=>'357'),
    'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
    'DE'=>array('name'=>'GERMANY','code'=>'49'),
    'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
    'DK'=>array('name'=>'DENMARK','code'=>'45'),
    'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
    'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
    'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
    'EC'=>array('name'=>'ECUADOR','code'=>'593'),
    'EE'=>array('name'=>'ESTONIA','code'=>'372'),
    'ER'=>array('name'=>'ERITREA','code'=>'291'),
    'ES'=>array('name'=>'SPAIN','code'=>'34'),
    'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
    'FI'=>array('name'=>'FINLAND','code'=>'358'),
    'FJ'=>array('name'=>'FIJI','code'=>'679'),
    'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
    'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
    'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
    'FR'=>array('name'=>'FRANCE','code'=>'33'),
    'GA'=>array('name'=>'GABON','code'=>'241'),
    'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
    'GD'=>array('name'=>'GRENADA','code'=>'1473'),
    'GE'=>array('name'=>'GEORGIA','code'=>'995'),
    'GH'=>array('name'=>'GHANA','code'=>'233'),
    'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
    'GL'=>array('name'=>'GREENLAND','code'=>'299'),
    'GM'=>array('name'=>'GAMBIA','code'=>'220'),
    'GN'=>array('name'=>'GUINEA','code'=>'224'),
    'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
    'GR'=>array('name'=>'GREECE','code'=>'30'),
    'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
    'GU'=>array('name'=>'GUAM','code'=>'1671'),
    'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
    'GY'=>array('name'=>'GUYANA','code'=>'592'),
    'HK'=>array('name'=>'HONG KONG','code'=>'852'),
    'HN'=>array('name'=>'HONDURAS','code'=>'504'),
    'HR'=>array('name'=>'CROATIA','code'=>'385'),
    'HT'=>array('name'=>'HAITI','code'=>'509'),
    'HU'=>array('name'=>'HUNGARY','code'=>'36'),
    'ID'=>array('name'=>'INDONESIA','code'=>'62'),
    'IE'=>array('name'=>'IRELAND','code'=>'353'),
    'IL'=>array('name'=>'ISRAEL','code'=>'972'),
    'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
    'IN'=>array('name'=>'INDIA','code'=>'91'),
    'IQ'=>array('name'=>'IRAQ','code'=>'964'),
    'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
    'IS'=>array('name'=>'ICELAND','code'=>'354'),
    'IT'=>array('name'=>'ITALY','code'=>'39'),
    'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
    'JO'=>array('name'=>'JORDAN','code'=>'962'),
    'JP'=>array('name'=>'JAPAN','code'=>'81'),
    'KE'=>array('name'=>'KENYA','code'=>'254'),
    'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
    'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
    'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
    'KM'=>array('name'=>'COMOROS','code'=>'269'),
    'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
    'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
    'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
    'KW'=>array('name'=>'KUWAIT','code'=>'965'),
    'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
    'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
    'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
    'LB'=>array('name'=>'LEBANON','code'=>'961'),
    'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
    'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
    'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
    'LR'=>array('name'=>'LIBERIA','code'=>'231'),
    'LS'=>array('name'=>'LESOTHO','code'=>'266'),
    'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
    'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
    'LV'=>array('name'=>'LATVIA','code'=>'371'),
    'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
    'MA'=>array('name'=>'MOROCCO','code'=>'212'),
    'MC'=>array('name'=>'MONACO','code'=>'377'),
    'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
    'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
    'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
    'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
    'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
    'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
    'ML'=>array('name'=>'MALI','code'=>'223'),
    'MM'=>array('name'=>'MYANMAR','code'=>'95'),
    'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
    'MO'=>array('name'=>'MACAU','code'=>'853'),
    'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
    'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
    'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
    'MT'=>array('name'=>'MALTA','code'=>'356'),
    'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
    'MV'=>array('name'=>'MALDIVES','code'=>'960'),
    'MW'=>array('name'=>'MALAWI','code'=>'265'),
    'MX'=>array('name'=>'MEXICO','code'=>'52'),
    'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
    'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
    'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
    'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
    'NE'=>array('name'=>'NIGER','code'=>'227'),
    'NG'=>array('name'=>'NIGERIA','code'=>'234'),
    'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
    'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
    'NO'=>array('name'=>'NORWAY','code'=>'47'),
    'NP'=>array('name'=>'NEPAL','code'=>'977'),
    'NR'=>array('name'=>'NAURU','code'=>'674'),
    'NU'=>array('name'=>'NIUE','code'=>'683'),
    'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
    'PA'=>array('name'=>'PANAMA','code'=>'507'),
    'PE'=>array('name'=>'PERU','code'=>'51'),
    'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
    'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
    'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
    'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
    'PL'=>array('name'=>'POLAND','code'=>'48'),
    'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
    'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
    'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
    'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
    'PW'=>array('name'=>'PALAU','code'=>'680'),
    'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
    'QA'=>array('name'=>'QATAR','code'=>'974'),
    'RO'=>array('name'=>'ROMANIA','code'=>'40'),
    'RS'=>array('name'=>'SERBIA','code'=>'381'),
    'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
    'RW'=>array('name'=>'RWANDA','code'=>'250'),
    'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
    'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
    'SD'=>array('name'=>'SUDAN','code'=>'249'),
    'SE'=>array('name'=>'SWEDEN','code'=>'46'),
    'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
    'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
    'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
    'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
    'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
    'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
    'SN'=>array('name'=>'SENEGAL','code'=>'221'),
    'SO'=>array('name'=>'SOMALIA','code'=>'252'),
    'SR'=>array('name'=>'SURINAME','code'=>'597'),
    'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
    'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
    'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
    'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
    'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
    'TD'=>array('name'=>'CHAD','code'=>'235'),
    'TG'=>array('name'=>'TOGO','code'=>'228'),
    'TH'=>array('name'=>'THAILAND','code'=>'66'),
    'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
    'TK'=>array('name'=>'TOKELAU','code'=>'690'),
    'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
    'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
    'TN'=>array('name'=>'TUNISIA','code'=>'216'),
    'TO'=>array('name'=>'TONGA','code'=>'676'),
    'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
    'TV'=>array('name'=>'TUVALU','code'=>'688'),
    'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
    'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
    'UA'=>array('name'=>'UKRAINE','code'=>'380'),
    'UG'=>array('name'=>'UGANDA','code'=>'256'),
    'US'=>array('name'=>'UNITED STATES','code'=>'1'),
    'UY'=>array('name'=>'URUGUAY','code'=>'598'),
    'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
    'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
    'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
    'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
    'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
    'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
    'VN'=>array('name'=>'VIET NAM','code'=>'84'),
    'VU'=>array('name'=>'VANUATU','code'=>'678'),
    'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
    'WS'=>array('name'=>'SAMOA','code'=>'685'),
    'XK'=>array('name'=>'KOSOVO','code'=>'381'),
    'YE'=>array('name'=>'YEMEN','code'=>'967'),
    'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
    'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
    'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
    'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
);

$onyx_countries_codes   = get_option('onyx_countries_codes' , true );
$uso_countries_codes    = [];

if ( is_array( $onyx_countries_codes ) && ! empty( $onyx_countries_codes ) ) {

    foreach ( $onyx_countries_codes as $country_key => $onyx_country_code ) {

        $uso_countries_codes[$country_key] = '+' . $country_key;

    }

} else {

    if ( is_array( $uso_countries_code ) && ! empty( $uso_countries_code ) ) {

        foreach ( $uso_countries_code as $country_key => $uso_country_code ) {

            $uso_countries_codes[$country_key] = '+' . $uso_country_code['code'];

        }

    }

}


/*  */
if ( ! function_exists( 'uso_get_setting_field_by_name' ) ) {

    function uso_get_setting_field_by_name( $field_name )
    {
        global $uso_settings;
        $field = ! empty( $uso_settings[$field_name] ) ? $uso_settings[$field_name] : '';

        return $field;
    }

}

$uso_note_before_order_process_ar = ! empty( $uso_settings['uso_note_before_order_process']['ar'] ) ? $uso_settings['uso_note_before_order_process']['ar'] : '';
$uso_note_before_order_process_en = ! empty( $uso_settings['uso_note_before_order_process']['en'] ) ? $uso_settings['uso_note_before_order_process']['en'] : '';

$uso_minimum_order_amount = ! empty( $uso_settings['uso_minimum_order_amount'] )       ? $uso_settings['uso_minimum_order_amount']      : '';
$uso_hide_cod_amount = ! empty( $uso_settings['uso_hide_cod_amount'] )       ? $uso_settings['uso_hide_cod_amount']      : '';


if ( ! function_exists( 'uso_get_note_before_order_process' ) ) {
    function uso_get_note_before_order_process()
    {
        global $uso_note_before_order_process_ar,$uso_note_before_order_process_en;

        $uso_note_before_order_process = [
            'ar' => $uso_note_before_order_process_ar,
            'en' => $uso_note_before_order_process_en
        ];

        return $uso_note_before_order_process;
    }
}

/* Settings Template */
$uso_tabs = array(

    'general' => array(
        'tab_title' => prof_get_switch_language( 'عام' , 'General'  ),
        'title'     => prof_get_switch_language( 'الإعدادات العامه' , 'General Settings'  ),
        'icon'      => 'dashicons-admin-generic',
        'grid'      => '2',
        'items'     => array(
            'uso_sms' => array(
                'title' => prof_get_switch_language('الرسائل','Sms'),
                'inputs' => array(

                    'uso_sms_status' => array(
                        'label'     => prof_get_switch_language('الرسائل','Sms'),
                        'type'      => 'advanced-radio',
                        'options'   => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_sms_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            ),
            'uso_shipping' => array(
                'title' => prof_get_switch_language('الشحن','Shipping'),
                'inputs' => array(

                    'uso_shipping_condition' => array(
                        'label'     => prof_get_switch_language('الشحن','Shipping'),
                        'type'      => 'advanced-radio',
                        'options'   => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_shipping_condition,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            ),

//            'uso_dashboard' => array(
//                'title' => prof_get_switch_language('لوحة التحكم','Dashboard'),
//                'inputs' => array(
//
//                    'uso_dashboard_status' => array(
//                        'label'     => prof_get_switch_language('لوحة التحكم','Dashboard'),
//                        'type'      => 'advanced-radio',
//                        'options'   => array(
//                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
//                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
//                        ),
//                        'default'   => $uso_dashboard_status,
//                        'tooltip'   => prof_get_switch_language('',''),
//                    ),
//
//                ),
//            )

        ),
    ),

    'users' => array(
        'tab_title' => prof_get_switch_language( 'العملاء' , 'Users'  ),
        'title'     => prof_get_switch_language( 'إعدادات المستخدمين' , 'users Settings'  ),
        'icon'      => 'dashicons-groups',
        'grid'      => '2',
        'items'     => array(
            'registration' => array(
                'title' => prof_get_switch_language('التسجيل' ,'Registration' ),
                'inputs' => array(

                    'uso_default_code' => array(
                        'label'     => prof_get_switch_language('كود الدولة الإفتراضي','Default Country Code'),
                        'type'      => 'select',
                        'options'   => $uso_countries_codes,
                        'default'   => $uso_default_code,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

//                    'uso_show_county_code' => array(
//                        'label'         => prof_get_switch_language('إظهار رمز البلد','Show country code'),
//                        'type'          => 'radio',
//                        'options'       => array(
//                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
//                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
//                        ),
//                        'default'   => $uso_show_county_code,
//                        'tooltip'   => prof_get_switch_language('',''),
//                    ),

                    'uso_county_code_choice' => array(
                        'label'         => prof_get_switch_language('السماح بتحديد رمز البلد','Allow selecting country code'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_county_code_choice,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_phone_placeholder' => array(
                        'label'     => prof_get_switch_language('Phone Placeholder ','Phone Placeholder '),
                        'name'      => 'placeholder',
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'    => $uso_phone_placeholder_ar,
                            'en'    => $uso_phone_placeholder_en
                        ),
                        'tooltip'   => prof_get_switch_language('','')
                    ),

                    'uso_email_status' => array(
                        'label'         => prof_get_switch_language('البريد الإلكترونى','Email'),
                        'type'          => 'radio',
                        'options'       => array(
                            'required'      => prof_get_switch_language( 'إجباري'    , 'Required' ),
                            'optional'      => prof_get_switch_language( 'إختياري'    , 'Optional' ),
                        ),
                        'default'   => $uso_email_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_confirm_email' => array(
                        'label'         => prof_get_switch_language('تأكيد البريد الإلكترونى','Confirm Email'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_confirm_email_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_first_name_status' => array(
                        'label'         => prof_get_switch_language('الإسم الأول','First Name'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_first_name_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),


                    'uso_last_name_status' => array(
                        'label'         => prof_get_switch_language('الإسم الأخير','Last Name'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_last_name_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),


                    'uso_full_name_status' => array(
                        'label'         => prof_get_switch_language('الإسم الكامل','Full name'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_full_name_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_company_name_status' => array(
                        'label'         => prof_get_switch_language('اسم الشركة','Company name'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_company_name_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),


                    'uso_ophone_status' => array(
                        'label'         => prof_get_switch_language('هاتف أخر','Other Phone'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_ophone_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_password_status' => array(
                        'label'         => prof_get_switch_language('قوة الرقم السري','Password strength'),
                        'type'          => 'radio',
                        'options'       => array(
                            'weak'        => prof_get_switch_language( 'ضعيفة'    , 'Weak' ),
                            'strong'   => prof_get_switch_language( 'قوية'    , 'Strong' ),
                        ),
                        'default'   => $uso_password_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_confirm_password' => array(
                        'label'         => prof_get_switch_language('تأكيد الرقم السري','Confirm Password'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_confirm_password,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_promotions_subscription' => array(
                        'label'         => __('Promotions Subscription', 'uso'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_promotions_subscription,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'sms_user_reg_msg' => array(
                        'label'     => prof_get_switch_language('النص قبل كود التفعيل','Text before activation code'),
                        'name'      => 'placeholder',
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'    => $sms_user_reg_msg_ar,
                            'en'    => $sms_user_reg_msg_en
                        ),
                        'tooltip'   => prof_get_switch_language('','')
                    ),

                ),
            ),
            'login' => array(
                'title' => prof_get_switch_language('تسجيل الدخول' ,'Log In' ),
                'inputs' => array(
        
                    'uso_rememberme' => array(
                        'label'     => prof_get_switch_language('تحديد اختيار - تذكرني - افتراضيا ','Check Remember-Me option by default'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_rememberme,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_force_login' => array(
                        'label'     => prof_get_switch_language( 'تسجيل الدخول اجباري'    , 'Force Login' ),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'       => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_force_login,
                        'tooltip'   => prof_get_switch_language( 'إجبار المستخدمين على تسجيل الدخول قبل مشاهدة الموقع، برجاء التأكد من تطابق لينكات هذه الصفحات (Refund Returns، About Us، Contact Us) مع (refund-returns، about-us، contact-us) أو ( نفس الأسماء السابقة مع إضافة - رمز اللغة مثل: refund-returns-ar)', 'Force Users To Login Before Viewing The Site, Please make sure the slugs of these pages (Refund Returns, About Us, Contact Us) match (refund-returns, about-us, contact-us) or (Or the same previous names with the addition of - language code ex: refund-returns-ar)' ),
                    ),
                ),
            ),
            /*
                        'address' => array(
                            'title' => prof_get_switch_language('العنوان الإفتراضي','Default Address' ),
                            'inputs' => array(

                                'uso_default_country' => array(
                                    'label'     => prof_get_switch_language('الدولة','Country'),
                                    'type'      => 'select',
                                    'options'   => '',
                                    'default'   => $uso_default_country,
                                    'tooltip'   => prof_get_switch_language('',''),
                                ),

                                'uso_default_region' => array(
                                    'label'     => prof_get_switch_language('المنطقة','Region'),
                                    'type'      => 'select',
                                    'options'   => '',
                                    'default'   => $uso_default_region,
                                    'tooltip'   => prof_get_switch_language('',''),
                                ),

                                'uso_default_city' => array(
                                    'label'     => prof_get_switch_language('المدينة','City'),
                                    'type'      => 'select',
                                    'options'   => '',
                                    'default'   => $uso_default_city,
                                    'tooltip'   => prof_get_switch_language('',''),
                                ),

                                'uso_default_district' => array(
                                    'label'     => prof_get_switch_language('الحي','District'),
                                    'type'      => 'select',
                                    'options'   => '',
                                    'default'   => $uso_default_district,
                                    'tooltip'   => prof_get_switch_language('',''),
                                ),

                            ),
                        ),
            */
        ),
    ),

    'cart' => array(
        'tab_title' => prof_get_switch_language( 'السلة' , 'Cart'  ),
        'title'     => prof_get_switch_language( 'إعدادات السلة' , 'Cart Settings'  ),
        'icon'      => 'dashicons-cart',
        'grid'      => '2',
        'items'     => array(

            'product' => array(
                'title' => prof_get_switch_language('وزن المنتج' ,'Product Weight' ),
                'inputs' => array(

                    'uso_product_weight' => array(
                        'label'         => prof_get_switch_language('إظهار وزن المنتج','Show Product Weight'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_product_weight,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_max_weight' => array(
                        'label'     => prof_get_switch_language('أقصي وزن','Max Weight'),
                        'type'      => 'number',
                        'value'     => $uso_max_weight,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            ),

//            'notes' => array(
//                'title' => prof_get_switch_language('الملاحظات' ,'Notes' ),
//                'inputs' => array(
//
//                    'uso_note_before_order_process' => array(
//                        'label'     => prof_get_switch_language('قبل زر إنهاء الطلب','Before Button Process Order'),
//                        'name'      => 'notes',
//                        'type'      => 'multi_text',
//                        'values'    => array(
//                            'ar'        => $uso_note_before_order_process_ar,
//                            'en'        => $uso_note_before_order_process_en
//                        ),
//                        'tooltip'   => prof_get_switch_language('',''),
//                    ),
//
//                ),
//            ),

        ),
    ),

    'products' => array(
        'tab_title' => prof_get_switch_language( 'المنتجات' , 'Products'  ),
        'title'     => prof_get_switch_language( 'إعدادات المنتجات' , 'Products Settings'  ),
        'icon'      => 'dashicons-admin-page',
        'grid'      => '2',
        'items'     => array(

            'product_images' => array(
                'title' => prof_get_switch_language('تربيط الصور بارقام المنتجات' ,'Linking images to product numbers' ) . ' ( Sku ) ',
                'inputs' => array(

                    'uso_product_images' => array(
                        'label'         => prof_get_switch_language('تربيط الصور ','Attaching images'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_product_images,
                        'tooltip'   => prof_get_switch_language('يتم تربيط الصور بالمنتجات تلقائياً عن طريق كتابة اسم الصور نفس الكود الخاص بالمنتج )SKU(','Products are obtained in the product by typing the image name the same as the code for the product (SKU)'),
                    ),

                ),
            ),

            'product_min_max_qty' => array(
                'title' => prof_get_switch_language('الحد الأدنى و الأقصى للكميات' ,'Min Max Product Quantity' ),
                'inputs' => array(

                    'uso_qty_limit' => array(
                        'label'         => prof_get_switch_language('حقول الكميات ','Quantity Fields'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_qty_limit,
                        'tooltip'   => prof_get_switch_language('اظهار حقول الحد الأدنى و الأقصى للكميات ضمن نافذة المخزون فى التعديل على المنتج','Display min/max quantity fields in inventory tab in the product.'),
                    ),
                ),
            ),
            'front_various_options' => array(
                'title' => prof_get_switch_language('خيارات الواجهة','Front Options'),
                'inputs' => array(
                    'uso_products_show_full_title_option' => array(
                        'label'         => prof_get_switch_language('اظهار عنوان المنتج كامل','Show full product title'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language('تفعيل' ,'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف','No' ),
                        ),
                        'default'   => $uso_products_show_full_title_option,
                        'tooltip'   => prof_get_switch_language('إظهار اسم المنتج كامل عند المرور فوق عنوان المنتج','Show full title when hovering on product title'),
                    ),
                    'uso_display_new_sar_currency_symbol' => array(
                        'label'         => prof_get_switch_language('اظهار رمز العملة الجديد','Show new currency symbol'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language('تفعيل' ,'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف','No' ),
                        ),
                        'default'   => $uso_display_new_sar_currency_symbol,
                        'tooltip'   => prof_get_switch_language('إظهار رمز العملة الجديد الخاص بالمملكة العربية السعودية','Show new Saudi Arabia currency logo'),
                    ),
                ),
            ),
            'extra-fields' => array(
                'title'   => prof_get_switch_language( 'بيانات الحقول الاضافية' , 'Extra Fields Data'  ),
                'inputs'  => array(
                    'uso_use_extra_fields' => array(
                        'label'     => prof_get_switch_language('تفعيل الحقول الاضافية','Activate Extra Fields'),
                        'type'      => 'radio',
                        'options'   => array(
                            'yes'      => prof_get_switch_language( 'نعم'      , 'Yes' ),
                            'no'       => prof_get_switch_language( 'لا'   , 'No' ),
                        ),
                        'default'   => $uso_use_extra_fields,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_fields_columns' => array(
                        'label'     => prof_get_switch_language('عدد الأعمدة','Columns Number'),
                        'type'      => 'radio',
                        'options'   => array(
                            'one'      => prof_get_switch_language( 'عمود واحد'      , 'One Column' ),
                            'two'       => prof_get_switch_language( 'عمودين'   , 'Two Columns' ),
                        ),
                        'default'   => $uso_extra_fields_columns,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_fields_display'  => array(
                        'label'     => prof_get_switch_language('طريقة العرض','Display Method'),
                        'type'      => 'select',
                        'options'   => array(
                            ''        => prof_get_switch_language('اختر طريقة العرض','Choose Display Method'),
                            'table'     => prof_get_switch_language('جدول','Table'),
                            'text'     => prof_get_switch_language('نص','Text'),
                        ),
                        'default'   => $uso_extra_fields_display,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_1_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الأول','Field 1 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_1_title_ar,
                            'en'        => $uso_extra_field_1_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_2_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الثاني','Field 2 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_2_title_ar,
                            'en'        => $uso_extra_field_2_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_3_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الثالث','Field 3 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_3_title_ar,
                            'en'        => $uso_extra_field_3_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_4_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الرابع','Field 4 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_4_title_ar,
                            'en'        => $uso_extra_field_4_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_5_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الخامس','Field 5 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_5_title_ar,
                            'en'        => $uso_extra_field_5_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_6_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل السادس','Field 6 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_6_title_ar,
                            'en'        => $uso_extra_field_6_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_7_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل السابع','Field 7 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_7_title_ar,
                            'en'        => $uso_extra_field_7_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_8_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الثامن','Field 8 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_8_title_ar,
                            'en'        => $uso_extra_field_8_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_9_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل التاسع','Field 9 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_9_title_ar,
                            'en'        => $uso_extra_field_9_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_10_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل العاشر','Field 10 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_10_title_ar,
                            'en'        => $uso_extra_field_10_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_11_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الحادي عشر','Field 11 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_11_title_ar,
                            'en'        => $uso_extra_field_11_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_12_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الثاني عشر','Field 12 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_12_title_ar,
                            'en'        => $uso_extra_field_12_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_13_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الثالث عشر','Field 13 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_13_title_ar,
                            'en'        => $uso_extra_field_13_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_14_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الرابع عشر','Field 14 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_14_title_ar,
                            'en'        => $uso_extra_field_14_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_15_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الخامس عشر','Field 15 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_15_title_ar,
                            'en'        => $uso_extra_field_15_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_16_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل السادس عشر','Field 16 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_16_title_ar,
                            'en'        => $uso_extra_field_16_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_17_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل السابع عشر','Field 17 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_17_title_ar,
                            'en'        => $uso_extra_field_17_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_18_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل الثامن عشر','Field 18 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_18_title_ar,
                            'en'        => $uso_extra_field_18_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_19_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل التاسع عشر','Field 19 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_19_title_ar,
                            'en'        => $uso_extra_field_19_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_extra_field_20_title'  => array(
                        'label'     => prof_get_switch_language('عنوان الحقل العشرون','Field 20 Title'),
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_extra_field_20_title_ar,
                            'en'        => $uso_extra_field_20_title_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                ),
            ),

//            'product_prices' => array(
//                'title' => prof_get_switch_language('اسعار المنتجات' ,'Product Prices' ) . ' ( Sku ) ',
//                'inputs' => array(
//
//                    'uso_price_after_text' => array(
//                        'label'     => prof_get_switch_language('النص بعد السعر','Text After Price'),
//                        'name'      => 'text',
//                        'type'      => 'multi_text',
//                        'values'    => array(
//                            'ar'        => $uso_price_after_text_ar,
//                            'en'        => $uso_price_after_text_en
//                        ),
//                        'tooltip'   => prof_get_switch_language('',''), ),
//
//                ),
//            ),

        ),
    ),

    'single_product' => array(
        'tab_title' => prof_get_switch_language('صفحة المنتج','Single Product'),
        'icon'      => 'dashicons-products',
        'grid'      => '1',
        'items'     => array(
            'front_various_options' => array(
                'title' => prof_get_switch_language('خيارات الواجهة','Front Options'),
                'inputs' => array(
                    'uso_single_product_more_details_option' => array(
                        'label'         => prof_get_switch_language('رابط عرض المزيد من التفاصيل','More Details Link'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_single_product_more_details_option,
                        'tooltip'   => prof_get_switch_language('أضف رابط "المزيد من التفاصيل" بجوار عنوان المنتج للانتقال إلى تفاصيل المنتج (قسم تفاصيل المنتج id=>)#product-tabs-wrapper','Add More-Details link beside product title to scroll you to product details (product details section id=>#product-tabs-wrapper'),
                    ),
                    'uso_single_product_remove_title_from_breadcrumbs_option' => array(
                        'label'         => prof_get_switch_language('إزالة اسم المنتج من مسار التنقل','Remove title from breadcrumb'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_single_product_remove_title_from_breadcrumbs_option,
                        'tooltip'   => prof_get_switch_language('إزالة اسم المنتج من مسار التنقل','Remove product title from breadcrumb'),
                    ),
                ),
            ),
        ),
    ),

    'checkout' => array(
        'tab_title' => prof_get_switch_language( 'إنهاء الطلب' , 'Checkout'  ),
        'title'     => prof_get_switch_language( 'إعدادات إنهاء الطلب' , 'Checkout Settings'  ),
        'icon'      => 'dashicons-clipboard',
        'grid'      => '2',
        'items'     => array(

            'map' => array(
                'title' => prof_get_switch_language('الخريطة' ,'Map' ),
                'inputs' => array(

                    'uso_map_status' => array(
                        'label'         => prof_get_switch_language('حالة الخريطة','Map Status'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_map_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_map_key' => array(
                        'label'     => prof_get_switch_language('مفتاح الخريطة','Map Key'),
                        'type'      => 'text',
                        'value'     => $uso_map_key,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_map_default_lat' => array(
                        'label'     => prof_get_switch_language('العنوان الإفتراضي ( خط العرض )','Default address (latitude)'),
                        'type'      => 'number',
                        'value'     => $uso_map_default_lat,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_map_default_lng' => array(
                        'label'     => prof_get_switch_language('العنوان الإفتراضي ( خط الطول )','Default address (longitude)'),
                        'type'      => 'number',
                        'value'     => $uso_map_default_lng,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    
                    'uso_map_address' => array(
                        'label'         => prof_get_switch_language('تغيير العنوان تلقائي','Automatic Address Change'),
                        'type'          => 'radio',
                        'options'       => array(
                            'yes'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_map_address,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_map_zoom' => array(
                        'label'     => prof_get_switch_language('تكبير الخريطة','Map zoom'),
                        'type'      => 'text',
                        'value'     => $uso_map_zoom,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            ),

            'vat' => array(
//                'title' => prof_get_switch_language('ضريبة القيمة المضافة','Value Added Tax' ),
                'title' => prof_get_switch_language('الضريبة','Tax' ),
                'inputs' => array(

//                    'uso_vat_notice' => array(
//                        'type'      => 'notice',
//                        'notice'    => prof_get_switch_language( 'فى حالة إذا كان سعر المنتجات يشمل الضريبة يرجي إيقاف الضريبة من الووكومرس وتفعيلها من هنا وسوف يتم إضافة نص شامل الضريبة او غير شامل الضريبة على حسب إختيارك بعد السعر وفى حالة شامل الضريبة يتم إظهار الصريبة كملاحظة تحت الإجمالى فى صفحة إتمام الطلب وصفحة السلة' , 'In the event that the price of the products includes tax, please stop the tax from woocommerce and activate it from here, and a text including tax or tax excluding tax will be added according to your choice after the price.' ),
//                    ),
//
//                    'uso_vat_status' => array(
//                        'label'         => prof_get_switch_language('حالة الضريبة','VAT Status'),
//                        'type'          => 'radio',
//                        'options'       => array(
//                            'active'   => prof_get_switch_language( 'تفعيل'    , 'Yes' ),
//                            'no'    => prof_get_switch_language( 'إيقاف'    , 'No' ),
//                        ),
//                        'default'   => $uso_vat_status,
//                        'tooltip'   => prof_get_switch_language('',''),
//                    ),
//
//                    'uso_vat_type' => array(
//                        'label'         => prof_get_switch_language('النص بعد الاسعار فى المتجر','Text after prices in the store'),
//                        'type'          => 'radio',
//                        'options'       => array(
//                            'included'      => prof_get_switch_language( 'شامل الضريبة'     , 'Included' ),
//                            'not_included'  => prof_get_switch_language( 'غير شامل الضريبة' , 'Not Included' ),
//                        ),
//                        'default'   => $uso_vat_type,
//                        'tooltip'   => ''//prof_get_switch_language('إذا كان السعر الاصلي للمنتجات والشحن غير شامل الضريبة فسيتم إضافة الضريبة للسعر فى المنتجات والشحن حيث المتجر يعمل بطريقة شامل الضريبة فقط','If the original price of the products and shipping does not include tax, then the tax will be added to the price in the products and shipping where the store operates in a way that includes tax only'),
//                    ),

//                    'uso_vat_pattern' => array(
//                        'label'         => prof_get_switch_language('نمط ظهور الضريبة','VAT Show Pattern'),
//                        'type'          => 'radio',
//                        'options'       => array(
//                            'price'             => prof_get_switch_language( 'السعر فقط'            , 'Price Only' ),
//                            'price_with_vat'    => prof_get_switch_language( 'السعر + الضريبة'   , 'Price + VAT' ),
//                        ),
//                        'default'   => $uso_vat_pattern,
//                        'tooltip'   => prof_get_switch_language('في حالة كان نمط ظهور الضريبة ( السعر + الضريبة ) فسيتم فصل السعر عن الضريبة فى صفحة السلة وإتمام الطلب وفى حالة كان نمط ظهور الضريبة ( السعر فقط ) فسيتم الإكتفاء بعبارة السعر شامل الضريبة','If the tax appearance pattern is (price + tax), the price will be separated from the tax on the basket page and the order will be completed.'),
//                    ),

//                    'uso_vat_text' => array(
//                        'label'         => prof_get_switch_language('نص الضريبة','VAT Text'),
//                        'type'          => 'radio',
//                        'options'       => array(
//                            'default'   => prof_get_switch_language( 'إحتساب الضريبة'   , 'Vat calculation' ),
//                            'only_text' => prof_get_switch_language( 'إظهار النص فقط'   , 'إظهار النص فقط' ),
//                        ),
//                        'default'   => $uso_vat_text,
//                        'tooltip'   => prof_get_switch_language('',''),
//                    ),

//                    'uso_vat_amount' => array(
//                        'label'     => prof_get_switch_language('مبلغ الضريبة','VAT Amount'),
//                        'type'      => 'number',
//                        'value'     => $uso_vat_amount,
//                        'tooltip'   => prof_get_switch_language('',''),
//                    ),

//                    'uso_vat_shipping_type' => array(
//                        'label'         => prof_get_switch_language('الشحن المجانى','Free Shipping'),
//                        'type'          => 'radio',
//                        'options'       => array(
//                            'included'      => prof_get_switch_language( 'شامل الضريبة'     , 'VAT Included' ),
//                            'not_included'  => prof_get_switch_language( 'غير شامل الضريبة' , 'VAT Not Included' ),
//                        ),
//                        'default'   => $uso_vat_shipping_type,
//                        'tooltip'   => prof_get_switch_language('',''),
//                    ),

                    'uso_tax_number' => array(
                        'label'     => prof_get_switch_language('الرقم الضريبي','Tax Number'),
                        'type'      => 'number',
                        'value'     => $uso_tax_number,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            ),

            'address_fields' => array(
                'title'     => prof_get_switch_language('حقول العنوان','Address Fields' ),
                'inputs'    => $uso_checkout_inputs
            ),

            'notes' => array(
                'title' => prof_get_switch_language('الملاحظات' ,'Notes' ),
                'inputs' => array(

                    'uso_note_before_order_process' => array(
                        'label'     => prof_get_switch_language('قبل زر إنهاء الطلب','Before Button Process Order'),
                        'name'      => 'notes',
                        'type'      => 'multi_text',
                        'values'    => array(
                            'ar'        => $uso_note_before_order_process_ar,
                            'en'        => $uso_note_before_order_process_en
                        ),
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            ),

            'amount' => array(
                'title' => prof_get_switch_language('مبلغ الطلب' ,'Order Amount' ),
                'inputs' => array(
                    'uso_minimum_order_amount' => array(
                        'label'     => prof_get_switch_language('الحد الأدنى لمبلغ الطلب','Minimum Order Amount'),
                        'type'      => 'number',
                        'value'     => $uso_minimum_order_amount,
                    ),

                ),
            ),

            'hide_cod_amount' => array(
                'title' => prof_get_switch_language('اخفاء الدفع عند الاستلام' ,'Hide COD Amount' ),
                'inputs' => array(
                    'uso_hide_cod_amount' => array(
                        'label'     => prof_get_switch_language('الحد الأقصى لظهور الدفع عند الاستلام','Maximum Amount To Show COD'),
                        'type'      => 'number',
                        'value'     => $uso_hide_cod_amount,
                    ),

                ),
            ),

        ),
    ),

    'orders' => array(
        'tab_title' => prof_get_switch_language( 'الطلبات' , 'Orders'  ),
        'title'     => prof_get_switch_language( 'إعدادات الطلبات' , 'Orders Settings'  ),
        'icon'      => 'dashicons-archive',
        'grid'      => '2',
        'items'     => array(
            'orders_data' => array(
                'title' => prof_get_switch_language('إعدادات الطلبات','Orders Settings'),
                'inputs' => $uso_orders_inputs,
            )
        ),
    ),

    'shipping' => array(
        'tab_title' => prof_get_switch_language( 'الشحن' , 'Shipping'  ),
        'title'     => prof_get_switch_language( 'إعدادات الشحن' , 'Shipping Settings'  ),
        'icon'      => 'dashicons-car',
        'grid'      => '2',
        'items'     => array(
            'shipping_various' => array(
                'title' => prof_get_switch_language('إعدادات متنوعة للشحن', 'Shipping Various Settings'),
                'inputs' => array(
                    'uso_hide_shipping_costs' => array(
                        'label' => prof_get_switch_language('إخفاء مصاريف الشحن', 'Shipping Costs Hide'),
                        'type' => 'radio',
                        'options' => array(
                            'yes' => prof_get_switch_language('نعم', 'Yes'),
                            'no' => prof_get_switch_language('لا', 'No'),
                        ),
                        'default' => $uso_hide_shipping_costs,
                        'tooltip' => prof_get_switch_language('اخفاء مصاريف الشحن من صفحة سلة المشتريات', 'Hide Shipping Costs From Cart Page'),
                    ),
                ),
            ),
        ),
    ),

    'payment' => array(
        'tab_title' => prof_get_switch_language( 'الدفع' , 'Payment'  ),
        'title'     => prof_get_switch_language( 'إعدادات الدفع' , 'Payment Settings'  ),
        'icon'      => 'dashicons-money-alt',
        'grid'      => '2',
        'items'     => array(
            'uso_payment' => array(
                'title' => prof_get_switch_language( 'الدفع' , 'Payment'  ),
                'inputs' => array(

                    'uso_payment_cod_tax' => array(
                        'label'     => prof_get_switch_language('تكلفة الدفع عند الإستلام','Cost Of COD'),
                        'type'      => 'number',
                        'value'     => $uso_payment_cod_tax,
                        'tooltip'   => prof_get_switch_language('تكلفة الدفع عند الإستلام','The Cost Of Cash On Delivery'),
                    ),

                    'uso_bacs_status' => array(
                        'label'     => prof_get_switch_language('إظهار حقل التحويل البنكي','Show BACS Field'),
                        'type'      => 'radio',
                        'options'   => array(
                            'yes'       => prof_get_switch_language( 'تشغيل'    , 'Yes' ),
                            'no'        => prof_get_switch_language( 'إيقاف'    , 'No' ),
                        ),
                        'default'   => $uso_bacs_status,
                        'tooltip'   => prof_get_switch_language('إظهار حقل التحويل البنكي فى صفحة إنهاء الطلب','Show the bank transfer field on the order completion page'),
                    ),

                ),
            )
        ),
    ),

    'sms' => array(
        'tab_title' => prof_get_switch_language( 'الرسائل' , 'Sms'  ),
        'title'     => prof_get_switch_language( 'إعدادات الرسائل' , 'Sms Settings'  ),
        'icon'      => 'dashicons-email-alt',
        'grid'      => '2',
        'items'     => array(

            'phone_sms_data' => array(
                'title'     => prof_get_switch_language( 'بيانات مقدم خدمة رسائل الجوال' , 'Phone message service provider data'  ),
                'inputs'    => array(

                    'uso_sms_provider'  => array(
                        'label'     => prof_get_switch_language('مقدم الخدمة','Provider'),
                        'type'      => 'select',
                        'options'   => array(
                            ''              => prof_get_switch_language('اختر مقدم الخدمة','Select Your Provider'),
                            'jawalbsms'     => 'Jawalb',
                            'victorylink'   => 'Victory Link',
                            'alfa'          => 'Alfa',
                            'unifonic'      => 'Unifonic',
                            'ismartsms'     => 'I Smart',
                            'hisms'         => 'HiSms',
                            'oursms'        => 'OurSms',
                            'taqnyat'       => 'Taqnyat',
                            'mshastra'      => 'Mshastra',
                            'united'        => 'United SMS',
                            'turkeysms'     => 'Turkey SMS',
                            'awe'           => 'AWe',
                            'bab'           => 'BAB SMS',
//                            'whatsapp'      => 'Whatsapp',
                        ),
                        'default'   => $uso_sms_provider,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_sms_url'       => array(
                        'label'     => prof_get_switch_language('الرابط','Url'),
                        'type'      => 'text',
                        'value'     => $uso_sms_url,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_sms_user'      => array(
                        'label'     => prof_get_switch_language('إسم المستخدم','User'),
                        'type'      => 'text',
                        'value'     => $uso_sms_user,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_sms_password'  => array(
                        'label'     => prof_get_switch_language('الباسورد','Password'),
                        'type'      => 'password',
                        'value'     => $uso_sms_password,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_sms_accesskey'  => array(
                        'label'     => prof_get_switch_language('مفتاح الدخول','Access Key'),
                        'type'      => 'text',
                        'value'     => $uso_sms_accesskey,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                    'uso_sms_sender'    => array(
                        'label'     => prof_get_switch_language('المرسل','Sender'),
                        'type'      => 'text',
                        'value'     => $uso_sms_sender,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),
                ),
            ),

            'whatsapp_sms_data' => array(
                'title'     => prof_get_switch_language( 'بيانات مقدم خدمة رسائل الواتساب' , 'Whatsapp message service provider data'  ),
                'inputs'    => array(

                    'uso_wa_sms_provider'  => array(
                        'label'     => prof_get_switch_language('مقدم الخدمة','Provider'),
                        'type'      => 'select',
                        'options'   => array(
                            ''              => prof_get_switch_language('اختر مقدم الخدمة','Select Your Provider'),
                            'api_chat'      => 'Chat API',
                        ),
                        'default'   => $uso_wa_sms_provider,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_wa_sms_url'       => array(
                        'label'     => prof_get_switch_language('الرابط','Url'),
                        'type'      => 'text',
                        'value'     => $uso_wa_sms_url,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_wa_sms_user'      => array(
                        'label'     => prof_get_switch_language('إسم المستخدم','User'),
                        'type'      => 'text',
                        'value'     => $uso_wa_sms_user,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_wa_sms_password'  => array(
                        'label'     => prof_get_switch_language('الباسورد','Password'),
                        'type'      => 'password',
                        'value'     => $uso_wa_sms_password,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                    'uso_wa_sms_sender'    => array(
                        'label'     => prof_get_switch_language('المرسل','Sender'),
                        'type'      => 'text',
                        'value'     => $uso_wa_sms_sender,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            ),

            'send_msg_when' => array(
                'title' => prof_get_switch_language('إرسال الرسالة عند' ,'Send Message When' ),
                'inputs' => $uso_sms_inputs,
            ),
        ),
    ),

    'dev' => array(
        'tab_title' => prof_get_switch_language( 'وضع المطور' , 'Dev Mode'  ),
        'title'     => prof_get_switch_language( 'إعدادات متقدمة' , 'Advanced Settings'  ),
        'icon'      => 'dashicons-shield-alt',
        'grid'      => '2',
        'items'     => array(
            'uso_payment' => array(
                'title' => prof_get_switch_language( 'إعدادات متقدمة' , 'Advanced Settings'  ),
                'inputs' => array(

                    'uso_dev_mode_status' => array(
                        'label'     => prof_get_switch_language('وضع البلجن','Plugin Status'),
                        'type'      => 'radio',
                        'options'   => array(
                            'live'      => prof_get_switch_language( 'لايف'      , 'Live' ),
                            'test'      => prof_get_switch_language( 'تجريبي'   , 'Test' ),
                        ),
                        'default'   => $uso_dev_mode_status,
                        'tooltip'   => prof_get_switch_language('',''),
                    ),

                ),
            )
        ),
    ),

    'various' => array(
        'tab_title' => prof_get_switch_language('خيارات متنوعة', 'Various Options'),
        'title' => prof_get_switch_language('إعدادات متنوعة', 'Various Settings'),
        'icon' => 'dashicons-shield-alt',
        'grid' => '2',
        'items' => array(
            'uso_various' => array(
                'title' => prof_get_switch_language('إعدادات متنوعة', 'Various Settings'),
                'inputs' => array(
                    'uso_change_availability_text' => array(
                        'label' => prof_get_switch_language('نص عدم توافر المنتج', 'Unavailable Product Text'),
                        'name' => 'name',
                        'type' => 'multi_text',
                        'values' => array(
                            'ar' => $uso_change_availability_text_ar,
                            'en' => $uso_change_availability_text_en
                        ),
                        'tooltip' => prof_get_switch_language('تغيير نص عدم توافر المنتج', 'Change Unavailable Product Text'),
                    ),
                    'uso_change_product_available_text' => array(
                        'label' => prof_get_switch_language('نص توافر المنتج', 'Available Product Text'),
                        'name' => 'name',
                        'type' => 'multi_text',
                        'values' => array(
                            'ar' => $uso_change_product_available_text_ar,
                            'en' => $uso_change_product_available_text_en
                        ),
                        'tooltip' => prof_get_switch_language('نص توافر المنتج', 'Change Available Product Text'),
                    ),
                    'uso_long_des_compare' => array(
                        'label' => prof_get_switch_language('الوصف الطويل', 'Long Description'),
                        'type' => 'radio',
                        'options' => array(
                            'yes' => prof_get_switch_language('نعم', 'yes'),
                            'no' => prof_get_switch_language('لا', 'no'),
                        ),
                        'default' => $uso_long_desc_compare,
                        'tooltip' => prof_get_switch_language('اضافة الوصف الطويل فى صفحة المقارنة', 'Add Long Description In Compare Page'),
                    ),
                    'uso_add_payment_to_user' => array(
                        'label' => prof_get_switch_language('اختيار طريقة الدفع مع المستخدم', 'Choose Payment with User'),
                        'type' => 'radio',
                        'options' => array(
                            'yes' => prof_get_switch_language('نعم', 'yes'),
                            'no' => prof_get_switch_language('لا', 'no'),
                        ),
                        'default' => $uso_add_payment_touser,
                        'tooltip' => prof_get_switch_language('اختيار طريقة الدفع حسب كل مستخدم', 'Choose Payment Method for Each User'),
                    ),
                    'uso_add_total' => array(
                        'label' => prof_get_switch_language('مجموع المنتج المجمع', 'Total Price of Variable Product'),
                        'type' => 'radio',
                        'options' => array(
                            'yes' => prof_get_switch_language('نعم', 'yes'),
                            'no' => prof_get_switch_language('لا', 'no'),
                        ),
                        'default' => $uso_add_total,
                        'tooltip' => prof_get_switch_language('اظهار اجمالى للمنتج المجمع داخل صفحة المنتج أثناء إضافة العناصر', 'Show Total of Variable Product Inside The Variable Product Page During Adding Element'),
                    ),
                    'uso_qr_generate' => array(
                        'label'     => prof_get_switch_language('عرض QR','QR Display'),
                        'type'      => 'radio',
                        'options'   => array(
                            'yes'      => prof_get_switch_language( 'نعم'      , 'Yes' ),
                            'no'      => prof_get_switch_language( 'لا'   , 'No' ),
                        ),
                        'default'   => $uso_qr_generate,
                        'tooltip'   => prof_get_switch_language('عرض كود ال QR فى صفحة اتمام الطلب','Display QR Code In Thankyou Page'),
                    ),
                    'uso_move_product_to_last' => array(
                        'label'     => prof_get_switch_language('المنتجات أسفل الصفحة عند نفاذ المخزون','Move Out of Stock Products'),
                        'type'      => 'radio',
                        'options'   => array(
                            'yes'      => prof_get_switch_language( 'نعم'      , 'Yes' ),
                            'no'      => prof_get_switch_language( 'لا'   , 'No' ),
                        ),
                        'default'   => $uso_move_product_to_last,
                        'tooltip'   => prof_get_switch_language('نقل المنتجات التى كميتها منتهية الى أسفل الصفحات','Move Out of Stock Products To The End of Page'),
                    ),
                    'uso_add_shipped_order_status' => array(
                        'label'     => prof_get_switch_language('اضافة حالة طلب','Add Shipped Order Status'),
                        'type'      => 'radio',
                        'options'   => array(
                            'yes'      => prof_get_switch_language( 'نعم'      , 'Yes' ),
                            'no'      => prof_get_switch_language( 'لا'   , 'No' ),
                        ),
                        'default'   => $uso_add_shipped_order_status,
                        'tooltip'   => prof_get_switch_language('اضافة حالة قيد التسليم لشركة الشحن','Add Shipped Order Status'),
                    ),
                    'uso_use_you_save' => array(
                        'label'     => prof_get_switch_language('استخدام حقل وفر','Use Save In Product'),
                        'type'      => 'radio',
                        'options'   => array(
                            'yes'      => prof_get_switch_language( 'نعم'      , 'Yes' ),
                            'no'      => prof_get_switch_language( 'لا'   , 'No' ),
                        ),
                        'default'   => $uso_use_you_save,
                        'tooltip'   => prof_get_switch_language('عرض عبارة وفر فى صفحة المنتج و كارت المنتج','Display Save Sentence In Product Page & Card'),
                    ),
                    // 'uso_product_wo_thumbnail' => array(
                    //     'label'     => prof_get_switch_language('حالة المنتج بدون صورة','Product Without Image Status'),
                    //     'type'      => 'radio',
                    //     'options'   => array(
                    //         'display' => prof_get_switch_language( 'عرض'      , 'Display' ),
                    //         'hide'      => prof_get_switch_language( 'إخفاء'   , 'Hide' ),
                    //         'delete'      => prof_get_switch_language( 'حذف'   , 'Delete' ),
                    //     ),
                    //     'default'   => $uso_product_wo_thumbnail,
                    //     'tooltip'   => prof_get_switch_language('حالة عرض المنتج الذي لا يحتوى على صورة','Status of Product that does not contain image'),
                    // ),
                ),
            ),
            'uso_html_blocks' => array(
                'title' => prof_get_switch_language('البلوكس الإضافية', 'Additional HTML Blocks'),
                'inputs' => array(
                    'uso_shop_footer_html_blocks' => array(
                        'label' => prof_get_switch_language('المحتوى المخصص أسفل صفحة الشوب', 'Shop Footer HTML Block'),
                        'type' => 'text',
                        'value' => $uso_shop_footer_html_blocks,
                        'tooltip' => prof_get_switch_language('لإظهار محتوى مخصص أسفل صفحة الشوب', 'Enter the BLOCK ID ONLY to display custom html block in shop page footer'),
                    ),
                    'uso_cart_footer_html_blocks' => array(
                        'label' => prof_get_switch_language('المحتوى المخصص أسفل صفحة سلة المشتريات', 'Cart Footer HTML Block'),
                        'type' => 'text',
                        'value' => $uso_cart_footer_html_blocks,
                        'tooltip' => prof_get_switch_language('لإظهار محتوى مخصص أسفل صفحة سلة المشتريات', 'Enter the BLOCK ID ONLY to display custom html block in cart page footer'),
                    ),
                    'uso_product_footer_html_blocks' => array(
                        'label' => prof_get_switch_language('المحتوى المخصص أسفل صفحة المنتج', 'Product Footer HTML Block'),
                        'type' => 'text',
                        'value' => $uso_product_footer_html_blocks,
                        'tooltip' => prof_get_switch_language('لإظهار محتوى مخصص أسفل صفحة المنتج', 'Enter the BLOCK ID ONLY to display custom html block in product page footer'),
                    ),
                ),
            )
        ),
    ),
);

/* Activation Template */
$uso_active_tabs = array(
    'activation' => array(
        'tab_title' => prof_get_switch_language( 'التفعيل' , 'Activation'  ),
        'title'     => prof_get_switch_language( 'التفعيل' , 'Activation'  ),
        'icon'      => 'dashicons-admin-generic',
        'grid'      => '2',
        'items'     => array(
            'uso_active_key' => array(
                'title'     => prof_get_switch_language('كود التفعيل','Activation Code'),
                'inputs'    => array(
                    'uso_activation' => array(
                        'label'         => prof_get_switch_language('كود التفعيل','Activation Code'),
                        'type'          => 'password',
                        'value'         => $uso_activation_code,
                        'tooltip'       => prof_get_switch_language('',''),
                    ),
                ),
            ),
        ),
    ),
);

if ( ! function_exists( 'uso_input_condition' ) ) {

    function uso_input_condition( $condition ) {

        $operator   = $condition['operator'];
        $field      = $condition['field'] == $condition['value'];
        if ( $operator == '!==' )
            $field      = $condition['field'] !== $condition['value'];

        if ( ! $field )
            return false;

        return true;

    }

}

if ( ! function_exists( 'uso_get_select_input_html' ) ) {

    function uso_get_select_input_html( $key , $values )
    {

        $label          = $values['label'];
        $options        = $values['options'];
        $default_option = $values['default'];
        $tooltip        = $values['tooltip']    ?? '';
        $tooltip_class  = ! empty( $values['tooltip'] ) ? 'tooltip-alert' : '' ;

        $condition      = isset( $values['condition'] ) ? uso_input_condition( $values['condition'] ) : true ;
        if ( ! $condition )
            return false;

        $filter_key = explode( '[' , $key );

        ?>
        <div class="uso-form-group uso-flex" id="<?php echo $filter_key[0]; ?>_field">
            <label class="w-100" for="<?php echo $key; ?>">
                <?php echo $label; ?>
            </label>

            <select class="w-200" name="<?php echo $key; ?>" id="<?php echo $key; ?>">

                <?php

                if ( is_array( $options ) && ! empty( $options ) ) {

                    foreach ( $options as $option_key => $option_name ) {

                        echo '<option value="'.$option_key.'" '. prof_get_check_value( $default_option , $option_key , ' selected' ) .'>'.$option_name.'</option>';

                    }

                }

                ?>

            </select>
            <div class="uso-tooltip w-50 <?php echo $tooltip_class; ?>">
                <div class="dashicons-before dashicons-editor-help"><br></div>
                <span class="uso-tooltip-text">
                    <?php echo $tooltip; ?>
                </span>
            </div>
        </div>

    <?php }

}

if ( ! function_exists( 'uso_get_multi_text_input_html' ) ) {

    function uso_get_multi_text_input_html( $key , $values )
    {

        $label      = $values['label'];
        $name       = $values['name'];
        $inputs     = $values['values'];
        $tooltip        = $values['tooltip']    ?? '';
        $tooltip_class  = ! empty( $values['tooltip'] ) ? 'tooltip-alert' : '' ;

        $condition      = isset( $values['condition'] ) ? uso_input_condition( $values['condition'] ) : true ;
        if ( ! $condition )
            return false;

        $filter_key = explode( '[' , $key );

        ?>

        <div class="uso-form-group uso-flex" id="<?php echo $filter_key[0]; ?>_field">
            <label class="w-100" for="<?php echo $filter_key[0]; ?>">
                <?php echo $label; ?>
            </label>

            <div class="pj-tabs">

                <?php if ( is_array( $inputs ) && ! empty( $inputs ) ) {

//                    if ( $popup === true ) {
//
//                        echo '<a href="#" class="button button-primary uso-modal-btn" data-plugin="'.$filter_key[0].'"></a>';
//
//                    }


                    foreach ( $inputs as $input => $value ) {
                        ?>
                        <div class="pj-tab">
                            <input type="radio" class="uso-input-pj-tab" id="<?php echo $filter_key[0] . '_' . $name . '_' . $input; ?>" name="<?php echo $filter_key[0] . '_' . $name; ?>_field"
                                   checked>
                            <label for="<?php echo $filter_key[0] . '_' . $name . '_' . $input; ?>" class="uso-label-pj-tab">
                                <?php echo $input; ?>
                            </label>
                            <div class="pj-tab-content">
                                <div class="pj-group pj-text">
                                    <input type="text" name="<?php echo $key.'['.$input.']'; ?>" value="<?php echo $value; ?>">
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
            <div class="uso-tooltip w-50 <?php echo $tooltip_class; ?>">
                <div class="dashicons-before dashicons-editor-help"><br></div>
                <span class="uso-tooltip-text">
                    <?php echo $tooltip; ?>
                </span>
            </div>
        </div>

    <?php }

}

if ( ! function_exists( 'uso_get_text_input_html' ) ) {

    function uso_get_text_input_html( $key , $values )
    {

        $type       = $values['type'];
        $label      = $values['label'];
        $value      = $values['value'];
        $tooltip        = $values['tooltip']    ?? '';
        $tooltip_class  = ! empty( $values['tooltip'] ) ? 'tooltip-alert' : '' ;

        $condition      = isset( $values['condition'] ) ? uso_input_condition( $values['condition'] ) : true ;
        if ( ! $condition )
            return false;

        $filter_key = explode( '[' , $key );

        ?>
        <div class="uso-form-group uso-flex" id="<?php echo $filter_key[0]; ?>_field">
            <label class="w-100" for="<?php echo $filter_key[0]; ?>">
                <?php echo $label; ?>
            </label>

            <input type="<?php echo $type; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" <?php echo ($type== 'number' ? 'step="any"' : '');?> value="<?php echo esc_attr($value); ?>" class="w-200">
            
            <div class="uso-tooltip w-50 <?php echo $tooltip_class; ?>">
                <div class="dashicons-before dashicons-editor-help"><br></div>
                <span class="uso-tooltip-text">
                    <?php echo $tooltip; ?>
                </span>
            </div>
        </div>

    <?php }

}

if ( ! function_exists( 'uso_get_radio_input_html' ) ) {

    function uso_get_radio_input_html( $key , $values , $number = '' )
    {

        $label          = $values['label']      ?? '';
        $options        = $values['options']    ?? '';
        $default_option = $values['default']    ?? '';
        $tooltip        = $values['tooltip']    ?? '';
        $tooltip_class  = ! empty( $values['tooltip'] ) ? 'tooltip-alert' : '' ;

        $condition      = isset( $values['condition'] ) ? uso_input_condition( $values['condition'] ) : true ;
        if ( ! $condition )
            return false;

        $filter_key = explode( '[' , $key );

        ?>
        <div class="uso-form-group uso-flex" id="<?php echo $filter_key[0]; ?>_field">
            <label class="w-100" for="<?php echo $filter_key[0]; ?>">
                <?php echo $label; ?>
            </label>

            <div class="w-200 uso-flex">
                <?php

                if ( is_array( $options ) && ! empty( $options ) ) {

                    foreach ( $options as $option_key => $option_name ) { ?>

                        <div class="uso-group uso-check"> <?php //id="<?php echo $filter_key[0] . '_' .$option_key;" ?>
                            <input type="radio" name="<?php echo $key ?>" id="<?php echo $filter_key[0] . '_' .$option_key . $number; ?>"
                                   value="<?php echo $option_key; ?>" <?php prof_check_value( $default_option , $option_key ); ?> >
                            <label class="uso_<?php echo $option_key ?>" for="<?php echo $filter_key[0] . '_' .$option_key . $number; ?>">
                                <?php echo $option_name; ?>
                            </label>
                        </div>

                    <?php  }
                } ?>
            </div>
            <!--            #ffbc00-->
            <div class="uso-tooltip w-50 <?php echo $tooltip_class; ?>">
                <div class="dashicons-before dashicons-editor-help"><br></div>
                <span class="uso-tooltip-text">
                    <?php echo $tooltip; ?>
                </span>
            </div>
        </div>

    <?php }

}

if ( ! function_exists( 'uso_get_advanced_radio_input_html' ) ) {

    function uso_get_advanced_radio_input_html( $key , $values )
    {

        $label          = $values['label'];
        $options        = $values['options'];
        $default_option = $values['default'];
        $tooltip        = $values['tooltip']    ?? '';
        $tooltip_class  = ! empty( $values['tooltip'] ) ? 'tooltip-alert' : '' ;

        $condition      = isset( $values['condition'] ) ? uso_input_condition( $values['condition'] ) : true ;
        if ( ! $condition )
            return false;

        $filter_key = explode( '[' , $key );

        ?>

        <div class="uso-form-group uso-w-100" id="<?php echo $filter_key[0]; ?>_field">

            <div class="uso-radio-inputs">
                <?php

                if ( is_array( $options ) && ! empty( $options ) ) {

                foreach ( $options as $option_key => $option_name ) { ?>
                    <input type="radio" name="<?php echo $key; ?>" value="<?php echo $option_key; ?>" class="uso-<?php echo $option_key; ?>" id="<?php echo $key . '_' .$option_key; ?>" <?php prof_check_value( $default_option , $option_key ); ?> />
                <?php  } ?>

                <div class="switch">
                    <?php foreach ( $options as $option_key => $option_name ) { ?>
                        <label for="<?php echo $key . '_' .$option_key; ?>" class="uso-<?php echo $option_key; ?>"><?php echo $option_name; ?></label>
                    <?php  }
                    } ?>
                    <span></span>
                </div>
            </div>

        </div>

    <?php }

}

if ( ! function_exists( 'uso_get_checkbox_input_html' ) ) {

    function uso_get_checkbox_input_html( $key , $values )
    {

        $label          = $values['label'];
        $options        = $values['options'];
        $default_option = $values['default'];
        $tooltip        = $values['tooltip']    ?? '';
        $tooltip_class  = ! empty( $values['tooltip'] ) ? 'tooltip-alert' : '' ;

        $condition      = isset( $values['condition'] ) ? uso_input_condition( $values['condition'] ) : true ;
        if ( ! $condition )
            return false;

        $filter_key = explode( '[' , $key );

        ?>
        <div class="uso-form-group" id="<?php echo $filter_key[0]; ?>_field">
            <label class="w-100" for="<?php echo $filter_key[0]; ?>">
                <?php echo $label; ?>
                <div class="uso-tooltip uso-d-inline-b">
                    <div class="dashicons-before dashicons-editor-help"><br></div>
                    <span class="uso-tooltip-text">
                    <?php echo $tooltip; ?>
                </span>
                </div>
            </label>

            <div class="w-200">

                <?php

                if ( is_array( $options ) && ! empty( $options ) ) {

                    foreach ( $options as $option_key => $option_name ) {

                        $checked = ( is_array( $default_option ) && array_key_exists( $option_key , $default_option ) ) ? 'checked' : '';

                        echo '<div class="uso-input-group"><input type="checkbox" name="'.$key.'[' . $option_key . ']" id="uso-check-' . $option_key . '" value="' . $option_key . '" ' . $checked . '><label for="uso-check-' . $option_key . '"> ' . $option_name  . ' </label></div>';

                    }

                }

                ?>

            </div>

        </div>

    <?php }

}

if ( ! function_exists( 'uso_get_popup_inputs_html' ) ) {

    function uso_get_popup_inputs_html( $key , $values )
    {
        $label      = $values['label'];
        $tooltip        = $values['tooltip']    ?? '';
        $tooltip_class  = ! empty( $values['tooltip'] ) ? 'tooltip-alert' : '' ;
        $inputs     = $values['inputs'];

        $condition      = isset( $values['condition'] ) ? uso_input_condition( $values['condition'] ) : true ;
        if ( ! $condition )
            return false;

        $filter_key = explode( '[' , $key );

        ?>

        <div class="uso-form-group uso-flex" id="<?php echo $filter_key[0]; ?>_field">
            <label class="w-100" for="<?php echo $filter_key[0]; ?>">
                <?php echo $label; ?>
            </label>

            <div class="pj-tabs" style="min-height: auto;text-align: center">

                <?php if ( is_array( $inputs ) && ! empty( $inputs ) ) {

                    echo '<a href="#" class="button button-primary uso-modal-btn" data-plugin="'.$key.'_popup">'.prof_get_switch_language('تعديل','Edit').'</a>'; ?>

                    <!--Overlay & Modal-->
                    <div class="uso-overlay" id="<?php echo $key; ?>_popup">

                        <div class="uso-modal">

                            <div class="wp-menu-image dashicons-before dashicons-no uso-close-btn" data-plugin="<?php echo $key; ?>_popup">
                                <br>
                            </div>

                            <h4 class="uso-popup-title">
                                <?php echo $label; ?>
                            </h4>

                            <div class="uso-modal-content">

                                <?php

                                if ( is_array( $inputs ) && ! empty( $inputs ) ) {

                                    $number = 0;

                                    foreach ( $inputs as  $key => $input ) {

                                        $input_type = $input['type'];

                                        if ( $input_type == 'select' ) {

                                            uso_get_select_input_html( $key , $input );

                                        } elseif ( $input_type == 'text' || $input_type == 'password' || $input_type == 'number' ) {

                                            uso_get_text_input_html( $key , $input );

                                        } elseif ( $input_type == 'multi_text' ) {

                                            uso_get_multi_text_input_html( $key , $input );

                                        } elseif ( $input_type == 'radio' ) {

                                            uso_get_radio_input_html( $key , $input , $number );

                                        } elseif ( $input_type == 'advanced-radio' ) {

                                            uso_get_advanced_radio_input_html( $key , $input );

                                        } elseif ( $input_type == 'checkbox' ) {

                                            uso_get_checkbox_input_html( $key , $input );

                                        }

                                        $number++;

                                    }

                                }

                                ?>

                            </div>

                        </div>

                    </div>

                <?php } ?>
            </div>
            <div class="uso-tooltip w-50 <?php echo $tooltip_class; ?>">
                <div class="dashicons-before dashicons-editor-help"><br></div>
                <span class="uso-tooltip-text">
                    <?php echo $tooltip; ?>
                </span>
            </div>
        </div>

    <?php }

}

if ( ! function_exists( 'uso_get_notice_html' ) ) {

    function uso_get_notice_html( $notice )
    {
        echo '<div class="uso-notice">' .  $notice . '</div>';
    }

}

/* Change Stock Availability Text */
add_filter('woocommerce_get_availability', 'custom_get_availability', 1, 2);
function custom_get_availability($availability, $_product)
{
    global $product, $uso_change_availability_text_ar, $uso_change_availability_text_en, $uso_change_product_available_text_ar, $uso_change_product_available_text_en;
    if (!$_product->is_in_stock() && !empty($uso_change_availability_text_ar && $uso_change_availability_text_en)) {
        echo "<p class='stock out-of-stock'>";
        $availability['availability'] = prof_the_switch_language($uso_change_availability_text_ar, $uso_change_availability_text_en);
        echo "</p>";
    } elseif ($_product->is_in_stock() && !empty($uso_change_product_available_text_ar && $uso_change_product_available_text_en)) {
        echo "<p class='stock in-stock'>";
        $availability['availability'] = prof_the_switch_language($uso_change_product_available_text_ar, $uso_change_product_available_text_en);
        echo "</p>";
    }

    return $availability;
}

/* Hide Shipping From Cart Page */
if ($uso_hide_shipping_costs == 'yes') {
    /* Remove Shipping From Cart Page */
    add_filter('woocommerce_cart_needs_shipping', 'filter_cart_needs_shipping');
    function filter_cart_needs_shipping($needs_shipping)
    {
        if (is_cart()) {
            $needs_shipping = false;
        }
        return $needs_shipping;
    }
}

// if yes add compare to options in wood mart
if ($uso_long_desc_compare == 'yes') {
    if (!function_exists('woodmart_get_compare_fields')) {
        /**
         * Get compare fields data.
         *
         * @since 3.3
         */
        function woodmart_get_compare_fields()
        {
            $fields = array(
                'basic' => ''
            );

            $fields_settings = woodmart_get_opt('fields_compare');

            if (class_exists('XTS\Options') && count($fields_settings) > 0) {
                $fields_labels = woodmart_compare_available_fields(true);

                foreach ($fields_settings as $field) {
                    if (isset($fields_labels [$field])) {
                        $fields[$field] = $fields_labels [$field]['name'];
                    }
                }

                return $fields;
            }

            if (isset($fields_settings['enabled']) && count($fields_settings['enabled']) > 1) {
                $fields = $fields + $fields_settings['enabled'];
                unset($fields['placebo']);
            }


            return $fields;
        }
    }
    if (!function_exists('woodmart_compare_display_field')) {
        /**
         * Get compare fields data.
         *
         * @since 3.3
         */
        function woodmart_compare_display_field($field_id, $product)
        {
            woodmart_enqueue_js_script('woodmart-compare');

            $type = $field_id;

            if ('pa_' === substr($field_id, 0, 3)) {
                $type = 'attribute';
            }

            switch ($type) {
                case 'basic':
                    echo '<div class="compare-basic-content">';
                    echo '<div class="wd-action-btn wd-style-text wd-cross-icon"><a href="#" rel="nofollow" class="wd-compare-remove" data-id="' . esc_attr($product['id']) . '">' . esc_html__('Remove', 'woodmart') . '</a></div>';
                    echo '<a class="product-image" href="' . get_permalink($product['id']) . '">' . $product['basic']['image'] . '</a>';
                    echo '<a class="wd-entities-title" href="' . get_permalink($product['id']) . '">' . $product['basic']['title'] . '</a>';
                    echo wp_kses_post($product['basic']['rating']);
                    echo '<div class="price">';
                    echo wp_kses_post($product['basic']['price']);
                    echo '</div>';
                    if (!woodmart_get_opt('catalog_mode')) {
                        echo apply_filters('woodmart_compare_add_to_cart_btn', $product['basic']['add_to_cart']);
                    }
                    echo '</div>';
                    break;

                case 'attribute':
                    if ($field_id === woodmart_get_opt('brands_attribute')) {
                        $brands = wc_get_product_terms($product['id'], $field_id, array('fields' => 'all'));

                        if (empty($brands)) {
                            echo apply_filters('woodmart_compare_empty_field_symbol', '-');
                            return;
                        }

                        foreach ($brands as $brand) {
                            $image = get_term_meta($brand->term_id, 'image', true);

                            if (!empty($image)) {
                                echo '<div class="wd-compare-brand' . woodmart_get_old_classes(' woodmart-compare-brand') . '">';
                                echo apply_filters('woodmart_image', '<img src="' . esc_url($image) . '" title="' . esc_attr($brand->name) . '" alt="' . esc_attr($brand->name) . '" />');
                                echo '</div>';
                            } else {
                                echo wp_kses_post($product[$field_id]);
                            }

                        }
                    } else {
                        echo wp_kses_post($product[$field_id]);
                    }
                    break;

                case 'weight':
                    if ($product[$field_id]) {
                        $unit = $product[$field_id] !== apply_filters('woodmart_compare_empty_field_symbol', '-') ? get_option('woocommerce_weight_unit') : '';
                        echo wc_format_localized_decimal($product[$field_id]) . ' ' . esc_attr($unit);
                    }
                    break;

                case 'description':
                    echo apply_filters('woocommerce_short_description', $product[$field_id]);
                    break;
                case 'long':
                    echo apply_filters('the_content', $product[$field_id]);
                    break;
                default:
                    echo wp_kses_post($product[$field_id]);
                    break;
            }
        }
    }
    if (!function_exists('woodmart_compare_available_fields')) {
        function woodmart_get_compared_products_data()
        {
            $ids = woodmart_get_compared_products();

            if (empty($ids)) {
                return array();
            }

            $args = array(
                'include' => $ids,
                'limit' => 100,
            );

            $products = wc_get_products($args);

            $products_data = array();

            $fields = woodmart_get_compare_fields();

            $fields = array_filter($fields, function ($field) {
                return 'pa_' === substr($field, 0, 3);
            }, ARRAY_FILTER_USE_KEY);

            $divider = apply_filters('woodmart_compare_empty_field_symbol', '-');

            foreach ($products as $product) {
                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();

                $products_data[$product->get_id()] = array(
                    'basic' => array(
                        'title' => $product->get_title() ? $product->get_title() : $divider,
                        'image' => $product->get_image() ? $product->get_image() : $divider,
                        'rating' => wc_get_rating_html($average, $rating_count),
                        'price' => $product->get_price_html() ? $product->get_price_html() : $divider,
                        'add_to_cart' => woodmart_compare_add_to_cart_html($product) ? woodmart_compare_add_to_cart_html($product) : $divider,
                    ),
                    'id' => $product->get_id(),
                    'image_id' => $product->get_image_id(),
                    'permalink' => $product->get_permalink(),
                    'dimensions' => wc_format_dimensions($product->get_dimensions(false)),
                    'description' => $product->get_short_description() ? $product->get_short_description() : $divider,
                    'long' => $product->get_description() ? $product->get_description() : $divider,
                    'weight' => $product->get_weight() ? $product->get_weight() : $divider,
                    'sku' => $product->get_sku() ? $product->get_sku() : $divider,
                    'availability' => woodmart_compare_availability_html($product),
                );

                foreach ($fields as $field_id => $field_name) {
                    if (taxonomy_exists($field_id)) {
                        $products_data[$product->get_id()][$field_id] = array();
                        $orderby = wc_attribute_orderby($field_id) ? wc_attribute_orderby($field_id) : 'name';
                        $terms = wp_get_post_terms($product->get_id(), $field_id, array(
                            'orderby' => $orderby
                        ));
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                $term = sanitize_term($term, $field_id);
                                $products_data[$product->get_id()][$field_id][] = $term->name;
                            }
                        } else {
                            $products_data[$product->get_id()][$field_id][] = apply_filters('woodmart_compare_empty_field_symbol', '-');
                        }
                        $products_data[$product->get_id()][$field_id] = implode(', ', $products_data[$product->get_id()][$field_id]);
                    }
                }
            }

            return $products_data;
        }
    }
    if (!function_exists('woodmart_compare_add_to_cart_html')) {
        function woodmart_compare_add_to_cart_html($product)
        {
            if (!$product) return;

            $defaults = array(
                'quantity' => 1,
                'class' => implode(' ', array_filter(array(
                    'button',
                    'product_type_' . $product->get_type(),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                ))),
                'attributes' => array(
                    'data-product_id' => $product->get_id(),
                    'data-product_sku' => $product->get_sku(),
                    'data-product_long' => $product->get_description(),
                    'aria-label' => $product->add_to_cart_description(),
                    'rel' => 'nofollow',
                ),
            );

            $args = apply_filters('woocommerce_loop_add_to_cart_args', $defaults, $product);

            if (isset($args['attributes']['aria-label'])) {
                $args['attributes']['aria-label'] = strip_tags($args['attributes']['aria-label']);
            }

            return apply_filters('woocommerce_loop_add_to_cart_link',
                sprintf('<a href="%s" data-quantity="%s" class="%s add-to-cart-loop" %s><span>%s</span></a>',
                    esc_url($product->add_to_cart_url()),
                    esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                    esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                    isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                    esc_html($product->add_to_cart_text())
                ),
                $product, $args);
        }
    }
    if (!function_exists('woodmart_compare_available_fields')) {
        function woodmart_compare_available_fields($new = false)
        {
            $product_attributes = array();

            if (function_exists('wc_get_attribute_taxonomies')) {
                $product_attributes = wc_get_attribute_taxonomies();
            }

            if ($new) {
                $options = array(
                    'description' => array(
                        'name' => esc_html__('Description', 'woodmart'),
                        'value' => 'description',
                    ),
                    'long' => array(
                        'name' => esc_html__('Long content', 'woodmart'),
                        'value' => 'long',
                    ),
                    'dimensions' => array(
                        'name' => esc_html__('Dimensions', 'woodmart'),
                        'value' => 'dimensions',
                    ),
                    'weight' => array(
                        'name' => esc_html__('Weight', 'woodmart'),
                        'value' => 'weight',
                    ),
                    'availability' => array(
                        'name' => esc_html__('Availability', 'woodmart'),
                        'value' => 'availability',
                    ),
                    'sku' => array(
                        'name' => esc_html__('Sku', 'woodmart'),
                        'value' => 'sku',
                    ),

                );

                if (count($product_attributes) > 0) {
                    foreach ($product_attributes as $attribute) {
                        $options['pa_' . $attribute->attribute_name] = array(
                            'name' => wc_attribute_label($attribute->attribute_label),
                            'value' => 'pa_' . $attribute->attribute_name,
                        );
                    }
                }
                return $options;
            }

            $fields = array(
                'enabled' => array(
                    'description' => esc_html__('Description', 'woodmart'),
                    'long' => esc_html__('Long content', 'woodmart'),
                    'sku' => esc_html__('Sku', 'woodmart'),
                    'availability' => esc_html__('Availability', 'woodmart'),
                ),
                'disabled' => array(
                    'weight' => esc_html__('Weight', 'woodmart'),
                    'dimensions' => esc_html__('Dimensions', 'woodmart'),
                )
            );

            if (count($product_attributes) > 0) {
                foreach ($product_attributes as $attribute) {
                    $fields['disabled']['pa_' . $attribute->attribute_name] = $attribute->attribute_label;
                }
            }

            return $fields;
        }
    }
}

// add payment to user profile if yes
if ($uso_add_payment_touser == "yes") {


    add_action('show_user_profile', 'extra_user_profile_fields');
    add_action('edit_user_profile', 'extra_user_profile_fields');
    function extra_user_profile_fields($user)
    {

        ?>
        <h3><?php _e("choose payment method", "blank"); ?></h3>
        <?php
        $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();

        WC()->payment_gateways()->set_current_gateway($available_gateways);

        ?>
        <?php

        foreach ($available_gateways as $gateway) {
            //print_r ($gateway);
            $value = get_the_author_meta('address', $user->ID);

            $data = get_user_meta($user->ID, 'address', true);

            $newdata = (unserialize($data));

            ?>
            <input type="checkbox" id="<?php echo $gateway->id; ?>" size="80" name="address[]"
                   value="<?php echo $gateway->id; ?>" <?php if (!empty($newdata)) {
                if (in_array($gateway->id, $newdata) !== false) {
                    echo "checked";
                }
            } ?> > <?php echo $gateway->get_title() ?></br>

            <?php
        }
        //print_r($getwaysID);
        //return $getwaysID;
    }

    add_action('personal_options_update', 'save_extra_user_profile_fields');
    add_action('edit_user_profile_update', 'save_extra_user_profile_fields');
    function save_extra_user_profile_fields($user_id)
    {
        if (isset($_POST['address'])) {


            $data = serialize($_POST['address']);

            update_user_meta($user_id, 'address', $data);
        }

    }


//disable in checkout
    function ts_disable_cod($available_payment_gateways)
    {
        $user = wp_get_current_user();
        $data = get_user_meta($user->ID, 'address', true);
        $newdata = (unserialize($data));

        foreach ($available_payment_gateways as $gateway) {
            if (is_checkout() && !empty($newdata)) {

                if (in_array($gateway->id, $newdata) == false) {
                    unset($available_payment_gateways[$gateway->id]);
                }
            }
        }
        return $available_payment_gateways;
    }

    add_filter('woocommerce_available_payment_gateways', 'ts_disable_cod', 90, 1);


}

// add total price in grouped product page
if ($uso_add_total == 'yes') {

    add_action('woocommerce_after_add_to_cart_button', 'bbloomer_product_price_recalculate');

    function bbloomer_product_price_recalculate()
    {
        global $product;
        if ($product->get_type() == 'grouped') {
            $price = $product->get_display_price();


            echo '<div id="subtot" style="display:inline-block;">Total: <span></span></div>';
            echo '<input class="total" type="hidden" value="0" >';

            $currency = get_woocommerce_currency_symbol();

            wc_enqueue_js(" 
        
         
		$('.qty').on('change', function() {

      $('.total').val(0);

      $('.qty').each(function(total) {
    
   var total = $('.total').val();
   
            var Main_div = $(this).parent().parent().parent().attr('id');
				 var price = $('#'+Main_div+' .price-column .price .amount bdi').text();
				 price = price.replace('ر.س', '');
				 var value = parseFloat(price.replace(',', '.'));
				 
            var total = parseFloat(total)+ ($(this).val() *value );
			
			 var new_tot =  total.toFixed(2);
			
               $('.total').val(new_tot);
			   $('#subtot > span' ).html('" . esc_js($currency) . "'+ new_tot );
			   
    });
    });
		
      
   ");

        }
    }
}

//Creation of Minimum & Maximum Quantity fields
if ( $uso_qty_limit == 'yes'){
    function wc_qty_add_product_field() {

        echo '<div class="options_group">';
        woocommerce_wp_text_input(
            array(
                'id'          => '_wc_min_qty_product',
                'label'       => __( 'الحد الادنى للكمية', 'woocommerce-max-quantity' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'الحد الأدنى لكمية شراء المنتج', 'woocommerce-max-quantity' )
            )
        );
        echo '</div>';

        echo '<div class="options_group">';
        woocommerce_wp_text_input(
            array(
                'id'          => '_wc_max_qty_product',
                'label'       => __( 'الحد الأقصى للكمية', 'woocommerce-max-quantity' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'الحد الأقصى لكمية شراء المنتج', 'woocommerce-max-quantity' )
            )
        );
        echo '</div>';
    }
    add_action( 'woocommerce_product_options_inventory_product_data', 'wc_qty_add_product_field' );
    /*
    * This function will save the value set to Minimum Quantity and Maximum Quantity options
    * into _wc_min_qty_product and _wc_max_qty_product meta keys respectively
    */

    function wc_qty_save_product_field( $post_id ) {
        $val_min = trim( get_post_meta( $post_id, '_wc_min_qty_product', true ) );
        $new_min = sanitize_text_field( $_POST['_wc_min_qty_product'] );

        $val_max = trim( get_post_meta( $post_id, '_wc_max_qty_product', true ) );
        $new_max = sanitize_text_field( $_POST['_wc_max_qty_product'] );

        if ( $val_min != $new_min ) {
            update_post_meta( $post_id, '_wc_min_qty_product', $new_min );
        }

        if ( $val_max != $new_max ) {
            update_post_meta( $post_id, '_wc_max_qty_product', $new_max );
        }
    }
    add_action( 'woocommerce_process_product_meta', 'wc_qty_save_product_field' );
    /*
    * Setting minimum and maximum for quantity input args.
    */

    function wc_qty_input_args( $args, $product ) {

        $product_id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();

        $product_min = wc_get_product_min_limit( $product_id );
        $product_max = wc_get_product_max_limit( $product_id );

        if ( ! empty( $product_min ) ) {
            // min is empty
            if ( false !== $product_min ) {
                $args['min_value'] = $product_min;
            }
        }

        if ( ! empty( $product_max ) ) {
            // max is empty
            if ( false !== $product_max ) {
                $args['max_value'] = $product_max;
            }
        }

        if ( $product->managing_stock() && ! $product->backorders_allowed() ) {
            $stock = $product->get_stock_quantity();

            $args['max_value'] = min( $stock, $args['max_value'] );
        }

        return $args;
    }
    add_filter( 'woocommerce_quantity_input_args', 'wc_qty_input_args', 10, 2 );

    function wc_get_product_max_limit( $product_id ) {
        $qty = get_post_meta( $product_id, '_wc_max_qty_product', true );
        if ( empty( $qty ) ) {
            $limit = false;
        } else {
            $limit = (int) $qty;
        }
        return $limit;
    }

    function wc_get_product_min_limit( $product_id ) {
        $qty = get_post_meta( $product_id, '_wc_min_qty_product', true );
        if ( empty( $qty ) ) {
            $limit = false;
        } else {
            $limit = (int) $qty;
        }
        return $limit;
    }
    /*
    * Validating the quantity on add to cart action with the quantity of the same product available in the cart.
    */
    function wc_qty_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = '', $variations = '' ) {

        $product_min = wc_get_product_min_limit( $product_id );
        $product_max = wc_get_product_max_limit( $product_id );

        if ( ! empty( $product_min ) ) {
            // min is empty
            if ( false !== $product_min ) {
                $new_min = $product_min;
            } else {
                // neither max is set, so get out
                return $passed;
            }
        }

        if ( ! empty( $product_max ) ) {
            // min is empty
            if ( false !== $product_max ) {
                $new_max = $product_max;
            } else {
                // neither max is set, so get out
                return $passed;
            }
        }

        $already_in_cart 	= wc_qty_get_cart_qty( $product_id );
        $product 			= wc_get_product( $product_id );
        $product_title 		= $product->get_title();

        if ( !is_null( $new_max ) && !empty( $already_in_cart ) ) {

            if ( ( $already_in_cart + $quantity ) > $new_max ) {
                // oops. too much.
                $passed = false;

                wc_add_notice( apply_filters( 'isa_wc_max_qty_error_message_already_had', sprintf( __( 'You can add a maximum of %1$s %2$s\'s to %3$s. You already have %4$s.', 'woocommerce-max-quantity' ),
                    $new_max,
                    $product_title,
                    '<a href="' . esc_url( wc_get_cart_url() ) . '">' . __( 'your cart', 'woocommerce-max-quantity' ) . '</a>',
                    $already_in_cart ),
                    $new_max,
                    $already_in_cart ),
                    'error' );

            }
        }

        return $passed;
    }
    add_filter( 'woocommerce_add_to_cart_validation', 'wc_qty_add_to_cart_validation', 1, 5 );
    /*
    * Get the total quantity of the product available in the cart.
    */
    function wc_qty_get_cart_qty( $product_id , $cart_item_key = '' ) {
        global $woocommerce;
        $running_qty = 0; // iniializing quantity to 0

        // search the cart for the product in and calculate quantity.
        foreach($woocommerce->cart->get_cart() as $other_cart_item_keys => $values ) {
            if ( $product_id == $values['product_id'] ) {

                if ( $cart_item_key == $other_cart_item_keys ) {
                    continue;
                }

                $running_qty += (int) $values['quantity'];
            }
        }

        return $running_qty;
    }

    /*
    * Validate product quantity when cart is UPDATED
    */

    function wc_qty_update_cart_validation( $passed, $cart_item_key, $values, $quantity ) {
        $product_min = wc_get_product_min_limit( $values['product_id'] );
        $product_max = wc_get_product_max_limit( $values['product_id'] );

        if ( ! empty( $product_min ) ) {
            // min is empty
            if ( false !== $product_min ) {
                $new_min = $product_min;
            } else {
                // neither max is set, so get out
                return $passed;
            }
        }

        if ( ! empty( $product_max ) ) {
            // min is empty
            if ( false !== $product_max ) {
                $new_max = $product_max;
            } else {
                // neither max is set, so get out
                return $passed;
            }
        }

        $product = wc_get_product( $values['product_id'] );
        $already_in_cart = wc_qty_get_cart_qty( $values['product_id'], $cart_item_key );

        if ( isset( $new_max) && ( $already_in_cart + $quantity ) > $new_max ) {
            wc_add_notice( apply_filters( 'wc_qty_error_message', sprintf( __( 'تسطيع فقط شراء  of %1$s %2$s\'s to %3$s.', 'woocommerce-max-quantity' ),
                $new_max,
                $product->get_name(),
                '<a href="' . esc_url( wc_get_cart_url() ) . '">' . __( 'your cart', 'woocommerce-max-quantity' ) . '</a>'),
                $new_max ),
                'error' );
            $passed = false;
        }

        if ( isset( $new_min) && ( $already_in_cart + $quantity )  < $new_min ) {
            wc_add_notice( apply_filters( 'wc_qty_error_message', sprintf( __( 'You should have minimum of %1$s %2$s\'s to %3$s.', 'woocommerce-max-quantity' ),
                $new_min,
                $product->get_name(),
                '<a href="' . esc_url( wc_get_cart_url() ) . '">' . __( 'your cart', 'woocommerce-max-quantity' ) . '</a>'),
                $new_min ),
                'error' );
            $passed = false;
        }

        return $passed;
    }
    add_filter( 'woocommerce_update_cart_validation', 'wc_qty_update_cart_validation', 1, 4 );


}


/* Add VAT Number To Thank You Page */
add_action('woocommerce_thankyou', 'sam_display_vat_number_thankyou');
function sam_display_vat_number_thankyou()
{
    global $uso_tax_number;
    ?>
    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
        <tr class="vat-number" id="vat-number">
            <th><?php echo prof_get_switch_language('الرقم الضريبي', 'VAT Number'); ?></th>
            <td><?php echo $uso_tax_number; ?></td>
        </tr>
    </table>
    <?php
}

/* Send QR In Email */
add_filter('woocommerce_email_order_meta_fields', 'send_QR_invoice_to_mail', 10, 3);
function send_QR_invoice_to_mail($fields, $sent_to_admin, $order)
{
    global $uso_tax_number;
    // Convert Woocommerce Date To Specific Format
    $date = $order->get_date_created();
    $sec = strtotime($date);
    $new_date = date("Y-d-m H:i:s", $sec);

    $seller_name = get_bloginfo('name');
    $invoice_total = $order->get_total();
    $vat_value = $order->get_total_tax();

    $seller_length = strlen($seller_name);
    $seller_length_hexa = $seller_length < 16 ? '0' . dechex($seller_length) : dechex($seller_length);
    $seller_comp = '01' . $seller_length_hexa . bin2hex($seller_name);

    $vat_num_length = strlen($uso_tax_number);
    $vat_num_length_hexa = $vat_num_length < 16 ? '0' . dechex($vat_num_length) : dechex($vat_num_length);
    $vat_num_comp = '02' . $vat_num_length_hexa . bin2hex($uso_tax_number);

    $new_date_length = strlen($new_date);
    $new_date_length_length_hexa = $new_date_length < 16 ? '0' . dechex($new_date_length) : dechex($new_date_length);
    $new_date_comp = '03' . $new_date_length_length_hexa . bin2hex($new_date);

    $invoice_length = strlen($invoice_total);
    $invoice_length_hexa = $invoice_length < 16 ? '0' . dechex($invoice_length) : dechex($invoice_length);
    $test_invoice_comp = '04' . $invoice_length_hexa . bin2hex($invoice_total);

    $vat_value_length = strlen($vat_value);
    $vat_value_length_hexa = $vat_value_length < 16 ? '0' . dechex($vat_value_length) : dechex($vat_value_length);
    $vat_value_comp = '05' . $vat_value_length_hexa . bin2hex($vat_value);

    $total_hex = $seller_comp . $vat_num_comp . $new_date_comp . $test_invoice_comp . $vat_value_comp;
    $QR_code = base64_encode(hex2bin($total_hex));

    ?>
    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $QR_code; ?>&choe=UTF-8"
         title="Link to Google.com"/>
    <?php
}

/* Custom HTML Blocks Start */
/* Custom Shop Footer HTML Block */
if (!empty($uso_shop_footer_html_blocks)) {
    function woocommerce_custom_html_block_shop()
    {
        global $uso_shop_footer_html_blocks;
        if (is_shop() && 0 === absint(get_query_var('paged'))) {
            echo '<div class="term-description">' . wc_format_content(wp_kses_post(do_shortcode('[html_block id="'.$uso_shop_footer_html_blocks.'"]'))) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    add_action('woocommerce_after_main_content', 'woocommerce_custom_html_block_shop');
}

/* Custom Cart Footer HTML Block */
if (!empty($uso_cart_footer_html_blocks)) {
    function woocommerce_custom_html_block_cart()
    {
        global $uso_cart_footer_html_blocks;
        if (is_cart() && 0 === absint(get_query_var('paged'))) {
            echo '<div class="term-description">' . wc_format_content(wp_kses_post(do_shortcode('[html_block id="'.$uso_cart_footer_html_blocks.'"]'))) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        }
    }
    add_action('woocommerce_after_cart', 'woocommerce_custom_html_block_cart');
}

/* Custom Product Footer HTML Block */
if (!empty($uso_product_footer_html_blocks)) {
    function woocommerce_custom_html_block_product()
    {
        global $uso_product_footer_html_blocks;
        if (is_product() && 0 === absint(get_query_var('paged'))) {
            echo '<div class="term-description">' . wc_format_content(wp_kses_post(do_shortcode('[html_block id="'.$uso_product_footer_html_blocks.'"]'))) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        }
    }
    add_action('woocommerce_after_single_product', 'woocommerce_custom_html_block_product');
}
/* Custom HTML Blocks End */

// Update Checkout Page On Change Payment Methods
function payment_methods_refresh_checkout() {
    wc_enqueue_js( "jQuery( function($){
        $('form.checkout').on('change', 'input[name=payment_method]', function(){
            $(document.body).trigger('update_checkout');
        });
    });");
}
add_action( 'woocommerce_checkout_init', 'payment_methods_refresh_checkout' );

/* for postcode issue[invalid postcode] */
if (!function_exists('uso_override_checkout_postcode')) {
    //add_filter('woocommerce_checkout_fields', 'uso_override_checkout_postcode', 1200);
    function uso_override_checkout_postcode($fields)
    {
        global $uso_shipping_condition;
        if ($uso_shipping_condition == 'yes') {
            unset($fields['billing']['billing_postcode']['validate']);
            unset($fields['shipping']['shipping_postcode']['validate']);
            return $fields;
        } else {
            return $fields;
        }
    }
}

// show theme options with shop-manager user role
if (!function_exists('uso_shop_manager_theme_options_cap')) {
    function uso_shop_manager_theme_options_cap() {
        if ( current_user_can( 'shop_manager' ) ) {
            global $submenu;
            $shop_manager = get_role( 'shop_manager');
            $shop_manager->add_cap( 'manage_options');
            $shop_manager->remove_cap( 'edit_themes' );
            $shop_manager->add_cap('update_plugins');
            $shop_manager->add_cap('update_themes');
            $shop_manager->add_cap('edit_users');
            $shop_manager->add_cap('edit_user');
            $shop_manager->add_cap('create_users');
            $shop_manager->add_cap('promote_users');
            $shop_manager->add_cap('wpml_manage_taxonomy_translation');

            unset($submenu['options-general.php'][10]); // Removes 'General'
            unset($submenu['options-general.php'][15]); // Removes 'Writing'
            unset($submenu['options-general.php'][20]); // Removes 'Reading'
            unset($submenu['options-general.php'][25]); // Removes 'Discussion'
            unset($submenu['options-general.php'][30]); // Removes 'Media'
            unset($submenu['options-general.php'][40]); // Removes 'Permalinks'
            unset($submenu['options-general.php'][45]); // Removes 'Privacy'
        }
    }
    add_action( 'admin_init', 'uso_shop_manager_theme_options_cap', 1100);
}

// show woodmart dashboard menu item with shopmanager
if (!function_exists('uso_woodmart_dashboard_theme_links_access')) {
	function uso_woodmart_dashboard_theme_links_access() {
		if ( current_user_can( 'shop_manager' ) ) {
			add_filter(
				'woodmart_dashboard_theme_links_access',
				function() {
					return 'shop_manager';
				}
			);
		}
	}
	 add_action( 'plugins_loaded', 'uso_woodmart_dashboard_theme_links_access', 1100);
}

/* Conditional Show hide bacs number field based on bacs payment methods */
add_action( 'wp_footer', 'uso_show_hide_billing_bacs_field' );
function uso_show_hide_billing_bacs_field(){
    // Only on checkout page
    if ( is_checkout() && ! is_wc_endpoint_url() ) :
        ?>
        <script>
            jQuery(function($){
                var a = 'input[name="payment_method"]',
                    b = a + ':checked',
                    c = '#uso_payment_bacs_no_field'; // The checkout field <p> container selector

                // Function that shows or hide checkout fields
                function showHide( selector = '', action = 'show' ){
                    if( action == 'show' ){
                        $(selector).show( 200, function(){
                            $(this).addClass("validate-required");
                            $("#uso_payment_bacs_no").attr('required',true);
                            $("#uso_payment_bacs_no").attr('value',"");
                        });
                    }
                    else{

                        $(selector).hide( 200, function(){

                            $(this).removeClass("validate-required");
                            $("#uso_payment_bacs_no").attr('value',"0");

                        });

                        $(selector).removeClass("woocommerce-validated");
                        $(selector).removeClass("woocommerce-invalid woocommerce-invalid-required-field");
                        $("#uso_payment_bacs_no").attr('value',"0");
                    }
                }

                // Initialising: Hide if choosen payment method is "cod"
                if( $(b).val() !== 'bacs' )
                    showHide( c, 'hide' );
                else
                    showHide( c );

                // Live event (When payment method is changed): Show or Hide based on "cod"
                $( 'form.checkout' ).on( 'change', a, function() {
                    if( $(b).val() !== 'bacs' )
                        showHide( c, 'hide' );
                    else
                        showHide( c );
                });
            });
        </script>
    <?php
    endif;
}

// change woocommerce currency symbol according to the language
if ( ! function_exists('uso_add_custom_currency_symbol')){
    add_filter('woocommerce_currency_symbol', 'uso_add_custom_currency_symbol', 1100, 2);
        function uso_add_custom_currency_symbol( $currency_symbol, $currency ) {
            if(get_locale() != "ar"){
                 switch( $currency ) {
                      case 'IQD': $currency_symbol = 'IQD'; break; // Iraq
                      case 'OMR': $currency_symbol = 'OMR'; break; // Oman
                      case 'SAR': $currency_symbol = 'SAR'; break; // saudi arabia
                      case 'QAR': $currency_symbol = 'QAR'; break; // qatar
                 }
            }
            
             return $currency_symbol;
        }
    }


/******************************** Change Woodmart To Ultmart Theme Settings Start *********************************/
function uso_change_ultmart_theme_settings() {
    $main_dir = plugin_dir_url(__FILE__);

    $image_url = $main_dir.'assets/admin/images/logo.png';

    $upload_dir = wp_upload_dir();

    $image_data = file_get_contents( $image_url );

    $filename = basename( $image_url );

    if ( wp_mkdir_p( $upload_dir['path'] ) ) {
        $file = $upload_dir['path'] . '/' . $filename;
    }
    else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

    file_put_contents( $file, $image_data );

    $wp_filetype = wp_check_filetype( $filename, null );

    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name( $filename ),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment( $attachment, $file );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    $image_info = wp_get_attachment_metadata($attach_id);
    $image_name = $image_info['file'];

    $logo_url = WP_CONTENT_DIR.'/uploads/'.$image_name;
    /* Get Woodmart Theme Settings Option */
    $options = get_option('xts-woodmart-options');
    /* Used Options */
    $options['white_label'] = 1; // White Label Option
    $options['white_label_theme_name'] = 'Ultmart'; // White Label Theme Name Option
    $options['white_label_options_logo'] = array(   // White Label Options Logo Option
        'url' => $logo_url,
        'id' => $attach_id
    );
    $options['white_label_sidebar_icon_logo'] = array(  // White Label Sidebar Icon Option
        'url' => $logo_url,
        'id' => $attach_id
    );
    $options['white_label_dashboard_logo'] = array(
        'url' => $logo_url,
        'id' => $attach_id
    );
    $options['white_label_dashboard_title'] = 'Ultmart';  // White Label Dashboard Title Option
    $options['white_label_appearance_screenshot'] = array(  // White Label Appearance ScreenShot Option
        'url' => $logo_url,
        'id' => $attach_id
    );
    update_option('xts-woodmart-options',$options);
    //$options = get_option('xts-woodmart-options');
    //prof_print_r($options);
}
/******************************** Change Woodmart To Ultmart Theme Settings End *********************************/
/******************************** Set Minimum Order Amount Start **************************************/
if ( ! function_exists( 'uso_set_minimum_order_amount' ) ) {
    add_action( 'woocommerce_checkout_process', 'uso_set_minimum_order_amount' );
    add_action( 'woocommerce_before_cart', 'uso_set_minimum_order_amount' );

    function uso_set_minimum_order_amount() {
        global $uso_minimum_order_amount;
        // Change the number below to modify the minimum amount.

        if(!empty($uso_minimum_order_amount)){
            if ( WC()->cart->total < $uso_minimum_order_amount ) {

                if ( is_cart() ) {

                    wc_print_notice(
                        sprintf(
                        /* translators: %1$s: current order total %2$s: minimum order total */
                            __( 'Your current order total is %1$s — you must have an order with a minimum of %2$s to place your order ', 'uso' ),
                            wc_price( WC()->cart->total ),
                            wc_price( $uso_minimum_order_amount )
                        ),
                        'error'
                    );

                } else {

                    wc_add_notice(
                        sprintf(
                        /* translators: %1$s: current order total %2$s: minimum order total */
                            __( 'Your current order total is %1$s — you must have an order with a minimum of %2$s to place your order ', 'uso' ),
                            wc_price( WC()->cart->total ),
                            wc_price( $uso_minimum_order_amount )
                        ),
                        'error'
                    );

                }
            }
        }
    }
}
/******************************** Set Minimum Order Amount End **************************************/
/******************************* Add Custom COD Fee Start ***********************************************/
add_action( 'woocommerce_cart_calculate_fees' , 'uso_add_custom_cod_fees' );
function uso_add_custom_cod_fees() {
    global  $uso_payment_cod_tax, $uso_price_after_text_ar, $uso_price_after_text_en;
    $payment_method         = WC()->session->get( 'chosen_payment_method' );
    $uso_settings = get_option('uso_settings');
    $uso_payment_cod_amount = $uso_settings['uso_payment_cod_tax'];
    $cod_vat_text = prof_get_switch_language( 'تكلفة الدفع عند التوصيل' . ' (' . $uso_price_after_text_ar . ' )'  , 'The cost of payment on delivery' . ' ( ' . $uso_price_after_text_en . ' ) ' );
    $shipping_class = get_option( 'woocommerce_shipping_tax_class' );
    if(! empty($uso_payment_cod_tax) && $uso_payment_cod_tax != 0 && $payment_method == 'cod') {
        WC()->cart->add_fee(
            $cod_vat_text , ( wc_get_price_decimals() === 0 ) ? round( $uso_payment_cod_amount ) : $uso_payment_cod_amount , true , $shipping_class
        );
    }
}
/******************************* Add Custom COD Fee End ***********************************************/

/**************************** Link Images With URLs Start ********************************************/
function uso_link_images_with_urls_from_txt_file()
{
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    global $product;
    $content = explode("\n", file_get_contents(get_stylesheet_directory_uri().'/online-items-13.txt'));
    //prof_print_r($content);
    foreach($content as $k => $arr){
        if($k == 0){
            continue;
        }
        $res = explode(' ', preg_replace('/\s+/', ' ', $arr));
        //prof_print_r($res);
        //prof_print_r($res[0]);
        if(@$res[1] == null){
            continue;
        }
        $store[] = ['id' => @$res[0] , 'link' => @$res[1]];
    }

    foreach ($store as $element) {
        $file_sku = $element['id'];
        $link = $element['link'];
        ///
        $all_ids = get_posts( array(
            'post_type' => 'product',
            'numberposts' => -1,
            'fields' => 'ids',
        ) );
        foreach ( $all_ids as $id ) {
            $product = wc_get_product($id);
            $sku = $product->get_sku();
            $clean_sku = explode('|',$sku);
            //prof_print_r( $clean_sku[0] );
            $pr_sku = $clean_sku[0];

            if ($file_sku == $pr_sku) {
                $attachment_id = media_sideload_image($link, $id,'','id');
                set_post_thumbnail($id,$attachment_id);
            }
        }
    }
}
/**************************** Link Images With URLs End ********************************************/
/**************************** Default Order Status Start ******************************************/
// set default order status
if (!function_exists('uso_change_woo_payment_order_status')) {
    add_filter( 'woocommerce_cod_process_payment_order_status', 'uso_change_woo_payment_order_status', 1100, 2 );
    add_filter( 'woocommerce_bacs_process_payment_order_status','uso_change_woo_payment_order_status', 1100, 2 );
    add_filter( 'woocommerce_cheque_process_payment_order_status','uso_change_woo_payment_order_status', 1100, 2 );
	function uso_change_woo_payment_order_status( $order_status, $order ) {
        $uso_settings           = get_option( 'uso_settings' );
        if($uso_settings['uso_order_default_status'] != 'no'){
            return $uso_settings['uso_order_default_status'];
        }else{
            return $order_status;
        }
    }
}
if (!function_exists('uso_change_payment_gatways_order_status')) {
    add_filter( 'woocommerce_payment_complete_order_status', 'uso_change_payment_gatways_order_status', 1100, 3 );
    function uso_change_payment_gatways_order_status( $order_status, $order_id, $order ) {
        $uso_settings           = get_option( 'uso_settings' );
        if($uso_settings['uso_order_default_status'] != 'no'){
            return $uso_settings['uso_order_default_status'];
        }else{
            return $order_status;
        }
    }
}
/**************************** Default Order Status End ******************************************/
/********************************** Postcode Required or Optional Start ***********************/
// make postcode optional || required
if ( ! function_exists ('uso_customise_postcode_fields')){
    add_filter( 'woocommerce_default_address_fields', 'uso_customise_postcode_fields' );
    function uso_customise_postcode_fields( $address_fields ) {
        $uso_settings = get_option( 'uso_settings' );
        $option_value = $uso_settings['uso_checkout_postcode']['priority'];
        if($option_value == 'yes'){
            $address_fields['postcode']['required'] = true;
        }elseif($option_value == 'no'){
            $address_fields['postcode']['required'] = false;
        }
        return $address_fields;
    }
}
/********************************** Postcode Required or Optional End ***********************/
/*************************** Change Order Status To Processing If COD Start ****************/
add_action('woocommerce_thankyou_cod', 'action_woocommerce_thankyou_cod', 10, 1);
function action_woocommerce_thankyou_cod($order_id)
{
    $order = wc_get_order($order_id);
    $order->update_status('processing');
}
/************************** Change Order Status To Processing If COD End ****************/
/***************** Allow Shop Manager To Access WPML String Translations Start ****************/
add_action('admin_init','uso_shop_manager_active_wpml_custom_cap', 999);
function uso_shop_manager_active_wpml_custom_cap(){
    /* Check if WPML is active */
    if(in_array('sitepress-multilingual-cms/sitepress.php', apply_filters('active_plugins', get_option('active_plugins')))){
        // WPML is activated
        uso_shop_manager_wpml_custom_cap();
    }
}


function uso_shop_manager_wpml_custom_cap() {
    // gets the user role
    $role = get_role( 'shop_manager' );

    // Add the new capability
    //$role->add_cap( 'wpml_manage_languages' );
    //$role->add_cap( 'wpml_manage_media_translation' );
    //$role->add_cap( 'wpml_manage_navigation' );
    //$role->add_cap( 'wpml_manage_sticky_links' );
    $role->add_cap( 'wpml_manage_string_translation' );
    //$role->add_cap( 'wpml_manage_support' );
    //$role->add_cap( 'wpml_manage_taxonomy_translation' );
    //$role->add_cap( 'wpml_manage_theme_and_plugin_localization' );
    //$role->add_cap( 'wpml_manage_translation_analytics' );
    //$role->add_cap( 'wpml_manage_translation_management' );
    //$role->add_cap( 'wpml_manage_translation_options' );
    //$role->add_cap( 'wpml_manage_troubleshooting' );
    //$role->add_cap( 'wpml_manage_woocommerce_multilingual' );
    //$role->add_cap( 'wpml_manage_wp_menus_sync' );
    //$role->add_cap( 'wpml_operate_woocommerce_multilingual' );
}
add_action( 'admin_init', 'uso_shop_manager_wpml_custom_cap', 1000);
/***************** Allow Shop Manager To Access WPML String Translations End ****************/

/**************************** Delete Me Button Start **************************************/
add_action('woocommerce_account_dashboard', 'sam_delete_customer_account');
function sam_delete_customer_account()
{
    $user_id = get_current_user_id();
    ?>
    <input type="hidden" id="sam_delete_account_id" value="<?php echo $user_id; ?>">
    <input type="hidden" id="sam_delete_account_url" value="<?php echo get_home_url(); ?>">
    <!--    <button id="sam_delete_account">Delete Account</button>-->

    <!-- Delete Modal -->
    <button id="usol_delete_account" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <?php echo prof_get_switch_language('حذف الحساب','Delete Account'); ?>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo prof_get_switch_language('حذف الحساب','Delete Account'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <h3>
                        <?php echo prof_get_switch_language('هل أنت متأكد من أنك تريد حذف الحساب ؟','Are You Sure To Delete Your Account ?'); ?>
                    </h3>
                </div>
                <div class="modal-footer">
                    <button id="sam_cancel_delete" type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo prof_get_switch_language('لا','No'); ?></button>
                    <button id="sam_delete_account" type="button" class="btn btn-primary"><?php echo prof_get_switch_language('نعم','Yes'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php
}

add_action('wp_ajax_nopriv_usol_delete_user','sam_pass_delete_account_to_user');
add_action('wp_ajax_usol_delete_user','sam_pass_delete_account_to_user');
function sam_pass_delete_account_to_user(){
    require_once(ABSPATH.'wp-admin/includes/user.php');
    $ajax_data = $_POST['ajax_data'];
    //$user_id = $ajax_data['user_id'];
    //wp_send_json_success(['response' => $ajax_data]);
    if(! empty($ajax_data)) {
        $user = wp_get_current_user();
        if ( in_array( 'customer', (array) $user->roles ) ) {
            wp_delete_user($ajax_data);
        }
    }

}
/*************************** Delete Me Button End **************************************/
/************************* set country state on checkout page according to onyx warehouse ******************/
if(in_array('onyx-integration/onyx-integration.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_filter( 'woocommerce_states' , 'uso_show_onyx_warehouse_state', 2000);
    add_action('init', 'uso_show_onyx_warehouse_city', 2000);
}
if ( ! function_exists('uso_get_onyx_warehouse_data')) {
    function uso_get_onyx_warehouse_data()
    {
        session_start();

        $onyx_settings                   = get_option('onyx_settings');
        $onyx_mapping_regions_list       = $onyx_settings['mapping_regions_list'];
        $onyx_mapping_region_link_method = $onyx_settings['onyx_mapping_region_link_method'];
        $selected_region_code            = $_SESSION['onyx_region'];
        $allowed_state = "";
        $allowed_city  = "";
        if (!empty($onyx_mapping_regions_list)) {
            foreach ($onyx_mapping_regions_list as $item) {
                if ($selected_region_code == $item['value']) {
                    $allowed_state = $item['key'];
                    // if mapping by city

                    if($onyx_mapping_region_link_method == 3){
                        $allowed_city = $item['city'];
                    }
                    break;
                }
            }
        }// end if(!empty($onyx_mapping_regions_list))
        $uso_onyx_mapping_data = array(
            "onyx_mapping_region_link_method" => $onyx_mapping_region_link_method,
            "allowed_state"                   => $allowed_state,
            "allowed_city"                    => $allowed_city
        );
        return $uso_onyx_mapping_data;
    }// end func
}
if ( ! function_exists('uso_show_onyx_warehouse_state')) {
    function uso_show_onyx_warehouse_state($states) {
        session_start();

        global $allowed_state, $onyx_multiple_warehouses ;

        if($onyx_multiple_warehouses == 'multiple'){
            $uso_onyx_mapping_data = uso_get_onyx_warehouse_data();
            $allowed_state = $uso_onyx_mapping_data['allowed_state'];
            if(!empty($allowed_state)){
                foreach( $states['YE'] as $state_key => $state ){
                    if($allowed_state != $state_key){
                        if ( ! is_admin() ) {
                            unset($states['YE'][$state_key]);
                        }
                    }
                }
            }// end if(!empty($allowed_state)

        }// end if($onyx_multiple_warehouses == 'multiple')
        return $states;
    }//end function uso_show_onyx_warehouse_state
}
if ( ! function_exists('uso_show_onyx_warehouse_city')) {
    function uso_show_onyx_warehouse_city(){
        global $places, $onyx_multiple_warehouses;

        if($onyx_multiple_warehouses == 'multiple'){
            $uso_onyx_mapping_data           = uso_get_onyx_warehouse_data();
            $onyx_mapping_region_link_method = $uso_onyx_mapping_data['onyx_mapping_region_link_method'];
            $allowed_state                   = $uso_onyx_mapping_data['allowed_state'];
            $allowed_city                    = $uso_onyx_mapping_data['allowed_city'];

            if($onyx_mapping_region_link_method == 3 && !empty($allowed_city)) {
                foreach ($places['YE'][$allowed_state] as $place_key => $place) {
                    if ($allowed_city != $place_key) {
                        if ( ! is_admin() ) {
                            unset($places['YE'][$allowed_state][$place_key]);
                        }
                    }
                }
            }
        }// end if($onyx_multiple_warehouses == 'multiple')
    }// end func
}
/*************************************** Hide Products That Doesn't Contain Thumbnail Start ******************************/
add_action( 'woocommerce_product_query', 'uso_hide_products_without_thumbnail' , 10, 1);
function uso_hide_products_without_thumbnail($query) {
    $uso_settings = get_option('uso_settings', true);
    $uso_product_wo_thumbnail = $uso_settings['uso_product_wo_thumbnail'];
    if($uso_product_wo_thumbnail === 'hide' && $uso_product_wo_thumbnail !== 'show') {
        $query->set( 'meta_query', array( array(
            'key' => '_thumbnail_id',
            'value' => '0',
            'compare' => '>'
         )));
    } 
}
/*************************************** Hide Products That Doesn't Contain Thumbnail End ******************************/
/*********************************** Delete Products That Doesn't Contain Thumbnail Start ******************************/
function uso_delete_products_without_thumbnail(){
	$query = new WC_Product_Query( 
        array(
        'limit' => -1,
        'return' => 'ids',
    ) 
);
$products = $query->get_products();
    foreach($products as $product_id) {
        $product = wc_get_product( $product_id );
        $image_id = $product->get_image_id();
        if(empty ($image_id)) {
            wp_delete_post($product_id);
        } 
    }
}
/*********************************** Delete Products That Doesn't Contain Thumbnail End ******************************/
/*********************************** Checkout Fields Data Options Start **********************************************/
add_filter( 'woocommerce_checkout_fields' , 'uso_override_billing_checkout_fields', 1300, 1 );
/* Checkout Fields Data (Show/hide - Label - Placeholder - Default Value)*/
function uso_override_billing_checkout_fields($fields) {
    global $uso_settings;

    /* Company Field Start */
    $uso_checkout_company_status          = $uso_settings['uso_checkout_company']['status']; // Show / Hide Company Field
    $uso_checkout_company_ar_label        = $uso_settings['uso_checkout_company']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_company_en_label        = $uso_settings['uso_checkout_company']['label']['en']; // English Company Field Label
    $uso_checkout_company_ar_placeholder  = $uso_settings['uso_checkout_company']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_company_en_placeholder  = $uso_settings['uso_checkout_company']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_company_ar_default      = $uso_settings['uso_checkout_company']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_company_en_default      = $uso_settings['uso_checkout_company']['value']['en']; // English Company Field Default Value

    if($uso_checkout_company_status == 'yes') {
        ?>
        <style>
            #billing_company_field {
                display: none !important; 
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_company_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_company']['label'] = $uso_checkout_company_ar_label;
        }
    }

    if(! empty($uso_checkout_company_en_label)) {
        $fields['billing']['billing_company']['label'] = $uso_checkout_company_en_label;
    }

    if(! empty($uso_checkout_company_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_company']['placeholder'] = $uso_checkout_company_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_company_en_placeholder)) {
        $fields['billing']['billing_company']['placeholder'] = $uso_checkout_company_en_placeholder;
    }

    if(!empty($uso_checkout_company_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_company']['default'] = $uso_checkout_company_ar_default;
        }
    }

    if(!empty($uso_checkout_company_en_default)){
            $fields['billing']['billing_company']['default'] = $uso_checkout_company_en_default;
    }
    
    /* Company Field End */

    /* First Name Start */
    $uso_checkout_first_name_status          = $uso_settings['uso_checkout_first_name']['status']; // Show / Hide Company Field
    $uso_checkout_first_name_ar_label        = $uso_settings['uso_checkout_first_name']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_first_name_en_label        = $uso_settings['uso_checkout_first_name']['label']['en']; // English Company Field Label
    $uso_checkout_first_name_ar_placeholder  = $uso_settings['uso_checkout_first_name']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_first_name_en_placeholder  = $uso_settings['uso_checkout_first_name']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_first_name_ar_default      = $uso_settings['uso_checkout_first_name']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_first_name_en_default      = $uso_settings['uso_checkout_first_name']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_first_name_status == 'yes') {
        ?>
        <style>
            #billing_first_name {
                display: none;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_first_name_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_first_name']['label'] = $uso_checkout_first_name_ar_label;
        }
    }

    
    if(! empty($uso_checkout_first_name_en_label)) {
        $fields['billing']['billing_first_name']['label'] = $uso_checkout_first_name_en_label;
    }

    if(! empty($uso_checkout_first_name_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_first_name']['placeholder'] = $uso_checkout_first_name_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_first_name_en_placeholder)) {
        $fields['billing']['billing_first_name']['placeholder'] = $uso_checkout_first_name_en_placeholder;
    }

    if(!empty($uso_checkout_first_name_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_first_name']['default'] = $uso_checkout_first_name_ar_default;
        }
    }

    if(!empty($uso_checkout_first_name_en_default)){
        $fields['billing']['billing_first_name']['default'] = $uso_checkout_first_name_en_default;
    }

    /* First Name Field End */

    /* Last Name Field Start */

    $uso_checkout_last_name_status          = $uso_settings['uso_checkout_last_name']['status']; // Show / Hide Company Field
    $uso_checkout_last_name_ar_label        = $uso_settings['uso_checkout_last_name']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_last_name_en_label        = $uso_settings['uso_checkout_last_name']['label']['en']; // English Company Field Label
    $uso_checkout_last_name_ar_placeholder  = $uso_settings['uso_checkout_last_name']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_last_name_en_placeholder  = $uso_settings['uso_checkout_last_name']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_last_name_ar_default      = $uso_settings['uso_checkout_last_name']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_last_name_en_default      = $uso_settings['uso_checkout_last_name']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_last_name_status == 'yes') {
        ?>
        <style>
            #billing_last_name {
                display: none;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_last_name_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_last_name']['label'] = $uso_checkout_last_name_ar_label;
        }
    }

    if(! empty($uso_checkout_last_name_en_label)) {
        $fields['billing']['billing_last_name']['label'] = $uso_checkout_last_name_en_label;
    }

    if(! empty($uso_checkout_last_name_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_last_name']['placeholder'] = $uso_checkout_last_name_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_last_name_en_placeholder)) {
        $fields['billing']['billing_last_name']['placeholder'] = $uso_checkout_last_name_en_placeholder;
    }

    if(!empty($uso_checkout_last_name_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_last_name']['default'] = $uso_checkout_last_name_ar_default;
        }
    }

    if(!empty($uso_checkout_last_name_en_default)){
        $fields['billing']['billing_last_name']['default'] = $uso_checkout_last_name_en_default;
    }

    /* Last Name Field End */

    /* Checkout Country Field Start */
    $uso_checkout_country_status          = $uso_settings['uso_checkout_country']['status']; // Show / Hide Company Field
    $uso_checkout_country_ar_label        = $uso_settings['uso_checkout_country']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_country_en_label        = $uso_settings['uso_checkout_country']['label']['en']; // English Company Field Label
    $uso_checkout_country_ar_placeholder  = $uso_settings['uso_checkout_country']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_country_en_placeholder  = $uso_settings['uso_checkout_country']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_country_ar_default      = $uso_settings['uso_checkout_country']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_country_en_default      = $uso_settings['uso_checkout_country']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_country_status == 'yes') {
        ?>
        <style>
            #billing_country_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_country_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_country']['label'] = $uso_checkout_country_ar_label;
        }
    }

    if(! empty($uso_checkout_country_en_label)) {
        $fields['billing']['billing_country']['label'] = $uso_checkout_country_en_label;
    }

    if(! empty($uso_checkout_country_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_country']['placeholder'] = $uso_checkout_country_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_country_en_placeholder)) {
        $fields['billing']['billing_country']['placeholder'] = $uso_checkout_country_en_placeholder;
    }

    if(!empty($uso_checkout_country_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_country']['default'] = $uso_checkout_country_ar_default;
        }
    }

    if(!empty($uso_checkout_country_en_default)){
        $fields['billing']['billing_country']['default'] = $uso_checkout_country_en_default;
    }
    /* Checkout Country Field End */

    /* Checkout State Field Start */
    $uso_checkout_state_status          = $uso_settings['uso_checkout_state']['status']; // Show / Hide Company Field
    $uso_checkout_state_ar_label        = $uso_settings['uso_checkout_state']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_state_en_label        = $uso_settings['uso_checkout_state']['label']['en']; // English Company Field Label
    $uso_checkout_state_ar_placeholder  = $uso_settings['uso_checkout_state']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_state_en_placeholder  = $uso_settings['uso_checkout_state']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_state_ar_default      = $uso_settings['uso_checkout_state']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_state_en_default      = $uso_settings['uso_checkout_state']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_state_status == 'yes') {
        ?>
        <style>
            #billing_state_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_state_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_state']['label'] = $uso_checkout_state_ar_label;
        }
    }

    if(! empty($uso_checkout_state_en_label)) {
        $fields['billing']['billing_state']['label'] = $uso_checkout_state_en_label;
    }

    if(! empty($uso_checkout_state_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_state']['placeholder'] = $uso_checkout_state_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_state_en_placeholder)) {
        $fields['billing']['billing_state']['placeholder'] = $uso_checkout_state_en_placeholder;
    }

    if(!empty($uso_checkout_state_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_state']['default'] = $uso_checkout_state_ar_default;
        }
    }

    if(!empty($uso_checkout_state_en_default)){
        $fields['billing']['billing_state']['default'] = $uso_checkout_state_en_default;
    }
    /* Checkout State Field End */

    /* Checkout City Field Start */
    $uso_checkout_city_status          = $uso_settings['uso_checkout_city']['status']; // Show / Hide Company Field
    $uso_checkout_city_ar_label        = $uso_settings['uso_checkout_city']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_city_en_label        = $uso_settings['uso_checkout_city']['label']['en']; // English Company Field Label
    $uso_checkout_city_ar_placeholder  = $uso_settings['uso_checkout_city']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_city_en_placeholder  = $uso_settings['uso_checkout_city']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_city_ar_default      = $uso_settings['uso_checkout_city']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_city_en_default      = $uso_settings['uso_checkout_city']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_city_status == 'yes') {
        ?>
        <style>
            #billing_city_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_city_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_city']['label'] = $uso_checkout_city_ar_label;
        }
    }

    if(! empty($uso_checkout_city_en_label)) {
        $fields['billing']['billing_city']['label'] = $uso_checkout_city_en_label;
    }

    if(! empty($uso_checkout_city_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_city']['placeholder'] = $uso_checkout_city_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_city_en_placeholder)) {
        $fields['billing']['billing_city']['placeholder'] = $uso_checkout_city_en_placeholder;
    }

    if(!empty($uso_checkout_city_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_city']['default'] = $uso_checkout_city_ar_default;
        }
    }

    if(!empty($uso_checkout_city_en_default)){
        $fields['billing']['billing_city']['default'] = $uso_checkout_city_en_default;
    }
    /* Checkout City Field End */

    /* Checkout Address 1 Field Start */
    $uso_checkout_address_1_status          = $uso_settings['uso_checkout_address_1']['status']; // Show / Hide Company Field
    $uso_checkout_address_1_ar_label        = $uso_settings['uso_checkout_address_1']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_address_1_en_label        = $uso_settings['uso_checkout_address_1']['label']['en']; // English Company Field Label
    $uso_checkout_address_1_ar_placeholder  = $uso_settings['uso_checkout_address_1']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_address_1_en_placeholder  = $uso_settings['uso_checkout_address_1']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_address_1_ar_default      = $uso_settings['uso_checkout_address_1']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_address_1_en_default      = $uso_settings['uso_checkout_address_1']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_address_1_status == 'yes') {
        ?>
        <style>
            #billing_address_1_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_address_1_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_address_1']['label'] = $uso_checkout_address_1_ar_label;
        }
    }

    if(! empty($uso_checkout_address_1_en_label)) {
        $fields['billing']['billing_address_1']['label'] = $uso_checkout_address_1_en_label;
    }

    if(! empty($uso_checkout_address_1_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_address_1']['placeholder'] = $uso_checkout_address_1_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_address_1_en_placeholder)) {
        $fields['billing']['billing_address_1']['placeholder'] = $uso_checkout_address_1_en_placeholder;
    }

    if(!empty($uso_checkout_address_1_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_address_1']['default'] = $uso_checkout_address_1_ar_default;
        }
    }

    if(!empty($uso_checkout_address_1_en_default)){
        $fields['billing']['billing_address_1']['default'] = $uso_checkout_address_1_en_default;
    }
    /* Checkout Address 1 Field End */

    /* Checkout Address 2 Field Start */
    $uso_checkout_address_2_status          = $uso_settings['uso_checkout_address_2']['status']; // Show / Hide Company Field
    $uso_checkout_address_2_ar_label        = $uso_settings['uso_checkout_address_2']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_address_2_en_label        = $uso_settings['uso_checkout_address_2']['label']['en']; // English Company Field Label
    $uso_checkout_address_2_ar_placeholder  = $uso_settings['uso_checkout_address_2']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_address_2_en_placeholder  = $uso_settings['uso_checkout_address_2']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_address_2_ar_default      = $uso_settings['uso_checkout_address_2']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_address_2_en_default      = $uso_settings['uso_checkout_address_2']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_address_2_status == 'yes') {
        ?>
        <style>
            #billing_address_2_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_address_2_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_address_2']['label'] = $uso_checkout_address_2_ar_label;
        }
    }

    if(! empty($uso_checkout_address_2_en_label)) {
        $fields['billing']['billing_address_2']['label'] = $uso_checkout_address_2_en_label;
    }

    if(! empty($uso_checkout_address_2_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_address_2']['placeholder'] = $uso_checkout_address_2_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_address_2_en_placeholder)) {
        $fields['billing']['billing_address_2']['placeholder'] = $uso_checkout_address_2_en_placeholder;
    }

    if(!empty($uso_checkout_address_2_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_address_2']['default'] = $uso_checkout_address_2_ar_default;
        }
    }

    if(!empty($uso_checkout_address_2_en_default)){
        $fields['billing']['billing_address_2']['default'] = $uso_checkout_address_2_en_default;
    }
     /* Checkout Address 2 Field End */

    /* Checkout Email Field Start */
    $uso_checkout_email_status          = $uso_settings['uso_checkout_email']['status']; // Show / Hide Company Field
    $uso_checkout_email_ar_label        = $uso_settings['uso_checkout_email']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_email_en_label        = $uso_settings['uso_checkout_email']['label']['en']; // English Company Field Label
    $uso_checkout_email_ar_placeholder  = $uso_settings['uso_checkout_email']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_email_en_placeholder  = $uso_settings['uso_checkout_email']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_email_ar_default      = $uso_settings['uso_checkout_email']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_email_en_default      = $uso_settings['uso_checkout_email']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_email_status == 'yes') {
        ?>
        <style>
            #billing_email_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_email_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_email']['label'] = $uso_checkout_email_ar_label;
        }
    }

    if(! empty($uso_checkout_email_en_label)) {
        $fields['billing']['billing_email']['label'] = $uso_checkout_email_en_label;
    }

    if(! empty($uso_checkout_email_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_email']['placeholder'] = $uso_checkout_email_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_email_en_placeholder)) {
        $fields['billing']['billing_email']['placeholder'] = $uso_checkout_email_en_placeholder;
    }

    if(!empty($uso_checkout_email_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_email']['default'] = $uso_checkout_email_ar_default;
        }
    }

    if(!empty($uso_checkout_email_en_default)){
        $fields['billing']['billing_email']['default'] = $uso_checkout_email_en_default;
    }
    /* Checkout Email Field End */

    /* Checkout Phone Field Start */
    $uso_checkout_phone_status          = $uso_settings['uso_checkout_phone']['status']; // Show / Hide Company Field
    $uso_checkout_phone_ar_label        = $uso_settings['uso_checkout_phone']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_phone_en_label        = $uso_settings['uso_checkout_phone']['label']['en']; // English Company Field Label
    $uso_checkout_phone_ar_placeholder  = $uso_settings['uso_checkout_phone']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_phone_en_placeholder  = $uso_settings['uso_checkout_phone']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_phone_ar_default      = $uso_settings['uso_checkout_phone']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_phone_en_default      = $uso_settings['uso_checkout_phone']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_phone_status == 'yes') {
        ?>
        <style>
            #billing_phone_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_phone_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_phone']['label'] = $uso_checkout_phone_ar_label;
        }
    }

    if(! empty($uso_checkout_phone_en_label)) {
        $fields['billing']['billing_phone']['label'] = $uso_checkout_phone_en_label;
    }

    if(! empty($uso_checkout_phone_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_phone']['placeholder'] = $uso_checkout_phone_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_phone_en_placeholder)) {
        $fields['billing']['billing_phone']['placeholder'] = $uso_checkout_phone_en_placeholder;
    }

    if(!empty($uso_checkout_phone_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_phone']['default'] = $uso_checkout_phone_ar_default;
        }
    }

    if(!empty($uso_checkout_phone_en_default)){
        $fields['billing']['billing_phone']['default'] = $uso_checkout_phone_en_default;
    }
    /* Checkout Phone Field End */

    /* Checkout Post Code Field Start */
    $uso_checkout_postcode_status          = $uso_settings['uso_checkout_postcode']['status']; // Show / Hide Company Field
    $uso_checkout_postcode_ar_label        = $uso_settings['uso_checkout_postcode']['label']['ar']; // Arabic Company Field Label
    $uso_checkout_postcode_en_label        = $uso_settings['uso_checkout_postcode']['label']['en']; // English Company Field Label
    $uso_checkout_postcode_ar_placeholder  = $uso_settings['uso_checkout_postcode']['placeholder']['ar']; // Arabic Company Field Placeholder
    $uso_checkout_postcode_en_placeholder  = $uso_settings['uso_checkout_postcode']['placeholder']['en']; // English Company Field Placeholder
    $uso_checkout_postcode_ar_default      = $uso_settings['uso_checkout_postcode']['value']['ar']; // Arabic Company Field Default Value
    $uso_checkout_postcode_en_default      = $uso_settings['uso_checkout_postcode']['value']['en']; // English Company Field Default Value

    if( $uso_checkout_postcode_status == 'yes') {
        ?>
        <style>
            #billing_postcode_field {
                display: none !important;
            }
        </style>
        <?php
    }

    if(! empty($uso_checkout_postcode_ar_label)) {
        if(is_rtl()){
            $fields['billing']['billing_postcode']['label'] = $uso_checkout_postcode_ar_label;
        }
    }

    if(! empty($uso_checkout_postcode_en_label)) {
        $fields['billing']['billing_postcode']['label'] = $uso_checkout_postcode_en_label;
    }

    if(! empty($uso_checkout_postcode_ar_placeholder)) {
        if(is_rtl()){
            $fields['billing']['billing_postcode']['placeholder'] = $uso_checkout_postcode_ar_placeholder;
        }
    }

    if(! empty($uso_checkout_postcode_en_placeholder)) {
        $fields['billing']['billing_postcode']['placeholder'] = $uso_checkout_postcode_en_placeholder;
    }

    if(!empty($uso_checkout_postcode_ar_default)){
        if(is_rtl()){
            $fields['billing']['billing_postcode']['default'] = $uso_checkout_postcode_ar_default;
        }
    }

    if(!empty($uso_checkout_postcode_en_default)){
        $fields['billing']['billing_postcode']['default'] = $uso_checkout_postcode_en_default;
    }

    /* Checkout Post Code Field End */

    return $fields;

}

/* Checkout Required / Optional Fields */
if ( ! function_exists('uso_required_optional_checkout_fields')) {
    add_filter('woocommerce_default_address_fields', 'uso_required_optional_checkout_fields', 2000, 1);
    function uso_required_optional_checkout_fields($address_fields)
    {
        global $uso_settings;

        /* Checkout Company Field */
        $uso_checkout_company_priority = $uso_settings['uso_checkout_company']['priority']; // Required / Optional Company Field

        if ($uso_checkout_company_priority == 'yes') {
            $address_fields['company']['required'] = true;
        }

        if ($uso_checkout_company_priority == 'no') {
            $address_fields['company']['required'] = false;
        }

        /* Checkout First Name Field*/
        $uso_checkout_first_name_priority = $uso_settings['uso_checkout_first_name']['priority']; // Required / Optional First Name Field

        if ($uso_checkout_first_name_priority == 'yes') {
            $address_fields['first_name']['required'] = true;
        }

        if ($uso_checkout_first_name_priority == 'no') {
            $address_fields['first_name']['required'] = false;
        }

        /* Checkout Last Name Field */
        $uso_checkout_last_name_priority = $uso_settings['uso_checkout_last_name']['priority']; // Required / Optional Last Name Field

        if ($uso_checkout_last_name_priority == 'yes') {
            $address_fields['last_name']['required'] = true;
        }

        if ($uso_checkout_last_name_priority == 'no') {
            $address_fields['last_name']['required'] = false;
        }

        /* Checkout Country Field */
        $uso_checkout_country_priority = $uso_settings['uso_checkout_country']['priority']; // Required / Optional Country Field

        if ($uso_checkout_country_priority == 'yes') {
            $address_fields['country']['required'] = true;
        }

        if ($uso_checkout_country_priority == 'no') {
            $address_fields['country']['required'] = false;
        }

        /* Checkout City Field */
        $uso_checkout_city_priority = $uso_settings['uso_checkout_city']['priority']; // Required / Optional City Field

        if ($uso_checkout_city_priority == 'yes') {
            $address_fields['city']['required'] = true;
        }

        if ($uso_checkout_city_priority == 'no') {
            $address_fields['city']['required'] = false;
        }

        /* Checkout State Field */
        $uso_checkout_state_priority = $uso_settings['uso_checkout_state']['priority']; // Required / Optional State Field

        if ($uso_checkout_state_priority == 'yes') {
            $address_fields['state']['required'] = true;
        }

        if ($uso_checkout_state_priority == 'no') {
            $address_fields['state']['required'] = false;
        }

        /* Checkout Address 1 Field */
        $uso_checkout_address_1_priority = $uso_settings['uso_checkout_address_1']['priority']; // Required / Optional Address 1 Field

        if ($uso_checkout_address_1_priority == 'yes') {
            $address_fields['address_1']['required'] = true;
        }

        if ($uso_checkout_address_1_priority == 'no') {
            $address_fields['address_1']['required'] = false;
        }

        /* Checkout Address 2 Field */
        $uso_checkout_address_2_priority = $uso_settings['uso_checkout_address_2']['priority']; // Required / Optional Address 2 Field

        if ($uso_checkout_address_2_priority == 'yes') {
            $address_fields['address_2']['required'] = true;
        }

        if ($uso_checkout_address_2_priority == 'no') {
            $address_fields['address_2']['required'] = false;
        }
        return $address_fields;
    }
}

/* Checkout billing Required / Optional Fields */
if ( ! function_exists('uso_required_optional_checkout_billing_fields')) {
    add_filter('woocommerce_billing_fields', 'uso_required_optional_checkout_billing_fields', 1200, 1);
    function uso_required_optional_checkout_billing_fields($fields)
    {
        global $uso_settings;

        /* Checkout Email Field */
        $uso_checkout_email_priority = $uso_settings['uso_checkout_email']['priority']; // Required / Optional Company Field

        if ($uso_checkout_email_priority == 'yes') {
            $fields['billing_email']['required'] = true;
        }

        if ($uso_checkout_email_priority == 'no') {
            $fields['billing_email']['required'] = false;
        }

        /* Checkout Phone Field */
        $uso_checkout_phone_priority = $uso_settings['uso_checkout_phone']['priority']; // Required / Optional Company Field

        if ($uso_checkout_phone_priority == 'yes') {
            $fields['billing_phone']['required'] = true;
        }

        if ($uso_checkout_phone_priority == 'no') {
            $fields['billing_phone']['required'] = false;
        }
        return $fields;
    }
}

// Checkout Required / Optional state field */
if ( ! function_exists('uso_custom_country_locale_state_optional')) {
    add_filter('woocommerce_get_country_locale', 'uso_custom_country_locale_state_postcode_optional', 2000, 1);
    function uso_custom_country_locale_state_postcode_optional($locale)
    {
        global $uso_settings;
        /* Checkout State Field */
        $uso_checkout_state_priority = $uso_settings['uso_checkout_state']['priority']; // Required / Optional Company Field

        /* Checkout PostCode Field */
        $uso_checkout_postcode_priority = $uso_settings['uso_checkout_postcode']['priority']; // Required / Optional Company Field

        foreach ($locale as $country_code => $state_field) {
            if ($uso_checkout_state_priority == 'yes') {
                $locale[$country_code]['state']['required'] = true;
            } else {
                $locale[$country_code]['state']['required'] = false;
            }

            if ($uso_checkout_postcode_priority == 'yes') {
                $locale[$country_code]['postcode']['required'] = true;
            } else {
                $locale[$country_code]['postcode']['required'] = false;
            }
        }
        return $locale;
    }
}
/*********************************** Checkout Fields Data Options End **********************************************/

/*********************************** Checkout Fields Data Options End **********************************************/
/******************************** Checkout Upload Field When Payment Is BACS Start **********************************/
if ($uso_bacs_status == 'yes' ) {
    add_action( 'woocommerce_after_checkout_billing_form', 'uso_checkout_file_upload' );
    add_action( 'wp_ajax_appformupload', 'uso_appformupload' );
    add_action( 'wp_ajax_nopriv_appformupload', 'uso_appformupload' );
    add_action( 'woocommerce_checkout_process', 'bbloomer_validate_new_checkout_field' );
    add_action( 'woocommerce_checkout_update_order_meta', 'bbloomer_save_new_checkout_field' );
    add_action( 'woocommerce_admin_order_data_after_billing_address', 'bbloomer_show_new_checkout_field_order', 10, 1 );
}

function uso_checkout_file_upload() {
    echo '<p class="form-row"><label for="appform">ملف أو صورة التحويل البنكي<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="file" id="appform" name="appform" accept=".pdf,.jpej,.jpg,.png" required><input type="hidden" name="appform_field" /></span></p>';
    wc_enqueue_js( "
       $( '#appform' ).change( function() {
          if ( this.files.length ) {
             const file = this.files[0];
             const formData = new FormData();
             formData.append( 'appform', file );
             $.ajax({
                url: wc_checkout_params.ajax_url + '?action=appformupload',
                type: 'POST',
                data: formData,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function ( response ) {
                   $( 'input[name=\"appform_field\"]' ).val( response );
                }
             });
          }
       });
    " );
 }
 
function uso_appformupload() {
   global $wpdb;
   $uploads_dir = wp_upload_dir();
   if ( isset( $_FILES['appform'] ) ) {
      if ( $upload = wp_upload_bits( $_FILES['appform']['name'], null, file_get_contents( $_FILES['appform']['tmp_name'] ) ) ) {
         echo $upload['url'];
      }
   }
   die;
}
 
function bbloomer_validate_new_checkout_field() {
   if ( empty( $_POST['appform_field'] ) && $_POST['payment_method'] === 'bacs' ) {
      wc_add_notice( 'برجاء رفع صورة التحويل البنكي', 'error' );
   }
}
  
function bbloomer_save_new_checkout_field( $order_id ) { 
   if ( ! empty( $_POST['appform_field'] ) ) {
      update_post_meta( $order_id, '_uso_bacs_upload', $_POST['appform_field'] );
   }
}
    
function bbloomer_show_new_checkout_field_order( $order ) {    
   $order_id = $order->get_id();
   if ( get_post_meta( $order_id, '_uso_bacs_upload', true ) ) echo '<p><strong>ملف التحويل البنكي:</strong> <a href="' . get_post_meta( $order_id, '_uso_bacs_upload', true ) . '" target="_blank">' . get_post_meta( $order_id, '_uso_bacs_upload', true ) . '</a></p>';
}

/* Show / Hide Upload Field On Bacs Payment Method Only */
if ($uso_bacs_status == 'yes' ) {
    add_action('wp_footer', 'uso_conditionally_show_hide_upload_custom_field');
}
function uso_conditionally_show_hide_upload_custom_field(){
    // Only on checkout page
    if ( is_checkout() && ! is_wc_endpoint_url() ) :
        ?>
        <script>
            jQuery(function($){
                var a = 'input[name="payment_method"]',
                    b = a + ':checked',
                    c = '#appform'; // The checkout field <p> container selector

                // Function that shows or hide checkout fields
                function showHide( selector = '', action = 'show' ){
                    if( action == 'show' )
                        $(selector).show( 200, function(){
                            $(this).addClass("validate-required");
                        });
                    else
                        $(selector).hide( 200, function(){
                            $(this).removeClass("validate-required");
                        });
                    $(selector).removeClass("woocommerce-validated");
                    $(selector).removeClass("woocommerce-invalid woocommerce-invalid-required-field");
                }

                // Initialising: Hide if choosen payment method is "cod"
                if( $(b).val() !== 'bacs' ) {
                    showHide( c, 'hide' );
                    //$('label[for="appform"]').hide();
                    showHide($('label[for="appform"]'),'hide');
                    $('#appform').attr('required', false);
                }
                else {
                    showHide( c );
                    showHide($('label[for="appform"]'));
                    $('#appform').attr('required', true);
                }


                // Live event (When payment method is changed): Show or Hide based on "cod"
                $( 'form.checkout' ).on( 'change', a, function() {
                    if( $(b).val() !== 'bacs' ) {
                        showHide( c, 'hide' );
                        //$('label[for="appform"]').hide();
                        showHide($('label[for="appform"]'),'hide');
                    }
                    else {
                        showHide( c );
                        showHide($('label[for="appform"]'));
                    }
                });
            });
        </script>
    <?php
    endif;
}
/******************************** Checkout Upload Field When Payment Is BACS End **********************************/
/******************************** Show -Out of stock products- at the end of woocommerce pages Start **********************************/
if ( ! function_exists( 'uso_order_by_stock_status' ) ) {
    add_filter('posts_clauses', 'uso_order_by_stock_status', 1100);
    function uso_order_by_stock_status($posts_clauses)
    {
        global $wpdb, $uso_move_product_to_last;
		if ($uso_move_product_to_last == 'yes') {
        // only change query on WooCommerce loops
			if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())) {
				$posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
				$posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
				$posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
			}
		}
        return $posts_clauses;
    }
}
/******************************** Show -Out of stock products- at the end of woocommerce pages End **********************************/
/******************************************* Add Shipped Order Status Start **************************************************/
function register_wait_call_order_status() {
    register_post_status( 'wc-shipped-order', array(
    'label'                     => prof_get_switch_language('تم التسليم لشركة الشحن','Shipped'),
    'public'                    => true,
    'show_in_admin_status_list' => true,
    'show_in_admin_all_list'    => true,
    'exclude_from_search'       => false,
    'label_count'               => _n_noop( 'Shipped (%s)', 'Shipped (%s)' )
    ) );
    }
    // Add custom status to order status list
    function add_wait_call_to_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
    $new_order_statuses[ $key ] = $status;
    if ( 'wc-on-hold' === $key ) {
    $new_order_statuses['wc-shipped-order'] = prof_get_switch_language('تم التسليم لشركة الشحن','Shipped');
    }
    }
    return $new_order_statuses;
    }
    if($uso_add_shipped_order_status == 'yes'){
        add_action( 'init', 'register_wait_call_order_status' );
        add_filter( 'wc_order_statuses', 'add_wait_call_to_order_statuses' );
    }
    /******************************************* Add Shipped Order Status End **************************************************/
/*************************************** Add Bulk Action For Order Status Start ***************************************/
add_filter('bulk_actions-edit-shop_order', 'uso_shipped_register_bulk_action'); // edit-shop_order is the screen ID of the orders page

function uso_shipped_register_bulk_action($bulk_actions)
{

    $bulk_actions['mark_shipped_order'] = prof_get_switch_language('تغيير الحالة الى تم التسليم لشركة الشحن', 'Change Status To Shipped');
    return $bulk_actions;

}

add_action('handle_bulk_actions-edit-shop_order', 'uso_bulk_process_custom_status', 20, 3);

function uso_bulk_process_custom_status($redirect, $doaction, $object_ids)
{

    if ('mark_shipped_order' === $doaction) {

        // change status of every selected order
        foreach ($object_ids as $order_id) {
            $order = wc_get_order($order_id);
            $order->update_status('wc-shipped-order');
        }

        // do not forget to add query args to URL because we will show notices later
        $redirect = add_query_arg(
            array(
                'bulk_action' => 'marked_shipped_order',
                'changed' => count($object_ids),
            ),
            $redirect
        );

    }

    return $redirect;

}

add_action('admin_notices', 'uso_custom_order_status_notices');

function uso_custom_order_status_notices()
{

    if (
        isset($_REQUEST['bulk_action'])
        && 'marked_shipped_order' == $_REQUEST['bulk_action']
        && isset($_REQUEST['changed'])
        && $_REQUEST['changed']
    ) {

        // displaying the message
        printf(
            '<div id="message" class="updated notice is-dismissible"><p>' . _n('%d order status changed.', '%d order statuses changed.', $_REQUEST['changed']) . '</p></div>',
            $_REQUEST['changed']
        );

    }

}
/*************************************** Add Bulk Action For Order Status End *****************************************/
/************************************ Add Custom Onyx Fields Product Tab Start *******************************************/
if ($uso_use_extra_fields == 'yes') {
//Add a new custom product tab
    add_filter('woocommerce_product_tabs', 'uso_onyx_custom_fields_product_tab');
    function uso_onyx_custom_fields_product_tab($tabs)
    {
//To add multiple tabs, update the label for each new tab inside the $tabs['xyz'] array, e.g., custom_tab2, my_new_tab, etc.
        $title = 'Extra Info';
        if (is_rtl()) {
            $title = 'معلومات اضافية';
        }
        $tabs['uso_onyx_custom_tab'] = array(
            'title' => __($title, 'woocommerce'), //change "Custom Product tab" to any text you want
            'priority' => 70,
            'callback' => 'uso_onyx_custom_product_tab_content'
        );
        return $tabs;
    }

// Add content to a custom product tab
    function uso_onyx_custom_product_tab_content()
    {
        global $product, $uso_extra_field_1_title_ar, $uso_extra_field_1_title_en, $uso_extra_field_2_title_ar, $uso_extra_field_2_title_en, $uso_extra_field_3_title_ar, $uso_extra_field_3_title_en, $uso_extra_field_4_title_ar, $uso_extra_field_4_title_en, $uso_extra_field_5_title_ar, $uso_extra_field_5_title_en, $uso_extra_field_6_title_ar, $uso_extra_field_6_title_en, $uso_extra_field_7_title_ar, $uso_extra_field_7_title_en, $uso_extra_field_8_title_ar, $uso_extra_field_8_title_en, $uso_extra_field_9_title_ar, $uso_extra_field_9_title_en, $uso_extra_field_10_title_ar, $uso_extra_field_10_title_en,
        $uso_extra_field_11_title_ar, $uso_extra_field_11_title_en, $uso_extra_field_12_title_ar, $uso_extra_field_12_title_en, $uso_extra_field_13_title_ar, $uso_extra_field_13_title_en, $uso_extra_field_14_title_ar, $uso_extra_field_14_title_en, $uso_extra_field_15_title_ar, $uso_extra_field_15_title_en, $uso_extra_field_16_title_ar, $uso_extra_field_16_title_en, $uso_extra_field_17_title_ar, $uso_extra_field_17_title_en, $uso_extra_field_18_title_ar, $uso_extra_field_18_title_en, $uso_extra_field_19_title_ar, $uso_extra_field_19_title_en, $uso_extra_field_20_title_ar, $uso_extra_field_20_title_en, $uso_extra_fields_columns, $uso_extra_fields_display;

        if ($uso_extra_fields_columns == 'one' && $uso_extra_fields_display == 'table') {
            ?>
            <div class="container">
                <div class="row">
                    <?php
                    for ($i = 1; $i <= 20; $i++) {
                        $field_title = is_rtl() ? ${"uso_extra_field_{$i}_title_ar"} : ${"uso_extra_field_{$i}_title_en"};
                        $field_value = get_post_meta($product->get_id(), "Field{$i}", true);
                        ?>
                        <div class="col-12 mb-3">
                            <table id="uso-extra-info" style="width:100%">
                                <tr>
                                    <th><?php echo $field_title; ?></th>
                                    <td><?php echo $field_value; ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
    
            <?php } if ($uso_extra_fields_columns == 'two' && $uso_extra_fields_display == 'table') { ?>
                <div class="container">
                    <div class="row">
                        <?php
                        for ($i = 1; $i <= 20; $i++) {
                            $field_title = is_rtl() ? ${"uso_extra_field_{$i}_title_ar"} : ${"uso_extra_field_{$i}_title_en"};
                            $field_value = get_post_meta($product->get_id(), "Field{$i}", true);
                            ?>
                            <div class="col-md-6 mb-3">
                                <table id="uso-extra-info" style="width:100%">
                                    <tr>
                                        <th><?php echo $field_title; ?></th>
                                        <td><?php echo $field_value; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            } elseif ($uso_extra_fields_columns == 'one' && $uso_extra_fields_display == 'text') { ?>
                <div class="container">
                    <div class="row">
                        <?php
                        for ($i = 1; $i <= 20; $i++) {
                            $field_title = is_rtl() ? ${"uso_extra_field_{$i}_title_ar"} : ${"uso_extra_field_{$i}_title_en"};
                            $field_value = get_post_meta($product->get_id(), "Field{$i}", true);
                            ?>
                            <div class="col-md-12 mb-3">
                                <p><?php echo $field_title . ' : '; ?><strong><?php echo $field_value; ?></strong></p>
                            </div>
                            <?php
                        }
                        ?>
                     </div>
                </div>
            <?php	
            } elseif ($uso_extra_fields_columns == 'two' && $uso_extra_fields_display == 'text') { ?>
                <div class="container">
                    <div class="row">
                        <?php
                        for ($i = 1; $i <= 20; $i++) {
                            $field_title = is_rtl() ? ${"uso_extra_field_{$i}_title_ar"} : ${"uso_extra_field_{$i}_title_en"};
                            $field_value = get_post_meta($product->get_id(), "Field{$i}", true);
                            ?>
                            <div class="col-md-6 mb-3">
                                <p><?php echo $field_title . ' : '; ?><strong><?php echo $field_value; ?></strong></p>
                            </div>
                            <?php
                        }
                        ?>
                     </div>
                </div>
            <?php	
            }
    }
}
/************************************ Add Custom Onyx Fields Product Tab End *******************************************/
/* Send SMS Message function callback for orders message */
if ( ! function_exists( 'uso_order_send_message_callback' ) ) {
    function uso_order_send_message_callback($order_id, $msg_text){

        global $uso_sms_options, $post;
        $order                  = new WC_Order( $order_id );
        $user_name              = $order->get_billing_first_name();
        $billing_phone          = $order->get_billing_phone();

        /* Shipping Methods Shipment Number */
        $smsa = get_post_meta($post->ID, 'ced_smsa_awno', true);
        $kwick = get_post_meta($post->ID, 'kwick_shipping_number', true);
        $aymakan = get_post_meta($post->ID, 'aymakan_shipping_number', true);
        $aramex = get_post_meta($post->ID, 'aramex_shipping_number', true);
        $shipment_number = '';
        $shipping_company = '';

        if (!empty($smsa)) {

            $shipment_number = $smsa;
            $shipping_company = 'SMSA';

        } elseif (!empty($kwick)) {

            $shipment_number = $kwick;
            $shipping_company = 'Kwick Box';

        } elseif (!empty($aymakan)) {

            $shipment_number = $aymakan;
            $shipping_company = 'Aymakan';

        } elseif (!empty($aramex)) {

            $shipment_number = $aramex;
            $shipping_company = 'Aramex';

        }
        $order_number = $order_id;
        if (in_array('wt-woocommerce-sequential-order-numbers/wt-advanced-order-number.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $order_number = get_post_meta($order_id, "_order_number", true);
        }
        $replaced_items = ['#', '@', '+', '*'];
        $replace_with = [$order_number, $user_name, $shipment_number, $shipping_company];
        $sms_msg = str_replace($replaced_items, $replace_with, $msg_text);

        if ($uso_sms_options === 'phone') {

            uso_send_sms($billing_phone, $sms_msg);

        } elseif ($uso_sms_options === 'whatsapp') {

            uso_send_whatsapp_sms($billing_phone, $sms_msg);

        } elseif ($uso_sms_options === 'both') {

            uso_send_sms($billing_phone, $sms_msg);
            uso_send_whatsapp_sms($billing_phone, $sms_msg);

        }
    }
}

//  Filter the woocommerce templates path to use woocommerce templates in this plugin instead of the one in WooCommerce.
/* Override Woocommerce Templates */
if ( ! function_exists( 'uso_woocommerce_locate_template_callback' ) ) {
    add_filter('woocommerce_locate_template', 'uso_woocommerce_locate_template_callback', 1100, 3);
    function uso_woocommerce_locate_template_callback($template, $template_name, $template_path)
    {

        switch ($template_name) {
            case 'myaccount/dashboard.php':
                $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/myaccount/dashboard.php';
                break;
            case 'myaccount/form-login.php':
                $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/myaccount/form-login.php';
                break;
            case 'myaccount/form-lost-password.php':
                $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/myaccount/form-lost-password.php';
                break;
            case 'emails/email-footer.php':
                $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/emails/email-footer.php';
                break;
            case 'checkout/thankyou.php':
                $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/checkout/thankyou.php';
                break;
            case 'print-content.php':
                $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/print-order/print-content.php';
                break;
        }

        return $template;
    }//end func
}//end if

/**************************************** Display You Save $ Start ************************************/
function uso_you_save() {

    global $product, $uso_use_you_save;
    if($uso_use_you_save == 'yes'){
        if( $product->is_type('simple') || $product->is_type('external') || $product->is_type('grouped') ) {

            $regular_price     = get_post_meta( $product->get_id(), '_regular_price', true );
            $sale_price     = get_post_meta( $product->get_id(), '_sale_price', true );

            if( !empty($sale_price) ) {

                $amount_saved = $regular_price - $sale_price;
                $currency_symbol = get_woocommerce_currency_symbol();
                $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                ?>
                <!--            <p style="font-size:24px;color:red;"><b>Save: --><?php //echo number_format($amount_saved,2, '.', ''). ' ' . $currency_symbol . " (". number_format($percentage,0, '', '')."%)"; ?><!--</b></p>-->
                <p id="save-container"><b id="save-amount">Save: <?php echo number_format($amount_saved,2, '.', ''). ' ' . $currency_symbol; ?></b></p>
                <?php
            }
        }
    }
}
add_action( 'woocommerce_before_add_to_cart_form', 'uso_you_save', 11 );
/**************************************** Display You Save $ End ************************************/
/************************************ Hide COD Payment Method If Cart Exceed The Amount Variable Start *********************************************/
add_filter( 'woocommerce_available_payment_gateways', 'uso_conditionally_disable_cod_if_exceed_amount' );

function uso_conditionally_disable_cod_if_exceed_amount( $available_gateways ) { 
	global $uso_hide_cod_amount;
    if ( is_admin() ) {
        return $available_gateways;
    }

    // Get the current cart total
    $cart_total = WC()->cart->total;

    // Check if cart total exceeds $uso_hide_cod_amount
    if ( $cart_total > $uso_hide_cod_amount && !empty( $uso_hide_cod_amount ) ) {
        // Unset the COD payment method
        if ( isset( $available_gateways['cod'] ) ) {
            unset( $available_gateways['cod'] );
        }
    }

    return $available_gateways;
}
/************************************ Hide COD Payment Method If Cart Exceed The Amount Variable End *********************************************/

/*****************************************************************************/
/***************** Change Currency Symbol In Saudi Arabia  *******************/
/*****************************************************************************/
add_filter('woocommerce_currency_symbol', 'sam_uso_change_new_sar_currency_symbol', 1101, 2);
function sam_uso_change_new_sar_currency_symbol($currency_symbol, $currency) {
    global $uso_display_new_sar_currency_symbol;
    if ($currency === 'SAR' && $uso_display_new_sar_currency_symbol == 'yes') { // Change 'SAR' to your desired currency
        $currency_symbol = "<span class='custom-sar-currency-symbol'></span>";
    }
    return $currency_symbol;
}