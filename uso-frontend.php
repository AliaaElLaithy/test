<?php
if ( ! defined('ABSPATH') ) exit();

global $uso_map_status;

/* Include Files */
include USO_FRONT . 'uso-front-functions.php';
// Sms
include USO_FRONT . '/sms/uso-sms.php';

// Users
include USO_FRONT . '/users/uso-login.php';
include USO_FRONT . '/users/uso-registration.php';
//include USO_FRONT . '/users/uso-my-account.php';

// Orders
if ( $uso_map_status === 'yes' )
    include USO_FRONT . '/orders/uso-map.php';

//include USO_FRONT . '/orders/uso-shipping.php';
include USO_FRONT . '/orders/uso-cart.php';
include USO_FRONT . '/orders/uso-checkout.php';
include USO_FRONT . '/shipping/shipping.php';
include USO_FRONT . '/orders/uso-order-meta.php';
include USO_FRONT . '/orders/uso-frontend-orders-sms.php';
// Products
include USO_FRONT . '/products/uso-products.php';

// Single Product
include USO_FRONT . '/single-product/front-options.php';



