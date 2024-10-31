<?php
/**
 * @package Raccoon-platform
 *
 */
/**
 * Plugin Name: Raccoon-platform
 * Plugin URI: https://raccoonplatform.com
 * Description: More informed customers reflect more sales. Here are the features you get from using Raccoon.
 * Version: 5.1.0
 * License: GPLv2 or Later
 * Text Domain: Raccoon-Platform
 */
if (function_exists('add_action')=== false){
    exit;
}

if ( ! defined('ABSPATH')){
    die;
}

class RaccoonActivation
{
    public function __construct()
    {
        register_activation_hook(__FILE__, [$this, 'activation']);
        register_deactivation_hook(__FILE__, [$this, 'deactivation']);
    }

    public function activation()
    {
        flush_rewrite_rules();
    }

    public function deactivation()
    {
        flush_rewrite_rules();
    }
}

//Setting Plugin
require_once plugin_dir_path (__FILE__) . 'include/setting_plugin.php';
$setting = new RaccoonSetting();
$setting->setting_hook();

/*   Start  Ingest Event Request */
require_once plugin_dir_path (__FILE__) .'include/ingest_event.php';
// ingest event add to cart
$ingest = new RaccoonIngestEventAddToCart();
$ingest->ingest_addToCart();
// ingest event view
$ingest_view = new RaccoonIngestEventView();
$ingest_view->ingest_view();
/*   End  Ingest Event Request */

/*    Start Ingest Session Request */
require_once plugin_dir_path(__FILE__) . 'include/ingest_session.php';
$ingest_session = new RaccoonIngestSession();
$ingest_session->ingest_session();
/*    End Ingest Session Request */

/* Start Get Popular Items */
require_once plugin_dir_path (__FILE__). 'include/Popular_items.php';
require_once plugin_dir_path (__FILE__).'include/raccoon_apikey.php';

//     View Popular Items Atc
$popular_item_atc = new RaccoonPopularItems();
$popular_item_atc->viewPopularatc();
//    View Popular Items Atc
$popular_item_view = new RaccoonPopularItems();
$popular_item_view->viewPopularView();
/* End Get Popular Items */

/*  Start  Get and view Related Items */
require_once plugin_dir_path(__FILE__) . 'include/Related_items.php';
$view_related = new RaccoonRelatedItems();
$view_related->related();
// print_r($view_related);

/*  End  Get Related Items */

/* Start Get  Recommended Items */
require_once plugin_dir_path(__FILE__) . 'include/Session_based.php';
$session_based = new RaccoonSessionBased();
$session_based->session();
/* End Get  Recommended Items */

/* file of number item */
require_once plugin_dir_path(__FILE__) . 'include/item_number.php';

/* Start Remove Output WooCommerce Related Items */
function remove_woo_relate_products(){
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'storefront_upsell_display', 15 );
}
/* End Remove Output WooCommerce Related Items */

/* Start shortcode Popular view items */
add_shortcode('popularView', 'popularItemsView');
function popularItemsView()
{
    global $item_number;
    $myobj = new RaccoonPopularItems();
    $productsView = $myobj->viewPopularView();
    if ($productsView) {
        $atts = "[products ids='" . implode(',', $productsView) . "' limit='$item_number'  columns='4']";
        if (get_locale() == 'ar') {
            $title = '<h3 style="color: #999999">المنتجات الاكثر مشاهدة</h3>';
        } else {
            $title = '<h3 style="color: #999999">Most viewed Products </h3>';
        }
        return do_shortcode($title . $atts);
    }
}
/* End shortcode Popular view items */

/* Start shortcode Popular Atc items */
add_shortcode('popularAtc', 'popularItemsAtc');
function popularItemsAtc() {
    global $item_number;

    $myobj = new RaccoonPopularItems();
    $productsAtc = $myobj->viewPopularAtc();
    if($productsAtc) {
        $atts = "[products ids='" . implode(',', $productsAtc) . "' limit='$item_number'  columns='4']";
        if (get_locale() == 'ar') {
            $title = '<h3 style="color: #999999">معظم المنتجات التى تم شرائها</h3>';
        } else {
            $title = '<h3 style="color: #999999">Most Purchased Products </h3>';
        }
        return do_shortcode($title . $atts);
    }
}

/* End shortcode Popular Atc items */

/* Start shortcode Recommended  items  */
add_shortcode('Recommended_Item', 'popularItemSession');
function popularItemSession()
{
    global $item_number;
    global $locale, $wp_local_package;
    $myobj = new RaccoonSessionBased;
    $product_recommended = $myobj->viewSession();


    $myobj = new RaccoonRelatedItems();
    $view_related =  $myobj->viewRelated();  

    $myobj = new RaccoonPopularItems();
    $productsAtc = $myobj->viewPopularAtc();
    $productsView = $myobj->viewPopularView();
    
    if ($product_recommended) {
        $atts = "[products ids='" . implode(',', $product_recommended) . "' limit='$item_number' columns='4']";
        if (get_locale() == 'ar') {
            $title = '<h3 style="color: #999999">قد يعجبك ايضا </h3>';
        }else{
            $title = '<h3 style="color: #999999">You Might Also Like </h3>';
        }
        return do_shortcode($title . $atts);

    }elseif ($view_related){
        $atts = "[products ids='" . implode(',', $view_related) . "' limit='$item_number' columns='4']";
        if (get_locale() == 'ar') {
            $title = '<h3 style="color: #999999">قد يعجبك ايضا </h3>';
        }else{
            $title = '<h3 style="color: #999999">You Might Also Like </h3>';
        }
        return do_shortcode($title . $atts);

    }elseif($productsAtc){
        $atts = "[products ids='" . implode(',', $productsAtc) . "' limit='$item_number' columns='4']";
        if (get_locale() == 'ar') {
            $title = '<h3 style="color: #999999">قد يعجبك ايضا </h3>';
        }else{
            $title = '<h3 style="color: #999999">You Might Also Like </h3>';
        }
        return do_shortcode($title . $atts);
    }elseif($productsView){
        $atts = "[products ids='" . implode(',', $productsView) . "' limit='$item_number' columns='4']";
        if (get_locale() == 'ar') {
            $title = '<h3 style="color: #999999">قد يعجبك ايضا </h3>';
        }else{
            $title = '<h3 style="color: #999999">You Might Also Like </h3>';
        }
        return do_shortcode($title . $atts);
    }
    
}
add_action('woocommerce_after_single_product' , 'viewSession');
add_action('woocommerce_after_checkout_form' , 'viewSession');
add_action('woocommerce_after_cart' , 'viewSession');

function viewSession()
{
    echo do_shortcode('[Recommended_Item]');
}
/* End shortcode Recommended  items  */

