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
            $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|unique');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'trim|required');
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required');

            $res = $this->common_model->checkEmailid($this->input->post('email_address', true));
            if ($res) {
                $email_check_msg = "Email Address is already in use!";
                $this->load->view('productA/index', array('top_image' => 'head-img.png', 'country' => $list, 'error_msg' => $email_check_msg));
                return true;
            }

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
                        'shiping_amount' => '4.95'
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
        $userInfo = $this->common_model->get_info("savin_users", array('id' => $user_id));
        if (!empty($user_id) && !empty($mail_id)) {
            $this->load->view('productA/check', array('title' => 'Garcinia Cambogia - Checkout', 'coupon_status' => $userInfo['coupon_status']));
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

    public function setshipment() {           
       if ($this->input->post()) {
            if (!empty($_POST['x_subscription_id']) && $_POST['x_type'] == "auth_capture" && $_POST['x_response_code'] == '1') {
                $ref_id = $_POST['x_subscription_id'];
                $detailArray = $this->common_model->getsubScriptionIdInfo($ref_id);
                if ($detailArray) {
                    $product = ($detailArray['ref_id_multi_product_a'] == $ref_id) ? 'A' : 'B';
                    $toAddress = array(
                        "firstName" => $detailArray['first_name'],
                        "lastName" => $detailArray['last_name'],
                        "companyName" => "",
                        "address1" => $detailArray['address'],
                        "address2" => "",
                        "city" => $detailArray['city'],
                        "state" => $this->common_model->getStateByStateID($detailArray['state']),
                        "zipPostalCode" => $detailArray['zipcode'],
                        "country" => "US",
                        "phoneNumber" => $detailArray['phone_number'],
                        "emailAddress" => $detailArray['email_address']
                    );
                    if ($product == 'A') {
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
                        "orderNumber" => "ORD" . date('YmdHis'). $detailArray['user_id'],
                        "specialInstructions" => "",
                        "toAddress" => $toAddress,
                        "items" => $items
                    );
                    echo "<pre>";
                    print_r($data);die;
                    $postData = json_encode($data);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://shipfusion.com/api/v1/shipments.php");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-­‐Type:application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    if (AUTHORIZENET_SANDBOX == 0) {
                        $result = curl_exec($ch);
                    }
                    curl_close($ch);
                    $maxDays = date('t');
                    $data = array(
                        'next_recurring_date' => date('Y-m-d H:i:s', strtotime("+" . $maxDays . " days", strtotime(date('Y-m-d H:i:s')))),
                        'user_id' => $detailArray['user_id'],
                        'created_date' => date('Y-m-d H:i:s')
                    );
                    if ($product == 'A') {
                        $data['product'] = 'a';
                        $this->common_model->create("_shipfusion", $data);
                    } else {
                        $data['product'] = 'b';
                        $this->common_model->create("_shipfusion", $data);
                    }                                        
                }
            }
        }
        $this->load->library('email');
         $this->email->set_newline("\r\n");
         $this->email->to('rahultesttesttest@mailinator.com'); // change it to yours
         $this->email->from('aman@mailinator.com');
         $this->email->subject('testing');
         $silentpost = "Developer - Rahul";
         $silentpost .= 'x_response_code:-' . $_POST['x_response_code'] . "/n";
         $silentpost .= 'x_response_subcode:-' . $_POST['x_response_subcode']  . "/n";
         $silentpost .= 'x_response_reason_code:-' . $_POST['x_response_reason_code']  . "/n";
         $silentpost .= 'x_response_reason_text:-' . $_POST['x_response_reason_text']  . "/n";
         $silentpost .= 'x_auth_code:-' . $_POST['x_auth_code']  . "/n";
         $silentpost .= 'x_avs_code:-' . $_POST['x_avs_code']  . "/n";
         $silentpost .= 'x_trans_id:-' . $_POST['x_trans_id']  . "/n";
         $silentpost .= 'x_invoice_num:-'.  $_POST['x_invoice_num']  . "/n";
         $silentpost .= 'x_description:-' . $_POST['x_description']  . "/n";
         $silentpost .= 'x_amount:-' . $_POST['x_amount']  . "/n";
         $silentpost .= 'x_method:-' . $_POST['x_method']  . "/n";
         $silentpost .= 'x_type:-' . $_POST['x_type']  . "/n";
         $silentpost .= 'x_cust_id:-' . $_POST['x_cust_id']  . "/n";
         $silentpost .= 'x_first_name:-' . $_POST['x_first_name']  . "/n";
         $silentpost .= 'x_last_name:-' . $_POST['x_last_name']  . "/n";
         $silentpost .= 'x_company:-' . $_POST['x_company']  . "/n";
         $silentpost .= 'x_address:-' . $_POST['x_address']  . "/n";
         $silentpost .= 'x_city:-' . $_POST['x_city']  . "/n";
         $silentpost .= 'x_state:-' . $_POST['x_state']  . "/n";
         $silentpost .= 'x_zip:-' . $_POST['x_zip']  . "/n";
         $silentpost .= 'x_country:-' . $_POST['x_country']  . "/n";
         $silentpost .= 'x_phone:-' . $_POST['x_phone']  . "/n";
         $silentpost .= 'x_fax:-' . $_POST['x_fax']  . "/n";
         $silentpost .= 'x_email:-' . $_POST['x_email']  . "/n";
         $silentpost .= 'x_ship_to_first_name:-' . $_POST['x_ship_to_first_name']  . "/n";
         $silentpost .= 'x_ship_to_last_name:-' . $_POST['x_ship_to_last_name']  . "/n";
         $silentpost .= 'x_ship_to_company:-' . $_POST['x_ship_to_company']  . "/n";
         $silentpost .= 'x_ship_to_address:-' . $_POST['x_ship_to_address']  . "/n";
         $silentpost .= 'x_ship_to_city:-' . $_POST['x_ship_to_city']  . "/n";
         $silentpost .= 'x_ship_to_state:-' . $_POST['x_ship_to_state']  . "/n";
         $silentpost .= 'x_ship_to_zip:-' . $_POST['x_ship_to_zip']  . "/n";
         $silentpost .= 'x_ship_to_country:-' . $_POST['x_ship_to_country']  . "/n";
         $silentpost .= 'x_tax:-' . $_POST['x_tax']  . "/n";
         $silentpost .= 'x_duty:-' . $_POST['x_duty']  . "/n";
         $silentpost .= 'x_freight:-' . $_POST['x_freight']  . "/n";
         $silentpost .= 'x_tax_exempt:-' . $_POST['x_tax_exempt']  . "/n";
         $silentpost .= 'x_po_num:-' . $_POST['x_po_num']  . "/n";
         $silentpost .= 'x_MD5_Hash:-' . $_POST['x_MD5_Hash']  . "/n";
         $silentpost .= 'x_cavv_response:-' . $_POST['x_cavv_response']  . "/n";
         $silentpost .= 'x_test_request:-' . $_POST['x_test_request']  . "/n";
         $silentpost .= 'x_subscription_id:-' . $_POST['x_subscription_id']  . "/n";
         $silentpost .= 'x_subscription_paynum:-' . $_POST['x_subscription_paynum']  . "/n";
         $silentpost .= 'x_cim_profile_id:-' . $_POST['x_cim_profile_id']  . "/n";
         $this->email->message($silentpost);
         $this->email->send();
    }

    public function test() {
        $this->load->view('productA/test');
    }

    public function payment() {
        $user_id = $this->session->userdata('user_id');
        $mail_id = $this->session->userdata('mail_id');
        $user_info = $this->common_model->get_info("_users", array('id' => $user_id));
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if (!empty($user_id) && !empty($mail_id)) {
            $this->form_validation->set_rules('ccnumber', 'CC number', 'trim|required');
            $this->form_validation->set_rules('exp_month', 'Expiry Month', 'trim|required');
            $this->form_validation->set_rules('exp_year', 'Expiry Year', 'trim|required|callback__check_expiredate[' . $this->input->post('exp_month') . ']');
            $this->form_validation->set_rules('cvv', 'CVV Number', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                //$this->common_model->update("savin_users", array('coupon_status'=>'1'),array('id'=>$this->session->userdata('user_id')));
                $this->load->library('AuthorizeNet');
                /*
                 *  Create recuring payment for product A after 14 days                 
                 */
                $field = new AuthorizeNet_Subscription;
                $field->name = $user_id;
                $field->amount = "79.99";
                //Recurring payment setting
                $field->intervalLength = "1";
                $field->intervalUnit = "months";
                $field->totalOccurrences = "1";
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
                $field->shipToAddress = $this->session->userdata('address');

                //Customer Information
                $field->customerId = $this->session->userdata('user_id');
                $field->customerEmail = $this->session->userdata('mail_id');
                $field->customerPhoneNumber = $this->session->userdata('phone_number');

                //Billing Information
                $field->billToFirstName = $this->session->userdata('first_name');
                $field->billToLastName = $this->session->userdata('last_name');
                $field->billToCompany = "";
                $field->billToAddress = $this->session->userdata('address');
                $field->billToCity = $this->session->userdata('city');
                $field->billToState = $this->common_model->getStateByStateID($this->session->userdata('state'));
                $field->billToZip = $this->session->userdata('zipcode');
                $field->billToCountry = "United States";

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
                            'invoice_num' => time(),
                            "ship_to_address" => $field->billToAddress,
                            "ship_to_city" => $field->billToCity,
                            "ship_to_country" => $field->billToCountry,
                            "ship_to_first_name" => $field->billToFirstName,
                            "ship_to_last_name" => $field->billToLastName,
                            "ship_to_state" => $field->billToState,
                            "ship_to_zip" => $field->billToZip,
                            "address" => $field->billToAddress,
                            "city" => $field->billToCity,
                            "country" => $field->billToCountry,
                            "first_name" => $field->billToFirstName,
                            "last_name" => $field->billToLastName,
                            "state" => $field->billToState,
                            "zip" => $field->billToZip,
                        )
                );
                $shiping_pay_response = $shiping_payment->authorizeAndCapture(($this->session->userdata('product_id') == 1) ? ($this->session->userdata['shiping_amount']) : "0", $this->input->post('ccnumber'), $this->input->post('exp_month') . "/" . $this->input->post('exp_year'));
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
                $msg = '';
                $posted_data = array(
                    "user_id" => $this->session->userdata('user_id'),
                    "payment_response" => serialize($response_array),
                    "payment_transaction_id" => $response_array['transaction_id'],
                    "payment_invoice_no" => $response_array['invoice_number'],
                    "payment_date" => date("Y-m-d H:i:s")
                );
                if (!empty($response_array['approved']) && $response_array['approved'] == "1") {
                    $posted_data["payment_status"] = "Accepted";
                    $msg = 'Your transaction is Completed successfully!';
                    $posted_data["payment_amount"] = $response_array['amount'];

                    /*
                     * Create recuring payment for product A after 14 days
                     */
                    $productOnceA = new AuthorizeNetARB;
                    $productOnceA->setSandbox(AUTHORIZENET_SANDBOX);
                    $responseOnceA = $productOnceA->createSubscription($field);

                    /*
                     * Create recuring payment for product B after 14 days
                     */
                    $field->amount = "39.99";
                    $productOnceB = new AuthorizeNetARB;
                    $productOnceB->setSandbox(AUTHORIZENET_SANDBOX);
                    $responseOnceB = $productOnceB->createSubscription($field);
                    /*
                     * Create recuring payment for product A after 30 days
                     */
                    $recurring_date = date('t');
                    $field->startDate = date('Y-m-d', strtotime("+" . $recurring_date . " days"));
                    $field->amount = "84.94";
                    $field->intervalLength = "1";
                    $field->intervalUnit = "months";
                    $field->totalOccurrences = "9999";

                    $productMultiA = new AuthorizeNetARB;
                    $productMultiA->setSandbox(AUTHORIZENET_SANDBOX);
                    $responseMultiA = $productMultiA->createSubscription($field);
                    /*
                     * Create recuring payment for product B after 30 days
                     */
                    $field->amount = "44.94";
                    $field->intervalLength = "1";
                    $field->intervalUnit = "months";
                    $field->totalOccurrences = "9999";

                    $productMultiB = new AuthorizeNetARB;
                    $productMultiB->setSandbox(AUTHORIZENET_SANDBOX);
                    $responseMultiB = $productMultiB->createSubscription($field);

                    $posted_data["ref_id_once_product_a"] = $responseOnceA->xml->subscriptionId;
                    $posted_data["ref_id_once_product_b"] = $responseOnceB->xml->subscriptionId;
                    $posted_data["ref_id_multi_product_a"] = $responseMultiA->xml->subscriptionId;
                    $posted_data["ref_id_multi_product_b"] = $responseMultiB->xml->subscriptionId;

                    /* PHP Authorize .net CIM */

                    $cimobj = new AuthorizeNetCIM;
                    $cimobj->setSandbox(AUTHORIZENET_SANDBOX);
                    $cim = new AuthorizeNetCustomer;
                    $cim->merchantCustomerId = $this->session->userdata('user_id');
                    $cim->description = "";
                    $cim->email = $this->session->userdata('mail_id');
                    $res = $cimobj->createCustomerProfile($cim);
                    $profileID = $res->xml->customerProfileId;

                    /* add payment profile cim */

                    $cinfo = new AuthorizeNetPaymentProfile;
                    //$cpay->customerType = "I";
                    $cinfo->billTo->firstName = $this->session->userdata('first_name');
                    $cinfo->billTo->lastName = $this->session->userdata('last_name');
                    $cinfo->billTo->city = $this->session->userdata('city');
                    $cinfo->billTo->state = $this->common_model->getStateByStateID($this->session->userdata('state'));
                    $cinfo->billTo->zip = $this->session->userdata('zipcode');
                    $cinfo->billTo->country = "United States";
                    $cinfo->billTo->address = $this->session->userdata('address');
                    $cinfo->billTo->phoneNumber = $this->session->userdata('phone_number');
                    $cinfo->payment->creditCard->cardNumber = $this->input->post('ccnumber');
                    $cinfo->payment->creditCard->expirationDate = $this->input->post('exp_month') . $this->input->post('exp_year');
                    $cinfo->payment->creditCard->cardCode = $this->input->post('cvv');
                    $cimobj->createCustomerPaymentProfile($profileID, $cinfo);

                    /* add shiping info */

                    $ship = new AuthorizeNetAddress;
                    $ship->firstName = $this->session->userdata('first_name');
                    $ship->lastName = $this->session->userdata('last_name');
                    $ship->city = $this->session->userdata('city');
                    $ship->state = $this->common_model->getStateByStateID($this->session->userdata('state'));
                    $ship->zip = $this->session->userdata('zipcode');
                    $ship->country = "United States";
                    $ship->address = $this->session->userdata('address');
                    $ship->phoneNumber = $this->session->userdata('phone_number');
                    $resp = $cimobj->createCustomerShippingAddress($profileID, $ship);

                    /* End CIM */

                    $payment_id = $this->common_model->create('_payment', $posted_data);
                    $toAddress = array(
                        "firstName" => $this->session->userdata('first_name'),
                        "lastName" => $this->session->userdata('last_name'),
                        "companyName" => "",
                        "address1" => $this->session->userdata('address'),
                        "address2" => "",
                        "city" => $this->session->userdata('city'),
                        "state" => $this->common_model->getStateByStateID($this->session->userdata('state')),
                        "zipPostalCode" => $this->session->userdata('zipcode'),
                        "country" => "US",
                        "phoneNumber" => $this->session->userdata('phone_number'),
                        "emailAddress" => $this->session->userdata('mail_id')
                    );

                    $items = array(
                        array("SKU" => "GCPack", "qty" => 1),
                    );

                    $data = array(
                        "authCode" => "1232312350",
                        "action" => "createShipment",
                        "warehouse" => "US",
                        "shippingService" => "",
                        "signature" => 0,
                        "packingSlipMessage" => "",
                        "orderNumber" => "ORD" . $user_id,
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
                    if (AUTHORIZENET_SANDBOX == 0) {
                        $result = curl_exec($ch);
                    }
                    curl_close($ch);
                    $maxDays = date('t');
                    $data = array(
                        'next_recurring_date' => date('Y-m-d H:i:s', strtotime("+" . $maxDays . " days", strtotime(date('Y-m-d H:i:s')))),
                        'user_id' => $this->session->userdata('user_id'),
                        'created_date' => date('Y-m-d H:i:s')
                    );
                    $data['product'] = 'a';
                    $this->common_model->create("_shipfusion", $data);
                    $data['product'] = 'b';
                    $this->common_model->create("_shipfusion", $data);

                    $address = $user_info['address'] . ',' . $user_info['city'] . ',' . $this->common_model->getStateByStateID($user_info['state']) . ',' . '(' . $user_info['zipcode'] . ')';
                    $file = file_get_contents(APPPATH . "views/mail/payment_garcinia.html");
                    $file = str_replace('{user}', ucwords($this->session->userdata('first_name') . " " . $this->session->userdata('last_name')), $file);
                    $file = str_replace('{transaction_id}', $response_array['transaction_id'], $file);
                    //$file = str_replace('{reference_id}', $response->xml->subscriptionId, $file);
                    $file = str_replace('{transaction_status}', $msg, $file);
                    $file = str_replace('{path}', base_url('assets'), $file);
                    $file = str_replace('{address}', $address, $file);
                    $file = str_replace('{price}', $this->session->userdata['shiping_amount'], $file);

                    $to = $this->session->userdata('email_address');
                    $sub = 'Precisiongarcinia.com Order Receipt #' . $response_array['transaction_id'];

                    $headers = "From: PRECISION VITALITY <donotreply@precisionvitality.com>\r\n";
                    $headers.= "MIME-Version: 1.0" . "\r\n";
                    $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
                    //$headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";                    
                    mail($to, $sub, $file, $headers);

                    $file_colonvex = file_get_contents(APPPATH . "views/mail/payment_colonvex.html");
                    $file_colonvex = str_replace('{user}', ucwords($this->session->userdata('first_name') . " " . $this->session->userdata('last_name')), $file_colonvex);
                    $file_colonvex = str_replace('{transaction_id}', $response_array['transaction_id'], $file_colonvex);
                    //$file_colonvex = str_replace('{reference_id}', $response->xml->subscriptionId, $file_colonvex);
                    $file_colonvex = str_replace('{transaction_status}', $msg, $file_colonvex);
                    $file_colonvex = str_replace('{path}', base_url('assets'), $file_colonvex);
                    $file_colonvex = str_replace('{address}', $address, $file_colonvex);
                    $file_colonvex = str_replace('{price}', $this->session->userdata['shiping_amount'], $file_colonvex);
                    $sub1 = 'Precisioncleanse.com Order Receipt #' . $response_array['transaction_id'];
                    mail($to, $sub1, $file_colonvex, $headers);
                    //destroy session                    
                    $this->session->sess_destroy();
                    $path = "receipt";
                } else if (!empty($response_array['error']) && $response_array['error'] == "1") {
                    $posted_data["payment_status"] = "Pending";
                    $msg = $response_array['response_reason_text'];
                    $path = "check";
                    $file = file_get_contents(APPPATH . "views/mail/payment_error.html");
                    $file = str_replace('{customer_name}', ucwords($this->session->userdata('first_name') . " " . $this->session->userdata('last_name')), $file);
                    $to = $this->session->userdata('email_address');
                    $sub = 'Payment Failure (Precisiongarcinia.com)';
                    $headers = "From: PRECISION VITALITY <donotreply@precisionvitality.com>\r\n";
                    $headers.= "MIME-Version: 1.0" . "\r\n";
                    $headers.= "Content-type: text/html; charset=utf-8\r\n";
                    //mail($to, $sub, $file, $headers);

                    $this->session->set_flashdata('msg', $msg);
                    $this->session->set_flashdata('flag-msg', "error");
                } else if (!empty($response_array['declined']) && $response_array['declined'] == "1") {
                    $msg = $response_array['response_reason_text'];
                    $posted_data["payment_status"] = "Rejected";
                    $path = "check";
                    $file = file_get_contents(APPPATH . "views/mail/payment_error.html");
                    $file = str_replace('{customer_name}', ucwords($this->session->userdata('first_name') . " " . $this->session->userdata('last_name')), $file);
                    $to = $this->session->userdata('email_address');
                    $sub = 'Payment Failure (Precisiongarcinia.com)';
                    $headers = "From: PRECISION VITALITY <donotreply@precisionvitality.com>\r\n";
                    $headers.= "MIME-Version: 1.0" . "\r\n";
                    $headers.= "Content-type: text/html; charset=utf-8\r\n";
                    //mail($to, $sub, $file, $headers);
                    $this->session->set_flashdata('msg', $msg);
                    $this->session->set_flashdata('flag-msg', "error");
                } else {
                    $path = "check";
                    $this->session->set_flashdata('msg', "System Error, Please contact with administrator!");
                    $this->session->set_flashdata('flag-msg', "error");
                }
            } else {
                $file = file_get_contents(APPPATH . "views/mail/payment_error.html");
                $file = str_replace('{customer_name}', ucwords($this->session->userdata('first_name') . " " . $this->session->userdata('last_name')), $file);
                $to = $this->session->userdata('email_address');
                $sub = 'Payment Failure (Precisiongarcinia.com)';
                $headers = "From: PRECISION VITALITY <donotreply@precisionvitality.com>\r\n";
                $headers.= "MIME-Version: 1.0" . "\r\n";
                $headers.= "Content-type: text/html; charset=utf-8\r\n";
                //mail($to, $sub, $file, $headers);
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
        $this->common_model->update("savin_users", array('coupon_status' => '1'), array('id' => $user_id));
        $this->session->set_userdata('shiping_amount', "1.95");
        echo '1';
    }

    public function mail() {
        $this->load->view('mail/payment_garcinia');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */