<?php

class MY_Controller extends CI_Controller {
   
    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $api_login_id = $this->common_model->get_info("savin_configuration", array('name'=>'api_login_id'));
        $transaction_id = $this->common_model->get_info("savin_configuration", array('name'=>'transaction_id'));
        $transaction_type = $this->common_model->get_info("savin_configuration", array('name'=>'transaction_type'));
        $payment['api_login_id'] = $api_login_id['value'];
        $payment['transaction_id'] = $transaction_id['value'];
        $payment['transaction_type'] = $transaction_type['value'];
                
        
        define("AUTHORIZENET_API_LOGIN_ID", $payment['api_login_id']);    // Add your API LOGIN ID
        define("AUTHORIZENET_TRANSACTION_KEY", $payment['transaction_id']); // Add your API transaction key
        if ($payment['transaction_type'] == 1) {
            define("AUTHORIZENET_SANDBOX", TRUE);
        } else {
            define("AUTHORIZENET_SANDBOX", FALSE);
        }        
    }    
}
