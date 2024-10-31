<?php
class RaccoonIngestEventAddToCart{
    public function ingest_addToCart(){
        add_action('woocommerce_add_to_cart',array($this,'callApiProduct_add'));
    }
    function callApiProduct_add()
    {
        global $woocommerce;
        global  $client_api;
        $items = $woocommerce->cart->get_cart();
        foreach ($items as $item => $values) {
            $_product = wc_get_product($values['data']->get_id());
            $price = get_post_meta($values['product_id'], '_price', true);
// get category
            $cart_item =  WC()->cart->get_cart() ;
            $product_id = $cart_item['product_id'];
            $category_product =  wc_get_product_category_list( $product_id, '',  '',  '' );
// get session id
            $session_id  = WC()->session->get_customer_id();
            global $woocommerce;
//get cart items
            $items = $woocommerce->cart->get_cart();
            $ids = array();
            $item =  $items->$values;
            $_product = $values['data']->post;
            //push each id into array
            $ids[] = $_product->ID;
//get last product id
            $last_product_id = end($ids);
            // code test for cart data
            foreach ( WC()->cart->get_cart() as $cart_item ) {

                // get the data of the cart item
                $product_id         = $cart_item['product_id'];
                $variation_id       = $cart_item['variation_id'];
                // gets the cart item quantity
                $quantity           = $cart_item['quantity'];
                // gets the product object
                $product            = $cart_item['data'];
                // get the data of the product
                $sku                = $product->get_sku();
                $name               = $product->get_name();
                // attributes
                // product categories
                $categories         = wc_get_product_category_list(  $product_id ); // returns a string with all product categories separated by a comma
                $category = strip_tags($categories);
                //get date now
                $now = new DateTime();

                global $woocommerce;
                $items = $woocommerce->cart->get_cart();

                foreach($items as $item => $values) {
                    $_product =  wc_get_product( $values['data']->get_id());
                    $product_name = $_product->get_title();
                    $quantity = $values['quantity'];
                    $price_product = get_post_meta($values['product_id'] , '_price', true);
                }
            }
        }
        // get Istatus
        $min = 0;
        $max = 2;
        $istatus  = rand($min, $max);
        $headers = array(
            'Content-Type:application/json',
        );
//        try {
            wp_remote_post( 'http://95.111.240.80/log/Production_Logging:callApiProduct_add' , $headers);
            $response = wp_remote_post( 'http://95.111.240.80/ingest/event', array(
                    'timeout' => 60,
                    'redirection' => 5,
                    'blocking' => true,
                    'headers' => array( 'Content-Type' => 'application/json' ),
                    'body' =>
                        json_encode(
                            array(
                                'sessionId' => $session_id,
                                'clientApiKey' => $client_api,
                                'category' => 'item',
                                'action' => 'atc',
                                'interactive' => 'true',
                                'label' => $product_id,
                                'amount' => $quantity,
                                'epochSeconds'=> $now->getTimestamp(),
                                'eventData' => array(
                                    'iname' => $name,
                                    'iprice' => $price_product,
                                    'istatus' => $istatus
                                ),
                            )
                        ),
                    'cookies' => array()
                )
            );
//        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
//            wp_remote_get('http://95.111.240.80/log/Production_Error:' . $e->getMessage() , $headers );
//
//        }
    }
}

class RaccoonIngestEventView {
    public function ingest_view(){
        add_action('woocommerce_single_product_summary',array($this,'callApiProduct_View'));
    }

    function callApiProduct_View()
    {
        // get session id
        $session_id  = WC()->session->get_customer_id();
        global $product;
        $name = $product->get_title();
        $id = $product->get_id();
        $price = $product->get_price();
        $category_product = $product->get_categories();
        global  $client_api;
        $category = strip_tags($category_product);
        //get date now
        $now = new DateTime();
        // get Istatus
        $min = 0;
        $max = 2;
      $istatus  = rand($min, $max);
        $headers = array(
            'Content-Type:application/json',
        );
//        try {
            wp_remote_post( 'http://95.111.240.80/log/Production_Logging:callApiProduct_View' , $headers);

            $response = wp_remote_post( 'http://95.111.240.80/ingest/event', array(
                    'timeout' => 60,
                    'redirection' => 5,
                    'blocking' => true,
                    'headers' => array( 'Content-Type' => 'application/json' ),
                    'body' =>
                        json_encode(
                            array(
                                'sessionId' => $session_id,
                                'clientApiKey' => $client_api,
                                'category' => 'item',
                                'action' => 'view',
                                'interactive' => 'true',
                                'label' => $id,
                                'amount' => 1,
                                'epochSeconds'=> $now->getTimestamp(),
                                'eventData' => array(

                                    'iname' => $name,
                                    'iprice' => $price,
                                    'istatus' => $istatus
                                ),
                            )
                        ),
                    'cookies' => array()
                )
            );

//        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
//            wp_remote_get('http://95.111.240.80/log/Production_Error:' . $e->getMessage() , $headers );
//
//        }
    }
}