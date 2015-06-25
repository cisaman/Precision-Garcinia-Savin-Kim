<?php

class Common_model extends CI_Model {

    /**
     * Validate the login's data with the database
     * @param string $user_name
     * @param string $password
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Serialize the session data stored in the database, 
     * store it in a new array and return it to the controller 
     * @return array
     */
    function get_db_session_data() {
        $query = $this->db->select('user_data')->get('_ci_sessions');
        $user = array(); /* array to store the user data we fetch */
        foreach ($query->result() as $row) {
            $udata = unserialize($row->user_data);
            /* put data in array using username as key */
            $user['user_name'] = $udata['user_name'];
            $user['is_logged_in'] = $udata['is_logged_in'];
        }
        return $user;
    }

    // common get function to be used to get data
    function get($table, $where, $limit_start, $limit_end) {
        $this->db->where($where);
        $this->db->limit($limit_start, $limit_end);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getRecordsByLimit($table, $where, $offset, $limit, $orderby=array()) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->offset($offset);
        if(!empty($orderby)){
           foreach($orderby as $key=>$value){
              $this->db->order_by($key,$value); 
           } 
        }
        $this->db->limit($limit);
        $query = $this->db->get($table);
        //die($this->db->last_query());
        return $query->result_array();
    }
    
    function getUserDetailList($offset='', $limit=''){        
        $sql= "SELECT `savin_payment`.`multi_product_a_status`, `savin_payment`.`multi_product_b_status`, `savin_users`.`id`,`savin_users`.`first_name`, `savin_users`.`last_name`, `savin_users`.`email_address`, `savin_users`.`address`, `savin_users`.`city`, `savin_users`.`zipcode`, `savin_users`.`phone_number`, `savin_users`.`product_id`, `savin_users`.`coupon_status`, `savin_users`.`created`, `savin_country`.`country_name`, `savin_payment`.`ref_id_once_product_a`,`savin_payment`.`ref_id_once_product_b`,`savin_payment`.`ref_id_multi_product_b`,`savin_payment`.`ref_id_multi_product_b`, `savin_payment`.`payment_date`, `savin_state`.`state_name` FROM (`savin_users`) JOIN `savin_state` ON `savin_state`.`state_id` = `savin_users`.`state` JOIN `savin_country` ON `savin_country`.`country_id` = `savin_users`.`country` LEFT JOIN `savin_payment` ON `savin_payment`.`user_id` = `savin_users`.`id` WHERE (`savin_payment`.`multi_product_a_status` = '1' OR `savin_payment`.`multi_product_b_status` = '1') ORDER BY `savin_users`.`id` DESC ";
        $sql .= " LIMIT {$offset},{$limit}"; 
        $result = $this->db->query($sql);        
        //die($this->db->last_query());
        $rowArray = $result->result_array();
        return $rowArray;
    }

    // common custom query function 
    function custom($custom_query) {
        //echo $custom_query; die;
        $query = $this->db->query($custom_query);
        return $query->result_array();
    }

    function count($table, $where) {
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    function countRecords($table) {
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    function custom_count($query) {
        $query = $this->db->query($query);
        return $query->num_rows();
    }

    function create($table, $data) {
        $this->db->trans_start();
        $execute = $this->db->insert($table, $data);
        if (!$execute) {
            return $this->db->_error_message();
        } else {
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }
    }

    function update($table, $data, $where) {

        $this->db->where($where);
        $query = $this->db->update($table, $data);
        return 1;
    }

    function get_info($table, $where) {
        $result = array();
        $this->db->where($where);
        $query = $this->db->get($table);
        $result = $query->row_array();

        return $result;
    }

    function get_all_info($table, $where) {
        $page = 0;
        $limitStart = 0;
        $numrow = 5;
        if (!empty($_REQUEST['page'])) {
            $page = isset($_REQUEST['page']) ? ($_REQUEST['page']) - 1 : 0;
            $limitStart = ($page * 5);
        }
        $result = array();
        $this->db->where($where);
        $this->db->limit(5, $limitStart);
        $query = $this->db->get($table);
        $result = $query->result_array();
        return $result;
    }

    function get_user_records($table, $where) {
        $result = array();
        $this->db->where($where);
        $query = $this->db->get($table);
        $result = $query->result_array();
        return $result;
    }

    function delete($table, $where) {
        $this->db->where($where);
        return $this->db->delete($table);
        //$result = $this->db->affected_rows();
        //return $result;
    }

    function get_employee_info($id) {
        $this->db->where("id", $id);
        $query = $this->db->get('_hiring');
        return $query->row_array();
    }

    function get_study_area($table, $employee_id) {
        $result = array();
        $this->db->where('id_hiring', $employee_id);
        $query = $this->db->get($table);
        $result = $query->result_array();

        return $result;
    }

    function update_employee($emp_id, $data) {
        $this->db->where("id", $emp_id);
        $query = $this->db->update('_hiring', $data);
        return 1;
    }

    function check_mail_uniqueness($table, $where) {

        $result = array();
        $this->db->where($where);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    function check_mail_uniqueness_for_update($table, $where, $user_id, $id = 'id') {

        $result = array();
        $this->db->where($where);
        $this->db->where($id . ' !=', $user_id);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0)
            return false;
        else
            return true;
    }

    function delete_education_by_id($id) {
        $this->db->delete('_hiring_education', array('id' => $id));
        $result = $this->db->affected_rows();
        $flag = false;
        if ($result > 0) {
            $flag = true;
        }
        return $flag;
    }

    //Start :: get selected detail //
    function select($table, $select, $where, $num = 0, $order_by = array()) {
        if ($select != '')
            $this->db->select($select, FALSE);

        if (!empty($where))
            $this->db->where($where);

        if (is_array($order_by) && !empty($order_by))
            foreach ($order_by as $k => $v)
                $this->db->order_by($k, $v);

        $query = $this->db->get($table);
        //echo $this->db->last_query();
        //die($this->db->last_query());
        if ($num == '1') {
            return $query->result_array();
        } else {
            return $query->row_array();
        }
    }

    //End   :: get selected detail //
    //MAKE STRING
    public function generate_serial($length) {
        $len = $length;
        $base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($base) - 1;
        $rand_num = '';
        mt_srand((double) microtime() * 1000000);
        while (strlen($rand_num) < $len + 1)
            $rand_num.= $base{
                    mt_rand(0, $max)
                    };

        return $rand_num;
    }

    //get internal comment files
    function getCmtFiles($id, $essay_id) {
        $this->db->select('files');
        $this->db->where(array('id' => $id, 'essay_id' => $essay_id));
        $query = $this->db->get('_internal_comments');
        //die($this->db->last_query());
        return $query->row_array();
    }

    //join function
    /*
     * select : parameters with comma seprators
     * from : table name
     * join : Join is an array of table and on condition
     * where : Where is an array of where condition
     */
    function join($select, $from, $join = array(), $where = array(), $count = false, $result = "0", $order_by = array(), $group_by = array()) {

        $this->db->select($select, FALSE);
        $this->db->from($from);

        foreach ($join as $join_table => $on_condition) {
            $this->db->join($join_table, $on_condition);
        }

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($order_by)) {
            foreach ($order_by as $order_key => $order_value) {
                $this->db->order_by($order_key, $order_value);
            }
        }
        if (!empty($group_by)) {
            foreach ($group_by as $group_key => $group_value) {
                $this->db->group_by($group_key, $group_value);
            }
        }

        $query = $this->db->get();
        //die($this->db->last_query());
        if ($count) {
            if ($result == 0) {
                return $query->row_array();
            } else {
                return $query->result_array();
            }
        } else {
            return $query->num_rows();
        }
    }

    function checkEmailid($emailid) {
        $this->db->select('savin_users.id');
        $this->db->from('savin_users');
        //$this->db->join('savin_payment', 'savin_payment.user_id = savin_users.id');	                
        $this->db->where('savin_users.email_address', $emailid);
        $query = $this->db->get();
        //die($this->db->last_query());     
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_config_by_field_name($feild_name) {
        $this->db->where('field_name', $feild_name);
        $query = $this->db->get("_configuration");
        return $query->row_array();
    }

    function getCountries() {
        $query = $this->db->get("savin_country");
        return $query->result_array();
    }

    function getCitiesByID($id) {
        $this->db->where('state_countryID', $id);
        $this->db->order_by("state_name", "ASC");
        $query = $this->db->get("savin_state");
        return $query->result_array();
    }

    function getPageByID($id) {
        $this->db->where('page_id', $id);
        $query = $this->db->get("savin_pages");
        return $query->row_array();
    }

    function getStateByStateID($id) {
        $this->db->where('state_id', $id);
        $query = $this->db->get("savin_state");
        $rowArray = $query->row_array();
        return $rowArray['state_name'];
    }

    function viewusers($id) {
        $sql= "SELECT savin_users.id,savin_users.first_name, savin_users.last_name, savin_users.email_address, savin_users.address, savin_users.city, savin_users.zipcode, savin_users.phone_number, savin_users.product_id, savin_users.coupon_status, savin_users.created, savin_country.country_name, savin_payment.ref_id_once_product_a, savin_payment.ref_id_once_product_b, savin_payment.ref_id_multi_product_a, savin_payment.ref_id_multi_product_b, savin_payment.payment_date, savin_state.state_name FROM (savin_users) JOIN savin_state ON savin_state.state_id = savin_users.state JOIN savin_country ON savin_country.country_id = savin_users.country LEFT JOIN savin_payment ON savin_payment.user_id = savin_users.id AND savin_payment.status = '1' WHERE savin_users.id = ".$id;
        $result = $this->db->query($sql);
        $rowArray = $result->row_array();
        return $rowArray;
    }
    
    function checkUserIsPaidByUserID($id){
        $this->db->select("_payment.payment_id, _payment.status, ref_id_once_product_a, ref_id_once_product_b, ref_id_multi_product_a, ref_id_multi_product_b, multi_product_a_status, multi_product_b_status");
        $this->db->from("_payment");
        $this->db->where("_payment.user_id", $id);
        $query = $this->db->get();
        //die($this->db->last_query());
        $result = $query->row_array();        
        if($query->num_rows()){
            return $result['status'];
        }else{
            return '2';
        }        
    }
    
    function getShipFusionInfoByUserIDAndMonth($id, $product){
        $minvalue = date('Y-m-1');
        $maxvalue = date('Y-m-t');
        $this->db->select("_shipfusion._id");
        $this->db->from("_shipfusion");
        $this->db->where("_shipfusion.created_date BETWEEN $minvalue AND $maxvalue");
        $this->db->where('_shipfusion.product', $product);
        $this->db->where("_shipfusion.user_id", $id);
        $query = $this->db->get();
        //die($this->db->last_query());
        if($query->num_rows()){
            return true;
        }else{
            return false;
        }
        
    }
    
    function last_shipping_date($id, $product){
        $this->db->select('next_recurring_date');
        $this->db->from("_shipfusion");
        $this->db->where("user_id", $id);
        $this->db->where("product", $product);
        $this->db->order_by("_id", "Desc");
        $query = $this->db->get();
        //die($this->db->last_query());
        $result = $query->row_array();
        if($query->num_rows()){
            return $result['next_recurring_date'];
        }else{
            return false;
        }        
    }
    
    function getsubScriptionIdInfo($id){
        $this->db->select('_payment.user_id');
        $this->db->select('_payment.ref_id_multi_product_a');
        $this->db->select('_payment.ref_id_multi_product_b');
        $this->db->select('_users.*');
        $this->db->from("_payment");
        $this->db->join("_users","_users.id = _payment.user_id");
        $this->db->or_where('_payment.ref_id_multi_product_a', $id);
        $this->db->or_where('_payment.ref_id_multi_product_b', $id);
        $query = $this->db->get();
        //die($this->db->last_query());
        if($query->num_rows() > 0){
            return $result = $query->row_array();
        }else{
            return false;
        }
    }

}
