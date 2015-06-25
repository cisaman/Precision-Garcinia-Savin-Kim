<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Front extends MY_Controller {

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
    }

    public function index() {

        $list = $this->common_model->getCountries();

        if ($this->input->post()) {
            $posted_data = $this->input->post();
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'trim|required');
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $post_data['first_name'] = $this->input->post('first_name', true);
                $post_data['last_name'] = $this->input->post('last_name', true);
                $post_data['email_address'] = $this->input->post('email_address', true);
                $post_data['country'] = $this->input->post('country', true);
                $post_data['address'] = $this->input->post('address', true);
                $post_data['city'] = $this->input->post('city', true);
                $post_data['state'] = $this->input->post('state', true);
                $post_data['zipcode'] = $this->input->post('zipcode', true);
                $post_data['phone_number'] = $this->input->post('phone_number', true);
                $post_data['product_id'] = $this->input->post('product_id', true);
                $insert_id = $this->common_model->create('_users', $posted_data);
                if ($insert_id) {
                    $session_data = array(
                        'user_id' => $insert_id,
                        'mail_id' => $post_data['email_address'],
                        'first_name' => $post_data['first_name'],
                        'last_name' => $post_data['last_name'],
                        'email_address' => $post_data['email_address'],
                        'country' => $post_data['country'],
                        'address' => $post_data['address'],
                        'city' => $post_data['city'],
                        'state' => $post_data['state'],
                        'zipcode' => $post_data['zipcode'],
                        'phone_number' => $post_data['phone_number'],
                        'product_id' => $post_data['product_id'],
                        'shiping_amount' => '4.99'
                    );
                    $this->session->set_userdata($session_data);
//                    $this->session->set_flashdata("msg", "Product is add successfully!");
//                    $this->session->set_flashdata("flag-msg", "success");
                    redirect('front/check');
                } else {
                    $this->session->set_flashdata("msg", "System error please try again");
                    $this->session->set_flashdata("flag-msg", "error");
                    redirect('front/index');
                }
                //Make Session of the User               
            } else {
                $this->session->set_flashdata('msg', validation_errors());
                $this->session->set_flashdata('flag-msg', 'error');
                 $this->load->view('productA/index', array('top_image' => 'head-img.png', 'country' => $list));
            }
        } else {
            $this->load->view('productA/index', array('top_image' => 'head-img.png', 'country' => $list));
        }
    }

    public function check() {
        $user_id = $this->session->userdata('user_id');
        $mail_id = $this->session->userdata('mail_id');
        $userInfo = $this->common_model->get_info("savin_users", array('id'=>$user_id));
        if (!empty($user_id) && !empty($mail_id)) {
            $this->load->view('productA/check', array('title' => 'Garcinia Cambogia - Checkout', 'coupon_status'=>$userInfo['coupon_status']));
        } else {
            redirect('front/index');
        }
    }

    public function after_buy() {
        $user_id = $this->session->userdata('user_id');
        $mail_id = $this->session->userdata('mail_id');
        if (!empty($user_id) && !empty($mail_id)) {
            $this->load->view('productA/after_buy');
        } else {
            redirect('front/index');
        }
    }

    public function receipt() {
        $this->load->view('productA/receipt', array('title' => 'Garcinia Cambogia - Receipt'));
    }

    public function privacy() {
        $this->load->view('productA/privacy');
    }

    public function terms() {
        $this->load->view('productA/terms');
    }

    public function email_check() {
        //print_r($_REQUEST); die;
        $email_id = $_REQUEST['fieldValue'];
        $validateId = $_REQUEST['fieldId'];
        $validateError = "";
        $validateSuccess = "This username is available";
        /* RETURN VALUE */
        $arrayToJs = array();
        $arrayToJs[0] = $validateId;
        $res = $this->common_model->checkEmailid($email_id);
        if ($res) {
            $arrayToJs[1] = false;
        } else {
            $arrayToJs[1] = true;
        }
        echo json_encode($arrayToJs);
    }

    public function logout() {
        $user_id = $this->session->userdata('user_id');
        $mail_id = $this->session->userdata('mail_id');
        if (!empty($user_id) && !empty($mail_id)) {
            $this->session->sess_destroy();
        }
        redirect('front/index');
    }

    public function testmail() {

        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->to('rahul.g@cisinlabs.com'); // change it to yours
        $this->email->subject('testing');
        $this->email->message("Hi this testing mail");
        $this->email->send();
        print_r($this->email);
        die;
    }

    public function payment() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');            
        }        
        $user_id = $this->session->userdata('user_id');
        $mail_id = $this->session->userdata('mail_id');
        if (!empty($user_id) && !empty($mail_id)) {
            $this->form_validation->set_rules('ccnumber', 'CC number', 'trim|required');
            $this->form_validation->set_rules('exp_month', 'Expiry Month', 'trim|required');
            $this->form_validation->set_rules('exp_year', 'Expiry Year', 'trim|required|callback__check_expiredate[' . $this->input->post('exp_month') . ']');
            $this->form_validation->set_rules('cvv', 'CVV Number', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $this->load->library('AuthorizeNet');

                $field = new AuthorizeNet_Subscription;
                $recurring_transaction = new AuthorizeNetARB;
                $recurring_transaction->setSandbox(AUTHORIZENET_SANDBOX);

                $field->name = $user_id;
                if ($this->session->userdata('product_id') == '1') {
                    $field->amount = "79.9";
                    $field->trialAmount = "1";
                }
                //Recurring payment setting
                $field->intervalLength = "1";
                $field->intervalUnit = "months";
                $field->totalOccurrences = "9999";
                $field->trialOccurrences = "2";
                $field->startDate = date('Y-m-d', strtotime("+14 days"));

                //Card Information
                $field->creditCardCardNumber = $this->input->post('ccnumber');
                $field->creditCardExpirationDate = $this->input->post('exp_month') . "/" . $this->input->post('exp_year');
                $field->creditCardCardCode = $this->input->post('cvv');

                //Shipping Information
                $field->shipToFirstName = $this->session->userdata('first_name');
                $field->shipToLastName = $this->session->userdata('last_name');
                $field->shipToCity = $this->session->userdata('city');
                $field->shipToState = $this->common_model->getStateByStateID($this->session->userdata('state'));
                $field->shipToZip = $this->session->userdata('zipcode');
                $field->shipToCountry = "United States";

                //Customer Information
                $field->customerId = $this->session->userdata('user_id');
                $field->customerEmail = $this->session->userdata('mail_id');
                $field->customerPhoneNumber = $this->session->userdata('phone_number');

                //Billing Information
                $field->billToFirstName = $this->session->userdata('first_name');
                $field->billToLastName = $this->session->userdata('last_name');
                $field->billToCompany = "Savin";
                $field->billToAddress = $this->session->userdata('address');
                $field->billToCity = $this->session->userdata('city');
                $field->billToState = $this->common_model->getStateByStateID($this->session->userdata('state'));
                $field->billToZip = $this->session->userdata('zipcode');
                $field->billToCountry = "United States";

                //Send the curl request for payment
                $response = $recurring_transaction->createSubscription($field);
                if (isset($response->xml->messages->resultCode) && $response->xml->messages->resultCode == "Ok") {

                    //Automatic (AIM)
                    $shiping_payment = new AuthorizeNetAIM;
                    $shiping_payment->setSandbox(AUTHORIZENET_SANDBOX);
                    $shiping_payment->setFields(
                        array(
                            'amount' => $this->session->userdata('shiping_amount'),
                            'card_num' => $this->input->post('ccnumber'),
                            'exp_date' => $this->input->post('exp_month') . "/" . $this->input->post('exp_year'),
                            'card_code' => $this->input->post('cvv'),
                            'first_name' => $this->session->userdata('first_name'),
                            'last_name' => $this->session->userdata('last_name'),
                            'invoice_num' => time()
                        )
                    );
                    $shiping_pay_response = $shiping_payment->authorizeAndCapture(($this->session->userdata('product_id') == 1) ? "4.99" : "0", $this->input->post('ccnumber'), $this->input->post('exp_month') . "/" . $this->input->post('exp_year'));
                    $response_array = array(
                        'approved' => $shiping_pay_response->approved,
                        'declined' => $shiping_pay_response->declined,
                        'error' => $shiping_pay_response->error,
                        'response_code' => $shiping_pay_response->response_code,
                        'response_subcode' => $shiping_pay_response->response_subcode,
                        'response_reason_text' => $shiping_pay_response->response_reason_text,
                        'authorization_code' => $shiping_pay_response->authorization_code,
                        'avs_response' => $shiping_pay_response->avs_response,
                        'transaction_id' => $shiping_pay_response->transaction_id,
                        'amount' => $shiping_pay_response->amount,
                        'method' => $shiping_pay_response->method,
                        'transaction_type' => $shiping_pay_response->transaction_type,
                        'first_name' => $shiping_pay_response->first_name,
                        'last_name' => $shiping_pay_response->last_name,
                        'card_code_response' => $shiping_pay_response->card_code_response,
                        'cavv_response' => $shiping_pay_response->cavv_response,
                        'account_number' => $shiping_pay_response->account_number,
                        'card_type' => $shiping_pay_response->card_type,
                        'invoice_number' => $shiping_pay_response->invoice_number
                    );
                    $posted_data = array(
                        "user_id" => $this->session->userdata('user_id'),
                        "payment_response" => serialize($response_array),
                        "payment_transaction_id" => $response_array['transaction_id'],
                        "payment_invoice_no" => $response_array['invoice_number'],
                        "payment_date" => date("Y-m-d H:i:s"),
                        "payment_ref_id" => $response->xml->subscriptionId
                    );
                    if (!empty($response_array['approved']) && $response_array['approved'] == "1") {
                        $posted_data["payment_status"] = "Accepted";
                        $posted_data["payment_amount"] = $response_array['amount'];
                    } else if (!empty($response_array['error']) && $response_array['error'] == "1") {
                        $posted_data["payment_status"] = "Panding";
                    } else {
                        $posted_data["payment_status"] = "Rejected";
                    }
                    $payment_id = $this->common_model->create('_payment', $posted_data);

                    $file = file_get_contents(APPPATH . "views/mail/payment.html");
                    $file = str_replace('{user}', ucwords($this->session->userdata('first_name') . " " . $this->session->userdata('last_name')), $file);
                    $file = str_replace('{transaction_id}', $response_array['transaction_id'], $file);
                    $file = str_replace('{reference_id}', $response->xml->subscriptionId, $file);

                    //$file = str_replace('{transactionid}', $r['transactionid'],$file);                                

                    $this->load->library('email');
                    $this->email->set_newline("\r\n");
                    $this->email->to($this->session->userdata('email_address')); // change it to yours
                    $this->email->from("http://savin.rt.cisinlive.com", "Savin Kim"); // change it to yours
                    $this->email->subject('Savin: Payment conformation');
                    $this->email->message($file);
                    $this->email->send();
                    //destroy session
                    $this->session->sess_destroy();
                    $path = "receipt";
                } else {
                    $this->session->set_flashdata("msg", "Transaction error, Please contact with Administrator!");
                    $this->session->set_flashdata("flag-msg", "danger");
                    //destroy session
                    $this->session->sess_destroy();
                    $path = "index";                    
                }
            } else {
                $this->session->set_flashdata('msg', validation_errors());
                $this->session->set_flashdata('flag-msg', "error");
                $path = "check";
            }
        } else {
            $path = "index";            
        }
        echo $path;
    }

    //to check expiry date
    public function _check_expiredate($year, $month) {
        $exp_month = $month;
        $exp_year = $year;
        $date = $month . "/" . $year;
        if (is_numeric($exp_year) && is_numeric($exp_month)) {
            $cur_mon = date('m');
            $cur_year = date('Y');
            if ($exp_month <= 12) {
                if ($exp_year == $cur_year) {
                    if ($exp_month > $cur_mon) {
                        return true;
                    } else {
                        $this->form_validation->set_message('_check_expiredate', '%s ' . $date . ' should be greater than current date');
                        return false;
                    }
                } elseif ($exp_year > $cur_year) {
                    return true;
                } else {
                    $this->form_validation->set_message('_check_expiredate', '%s ' . $date . ' should be greater than current date');
                    return false;
                }
            } else {
                $this->form_validation->set_message('_check_expiredate', '%s ' . $date . ' is invalid format');
                return false;
            }
        } else {
            $this->form_validation->set_message('_check_expiredate', '%s ' . $date . ' is invalid format');
            return false;
        }
    }

    public function getCityListByCountryID() {
        $country_id = $_POST['id'];
        $list = $this->common_model->getCitiesByID($country_id);
        echo json_encode($list);
    }

    public function getPageByID() {
        $page_id = $_POST['id'];
        $content = $this->common_model->getPageByID($page_id);
        echo json_encode($content);
    }

    public function setShipingAmout() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');            
        }
        $user_id = $this->session->userdata('user_id');
        $this->common_model->update("savin_users", array('coupon_status'=>'1'), array('id'=>$user_id));
        $this->session->set_userdata('shiping_amount', "1.95");
        echo '1';
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

