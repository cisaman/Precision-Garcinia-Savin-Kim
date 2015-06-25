<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('common_model', 'admin_model'));
    }

    public function index() {

        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            $this->load->view("admin/index");
        }
    }

    public function login() {

        if ($this->input->post()) {
            $posted_data = $this->input->post();
            $this->form_validation->set_rules('email_id', 'Email ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $post_data['email_id'] = $this->input->post('email_id', true);
                $post_data['password'] = $this->input->post('password', true);

                $login_data = $this->admin_model->login($posted_data);
                if ($login_data['status']) {
                    $session_data = array(
                        'admin_id' => $login_data['data']['admin_id'],
                        'admin_name' => $login_data['data']['admin_name']
                    );
                    $this->session->set_userdata($session_data);
                    redirect('admin/index');
                } else {
                    $this->session->set_flashdata("message", "Invalid Email ID/Password");
                    $this->session->set_flashdata("type", "danger");
                    redirect('admin/login');
                }
            } else {
                $this->session->set_flashdata('message', validation_errors());
                $this->session->set_flashdata('type', 'danger');
                $this->load->view('admin/login');
            }
        } else {
            $this->load->view('admin/login');
        }
    }

    public function forgotpassword() {
        if ($this->input->post()) {
            $posted_data = $this->input->post();
            $this->form_validation->set_rules('email_id', 'Email ID', 'trim|required|valid_email');

            if ($this->form_validation->run() == TRUE) {
                $post_data['email_id'] = $this->input->post('email_id', true);

                $login_data = $this->admin_model->forgotPassword($posted_data);
                if ($login_data['status']) {
                    //Send Mail to User
                    $this->load->library('email');
                    $this->email->set_newline("\r\n");
                    $this->email->from("Precision Vitality");
                    $this->email->to($login_data['data']['admin_email']);
                    $this->email->subject('New Password for your Account');
                    $message = "Dear User,<br/><br/> Your new password for your account is : <strong>" . $login_data['data']['admin_password'] . "</strong><br/><br/>Thanks,<br/>Precision Vitality";
                    $this->email->message($message);
                    $this->email->send();

                    $this->session->set_flashdata("message", "New Password is sent on your Email ID!");
                    $this->session->set_flashdata("type", "success");
                    $this->load->view("admin/forgotpassword");
                } else {
                    $this->session->set_flashdata("message", "Email ID doesn't exists in database!");
                    $this->session->set_flashdata("type", "danger");
                    $this->load->view("admin/forgotpassword");
                }
            } else {
                $this->session->set_flashdata('message', validation_errors());
                $this->session->set_flashdata('type', 'danger');
                $this->load->view("admin/forgotpassword");
            }
        } else {
            $this->load->view("admin/forgotpassword");
        }
    }

    public function logout() {
        $user_id = $this->session->userdata('admin_id');
        if (!empty($user_id)) {
            $this->session->sess_destroy();
        }
        redirect('admin/login');
    }

    public function pages() {
        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            $pages = $this->common_model->get_all_info('_pages', array());
            $this->load->view("admin/pages", array('pages' => $pages));
        }
    }

    public function addpage() {
        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {

            if ($this->input->post()) {
                $posted_data = $this->input->post();
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('page_desc', 'Page Description', 'trim|required');

                if ($this->form_validation->run() == TRUE) {
                    $post_data['page_name'] = $this->input->post('page_title', true);
                    $post_data['page_desc'] = $this->input->post('page_desc', true);
                    $insert_id = $this->common_model->create('_pages', $post_data);

                    if ($insert_id) {
                        $this->session->set_flashdata("message", "Record Saved Successfully!");
                        $this->session->set_flashdata("type", "success");
                        redirect("admin/pages");
                    } else {
                        $this->session->set_flashdata("message", "Operation Failed!");
                        $this->session->set_flashdata("type", "danger");
                        $this->load->view("admin/addpage");
                    }
                } else {
                    $this->session->set_flashdata('message', validation_errors());
                    $this->session->set_flashdata('type', 'danger');
                    $this->load->view("admin/addpage");
                }
            } else {
                $this->load->view("admin/addpage");
            }
        }
    }

    public function viewpage($id) {
        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            $pages = $this->common_model->get_info('_pages', array('page_id' => $id));
            $this->load->view("admin/viewpage", array('pages' => $pages));
        }
    }

    public function updatepage($id) {
        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            $pages = $this->common_model->get_info('_pages', array('page_id' => $id));

            if ($this->input->post()) {
                $posted_data = $this->input->post();
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('page_desc', 'Page Description', 'trim|required');

                if ($this->form_validation->run() == TRUE) {
                    $post_data['page_name'] = $this->input->post('page_title', true);
                    $post_data['page_desc'] = $this->input->post('page_desc', true);

                    $update_id = $this->common_model->update('_pages', $post_data, array('page_id' => $id));

                    if ($update_id) {
                        $this->session->set_flashdata("message", "Record Updated Successfully!");
                        $this->session->set_flashdata("type", "success");
                        redirect("admin/pages");
                    } else {
                        $this->session->set_flashdata("message", "Email ID doesn't exists in database!");
                        $this->session->set_flashdata("type", "danger");
                        $this->load->view("admin/updatepage", array('pages' => $pages));
                    }
                } else {
                    $this->session->set_flashdata('message', validation_errors());
                    $this->session->set_flashdata('type', 'danger');
                    $this->load->view("admin/updatepage", array('pages' => $pages));
                }
            } else {
                $this->load->view("admin/updatepage", array('pages' => $pages));
            }
        }
    }

    public function users($page = 1) {
        $this->load->library('pagination');
        $config['per_page'] = 20;
        $config['base_url'] = base_url() . 'admin/users/';
        $config['use_page_numbers'] = true;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            $config['total_rows'] = $this->common_model->countRecords('_users');
            $this->pagination->initialize($config);
            $offset = ($page - 1) * $config['per_page'];
            $users = $this->common_model->getUserDetailList($offset, $config['per_page']);
            $this->load->view("admin/users", array('users' => $users, 'total_records' => $config['total_rows'], 'limit' => $config['per_page'], 'page' => $page));
        }
    }

    public function viewusers($user_id) {

        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            $user = $this->common_model->viewusers($user_id);
            $this->load->view("admin/viewusers", array('user' => $user));
        }
    }

    public function cancel($product, $user_id) {
        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            $user_payment_info = $this->common_model->get_info("_payment", array('user_id'=>$user_id));            
            $this->load->library('AuthorizeNet');            
            $cancel_recurring = new AuthorizeNetARB;
            $cancel_recurring->setSandbox(AUTHORIZENET_SANDBOX);
            $cancel_recurringOnce = new AuthorizeNetARB;
            $cancel_recurringOnce->setSandbox(AUTHORIZENET_SANDBOX);
            if ($product == 'a') {                
                $cancel_response = $cancel_recurring->cancelSubscription($user_payment_info['ref_id_multi_product_a']);
                $cancel_responseOnce = $cancel_recurringOnce->cancelSubscription($user_payment_info['ref_id_once_product_a']);
                if($cancel_response->xml->messages->resultCode == "Ok"){
                    $user = $this->common_model->update("_payment", array('multi_product_a_status' => '0'), array('user_id' => $user_id));
                    $this->session->set_flashdata('message', 'Recurring canceled successfully!');
                    $this->session->set_flashdata('type', 'success');
                }else{
                    $this->session->set_flashdata('message', 'System Error!');
                    $this->session->set_flashdata('type', 'danger');
                }                               
            } else {
                $cancel_response = $cancel_recurring->cancelSubscription($user_payment_info['ref_id_multi_product_b']);
                $cancel_responseOnce = $cancel_recurringOnce->cancelSubscription($user_payment_info['ref_id_once_product_b']);
                if($cancel_response->xml->messages->resultCode == "Ok"){
                    $user = $this->common_model->update("_payment", array('multi_product_b_status' => '0'), array('user_id' => $user_id));
                    $this->session->set_flashdata('message', 'Recurring canceled successfully!');
                    $this->session->set_flashdata('type', 'success');
                }else{
                    $this->session->set_flashdata('message', 'System Error!');
                    $this->session->set_flashdata('type', 'danger');   
                }                
            }
            redirect('admin/users');
        }
    }

    public function shipfusion($product, $id) {
        $user_info = $this->common_model->get_info("_users", array('id' => $id));
        $toAddress = array(
            "firstName" => $user_info['first_name'],
            "lastName" => $user_info['last_name'],
            "companyName" => "",
            "address1" => $user_info['address'],
            "address2" => "",
            "city" => $user_info['city'],
            "state" => $this->common_model->getStateByStateID($user_info['state']),
            "zipPostalCode" => $user_info['zipcode'],
            "country" => "US",
            "phoneNumber" => $user_info['phone_number'],
            "emailAddress" => $user_info['email_address']
        );
        if ($product == 'a') {
            $items = array(
                array("SKU" => "GarciniaCambogia", "qty" => 1),
            );
        } else {
            $items = array(
                array("SKU" => "ColonVex", "qty" => 1),
            );
        }

        $data = array(
            "authCode" => "1232312350",
            "action" => "createShipment",
            "warehouse" => "US",
            "shippingService" => "",
            "signature" => 0,
            "packingSlipMessage" => "",
            "orderNumber" => "ORD" . date('YmdHis') . $user_info['id'],
            "specialInstructions" => "",
            "toAddress" => $toAddress,
            "items" => $items
        );

        $postData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://shipfusion.com/api/v1/shipments.php");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-­‐Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $sent_fusion = curl_exec($ch);
        curl_close($ch);
        $next_shipping_date = $this->common_model->last_shipping_date($id);
        if ($next_shipping_date) {
            $maxDays = date('t');
            $data = array(
                'next_recurring_date' => date('Y-m-d H:i:s', strtotime("+" . $maxDays . " days", strtotime($next_shipping_date))),
                'user_id' => $id,
                'created_date' => date('Y-m-d H:i:s'),
                'product' => $product
            );
        }
        $this->common_model->create("_shipfusion", $data);
        $this->session->set_flashdata("message", "Order sent to shipfusion successfully!");
        $this->session->set_flashdata("type", "success");
        redirect("admin/users");
    }

    public function profile() {
        $admin_id = $this->session->userdata('admin_id');
        if (empty($admin_id)) {
            redirect('admin/login');
        } else {
            if ($_POST) {
                if (!empty($_POST['admin_name']) && !empty($_POST['admin_email']) && !empty($_POST['admin_password'])) {
                    $data['admin_name'] = $_POST['admin_name'];
                    $data['admin_email'] = $_POST['admin_email'];
                    $data['admin_password'] = md5($_POST['admin_password']);
                    $this->common_model->update('_admin', $data, array('admin_id' => $admin_id));
                    $this->session->set_flashdata("message", " Profile Info has been changed successfully!");
                    $this->session->set_flashdata("type", "success");
                    $admin_details = $this->admin_model->getAdminDetails();
                    $this->load->view("admin/profile", array('adminDetails' => $admin_details));
                } else {
                    $this->session->set_flashdata("message", "Please do not empty any fields!");
                    $this->session->set_flashdata("type", "danger");
                    $admin_details = $this->admin_model->getAdminDetails();
                    $this->load->view("admin/profile", array('adminDetails' => $admin_details));
                }
            } else {
                $admin_details = $this->admin_model->getAdminDetails();
                $this->load->view("admin/profile", array('adminDetails' => $admin_details));
            }
        }
    }

}

?>