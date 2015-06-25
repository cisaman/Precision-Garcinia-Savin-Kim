<?php

class User_model extends CI_Model {

    /**
     * Validate the login's data with the database
     * @param string $user_name
     * @param string $password
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }
    
    public function getUser($data){
        
    }

}
