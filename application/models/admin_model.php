<?php

class Admin_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    public function login($data) {
        $this->db->where('admin_email', $data['email_id']);
        $this->db->where('admin_password', md5($data['password']));        
        $query = $this->db->get('_admin');
        //die($this->db->last_query());
        $result = array("status" => 0);

        if ($query->num_rows == 1) {
            $result = array("status" => 1, "data" => $query->row_array());
            return $result;
        }else{
           return $result; 
        }
    }

    public function getAdminName() {
        $admin_id = $this->session->userdata('admin_id');
        $this->db->where('admin_id', $admin_id);
        $query = $this->db->get('_admin');        
        $name = $query->row_array();
        return $name['admin_name'];
    }

    public function forgotPassword($data) {
        $this->db->where('admin_email', $data['email_id']);
        $query = $this->db->get('_admin');
       
        $result = array("status" => 0);

        if ($query->num_rows == 1) {
            $password = $this->getRandomPassword();
            
            $new_data['admin_password'] = md5($password);
            $this->load->model('common_model');
            $this->common_model->update('_admin', $new_data, array('admin_email' => $data['email_id']));

            $result = array("status" => 1, "data" => array('admin_email' => $data['email_id'], 'admin_password' => $password));
        }
        return $result;
    }

    public function changePassword($data) {
        $this->db->where('admin_email', $data['email_id']);
        $query = $this->db->get('_admin');
       
        $result = array("status" => 0);

        if ($query->num_rows == 1) {
            $result = array("status" => 1);            
        }
        return $result;
    }

    public static function getRandomPassword($length = 8) {
        $characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ@!#$*';        
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
     public function getAdminDetails() {
        $admin_id = $this->session->userdata('admin_id');
        $this->db->where('admin_id', $admin_id);
        $query = $this->db->get('_admin');        
        $result = $query->row_array();
        return $result;
    }
}