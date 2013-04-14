<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery extends CI_Controller {

	function __construct()
 	{
		parent::__construct();
 	}

	function index()
	{
	}

        function request()
        {
                $this->load->helper(array('form'));
                $this->load->view('templates/header');
		$this->load->view('delivery_request_form');
                $this->load->view('templates/footer');
        }
        
        function sendRequest()
        {
            //get post data
            $shopAddr = $this->input->post('shopAddr');
            $pickupTime = $this->input->post('pickupTime');
            $deliveryAddr = $this->input->post('deliveryAddr');
            $deliveryTime = $this->input->post('deliveryTime');
            //save request to db
            $this->load->model('request');
            $this->request->create($shopAddr, $pickupTime, $deliveryAddr, $deliveryTime);
            
            //get list of esl's
            $this->load->model('user');
            $esls = $this->user->getAllEsls();
            foreach ($esls as $e)
            {
                //make post request
                /*$this->curl->post($e, array('_name' => 'delivery_ready',
                                            '_domain' => 'rfq',
                                            'shopAddr' => $shopAddr,
                                            'pickupTime' => $pickupTime,
                                            'deliveryAddr' => $deliveryAddr,
                                            'deliveryTime' => $deliveryTime));*/
                $fields_str = '_name' => 'delivery_ready', '_domain' => 'rfq', 'shopAddr='.$shopAddr.'&pickupTime='.$pickupTime.'&deliveryAddr='.$deliveryAddr.'&deliveryTime='.$deliveryTime;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $e['esl']);
                curl_setopt($ch, CURLOPT_POST, 6);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_exec($ch);
                curl_close($ch);
            }
            
            //redirect to list of requests
            //redirect('home');
            //header("Location: ".site_url().'home');
            //exit;
        }
        
        function viewall()
        {
            $this->load->model('request');
            $data['requests'] = $this->request->allOpen();
            
            $this->load->view('templates/header');
            $this->load->view('list_open_requests', $data);
            $this->load->view('templates/footer');
        }

?>