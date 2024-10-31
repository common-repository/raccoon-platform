<?php
global $client_api  ;

  class RaccoonRelatedItems
    {
        private $result ;
      private $output = null;
      /**
       * Customer ID.
       *
       * @var int $_customer_id Customer ID.
       */
        protected $_customer_id;
        
        public function related()
        {
            add_action('woocommerce_after_single_product', array($this, 'callApiRelated'));
        }
    function callApiRelated()
    {
        global  $client_api;
        global $product;
        if($product){
            $id = $product->get_id();
        }
        $apiKay = $client_api;
        $iid = $id;
        $number_related = 11;
        $headers = array(
            'Content-Type:application/json',
        );
        $request = wp_remote_get( 'http://95.111.240.80/log/Production_Logging:callApiRelated',array( 'sslverify' => false ) );
        $response = wp_remote_get('http://95.111.240.80/recommend/related_items/' . $apiKay . '/' . $iid . '/' . $number_related . '' );
        $this->output   = wp_remote_retrieve_body( $response );
    }

    public function viewRelated()
    {
        $this->callApiRelated();
        $product_id = array();
        $result = json_decode($this->output, true);
        if($result['res'] > 0 ){
            foreach ($result['res'] as $key => $product){
                array_push($product_id, $product['key']);
            }
        }
        return $product_id;
    }
}
