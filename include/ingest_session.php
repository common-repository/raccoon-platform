<?php
class RaccoonIngestSession
 {
    public function ingest_session()
    {
        // add_action('woocommerce_single_product_summary', array($this, 'callApiSession'));
        add_action('woocommerce_thankyou',array($this, 'callApiSession'));
    }
    function callApiSession()
    {
        $session_id = WC()->session;
        $session =$session_id->get_customer_id();
        $now = new DateTime();
        global  $client_api;
        $requestbody = array(
            'sessionId' => $session,
            'clientApiKey' => $client_api,
            'epochSeconds'=> $now->getTimestamp()
        );

        $headers = array(
            'Content-Type:application/json',
        );
//        try {
            wp_remote_post( 'http://95.111.240.80/log/Production_Logging:callApiSession' , $headers);
            $url = 'http://95.111.240.80:5000/recommend/ingest_session';
            $response = wp_remote_post( 'http://95.111.240.80/recommend/ingest_session', array(
                    'timeout' => 60,
                    'redirection' => 5,
                    'blocking' => true,
                    'headers' => array( 'Content-Type' => 'application/json' ),
                    'body' =>
                        json_encode(
                            array(
                                'sessionId' => $session,
                                'clientApiKey' => $client_api,
                                'epochSeconds'=> $now->getTimestamp()
                            )
                        ),
                    'cookies' => array()
                )
            );
//        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
//            wp_remote_get('http://95.111.240.80/log/Production_Error:' . $e->getMessage() , $headers );
//        }
    }
}