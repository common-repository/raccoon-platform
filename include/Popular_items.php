<?php
global $client_api  ;
class RaccoonPopularItems
{
    private $result ;
    private $output = null;
    // Add To Cart Popular Products Request
    function callApiPopularAtc()
    {
//        try {
            global $client_api;
            $apiKey = $client_api;
            $action = 'atc';
            $number_items = 11;
            $headers = array(
                'Content-Type:application/json',
            );
            wp_remote_get('http://95.111.240.80/log/Production_Logging:callApiPopularAtc' , $headers );
            $response = wp_remote_get('http://95.111.240.80/recommend/popular_items/' . $apiKey . '/' . $action . '/' . $number_items , $headers );
            $this->output      = wp_remote_retrieve_body( $response );
//        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
//            wp_remote_get('http://95.111.240.80/log/Production_Error:' . $e->getMessage() , $headers );
//        }
    }
    public function viewPopularAtc()
    {
        $this->callApiPopularAtc();
        $product_id = array();
        $result = json_decode($this->output, true);
        if ($result['res'] > 0 ){
            foreach ($result['res'] as $key => $product){
                array_push($product_id, $product['key']);
            }
        }
        return $product_id;
    }
    // View Popular Products
    function callApiPopularView()
    {
//        try {
            global $client_api;
            $apiKey = $client_api;
            $action = 'view';
            $number_items = 11;
            $headers = array(
                'Content-Type:application/json',
            );
            $request = wp_remote_get( 'http://95.111.240.80/log/Production_Logging:callApiPopularView',array( 'sslverify' => false , 'timeout' => 5 ) );
            
            $response = wp_remote_get('http://95.111.240.80/recommend/popular_items/' . $apiKey . '/' . $action . '/' . $number_items , $headers );
            $this->output    = wp_remote_retrieve_body( $response );
//        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
//            wp_remote_get('http://95.111.240.80/log/Production_Error:' . $e->getMessage() , $headers );
//        }
    }

    public function viewPopularView()
    {
        $this->callApiPopularView();
        $product_id = array();
        $result = json_decode($this->output, true);
        if( $result['res'] > 0){
            foreach ($result['res'] as $key => $product){
                array_push($product_id, $product['key']);
            }
        }
//        print_r($product_id);
        return $product_id;
    }
}

