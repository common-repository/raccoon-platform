<?php
global $client_api  ;
class RaccoonSessionBased
{
    private $result ;
    private $output = null;
    public function session()
    {
        add_action('woocommerce_after_single_product', array($this, 'callApiSessionBased'));
    }
    function callApiSessionBased()
    {
//         get session_id
        $session_id = WC()->session;
        $session = $session_id->get_customer_id();
        // get apiKey
        global $client_api;
        $apiKay = $client_api;

        $ssid = $session;
        $number_items = 11;
        $request = wp_remote_get( 'http://95.111.240.80/log/Production_Logging:callApiSessionBased',array( 'sslverify' => false ) );
        $response = wp_remote_get('http://95.111.240.80/recommend/sbcf/' . $apiKay . '/' . $ssid . '/' . $number_items . '' );
        $this->output    =  wp_remote_retrieve_body( $response );
    }
    public function viewSession()
    {
        $this->callApiSessionBased();
        $product_id = array();
        $result = json_decode($this->output, true);
        if($result['res'] > 0 ){
            foreach ($result['res'] as $key => $product){
                array_push($product_id, $product['iid']);
            }
        }
        return $product_id;
    }
}