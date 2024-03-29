<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rfq extends CI_Controller {

	function __construct()
 	{
		parent::__construct();
 	}

	function index($uid = '')
	{
            $name = $this->input->post('_name');
            $domain = $this->input->post('_domain');

            if ($domain == 'rfq')
            {
                if ($name == 'delivery_ready')
                {
                    //get user with uid
                    $this->load->model('user');
                    $user = $this->user->getUserByEsl($uid);

                    //get n miles and location from event body
                    $loc = $this->user->getLocation($user);

                    //if within n miles (for this purpose, half a point)
                    $shopCoords = $this->input->post('shopCoords');
                    $shopCoordsArr = explode(',', $shopCoords);

                    $latitude = $shopCoordsArr[0];
                    $longitude = $shopCoordsArr[1];
                    $this->load->model('request');
                    $distance = $this->request->calcDistance($latitude, $longitude, $loc['lat'], $loc['long']);

                    $id = $this->input->post('id');
                    $deliveryAddr = $this->input->post('deliveryAddr');
                    $deliveryTime = $this->input->post('deliveryTime');
                    $pickupTime = $this->input->post('pickupTime');
                    $shopName = $this->input->post('shopName');
                    $shopEsl = $this->input->post('shopEsl');

                    if ($distance < 0.5)
                    {
                        //submit bid to flower shop
                        $this->makeBid($user, $id, $shopEsl, $deliveryTime, $deliveryAddr, $pickupTime);
                    }
                    else
                    {
                        $this->user->saveRequest($id, $shopEsl, $deliveryTime, $deliveryAddr, $pickupTime);

                        //text driver with delivery request
                        $details = "Delivery request. P: " . $pickupTime . " A: " . $deliveryAddr . " D: " . $deliveryTime;
                        $this->load->library('twilio');
                        $this->twilio->sms(18016573680, 18016806793, $details);
                    }
                }
                else if ($name == 'bid_awarded')
                {
                    $driverName = $this->input->post('driverName');
                    $deliveryId = $this->input->post('deliveryId');

                    $this->load->model('request');
                    $this->request->bidAccepted($driverName, $deliveryId);
                }
            }
	}

        function makeBid($username, $id, $fs_esl, $deliveryTime, $deliveryAddr, $pickupTime)
        {
            $this->load->model('request');
            $this->request->makeBid($username, $id, $fs_esl, $deliveryTime, $deliveryAddr, $pickupTime);

            $this->load->model('user');
            $name = $this->user->getName($username);
            $rate = $this->user->getRate($username);

            $estimate = strtotime($deliveryTime) + 1800;

            //send bid to flowershop
            $fields_str = '_name=bid_available&_domain=rfq&driverName='.$username.'&deliveryId='.$id.'&estDeliveryTime='.$estimate.'&rate='.$rate;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fs_esl);
            curl_setopt($ch, CURLOPT_POST, 6);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            curl_close($ch);

            //text driver with bid details
            $bidDetails = $name . ", you have made a bid for delivery " . $id . ". If accepted, pickup at " . $pickupTime . ".";
            $this->load->library('twilio');
            $this->twilio->sms(18016573680, 18016806793, $bidDetails);
        }

        function smsReply()
        {
            $from = $this->input->post('From');
            $body = $this->input->post('Body');

            if (strtolower($body) == "bid anyway")
            {
                $this->load->model('user');
                $username = $this->user->getUserByPhone(str_replace('+', '', $from));
                $this->load->model('request');
                $deliveryId = $this->request->getReqDeliveryId();
                $shopEsl = $this->request->getReqShopEsl();
                $deliveryTime = $this->request->getReqDeliveryTime();
                $deliveryAddr = $this->request->getReqDeliveryAddr();
                $pickupTime = $this->request->getReqPickupTime();
                $this->makeBid($username, $deliveryId, $shopEsl, $deliveryTime, $deliveryAddr, $pickupTime);
            }

            $this->load->view('sms');
        }

        function delivered($deliveryId = '')
        {
            $this->load->model('request');
            $esl = $this->request->getShopEslByRequest($deliveryId);

            $session_data = $this->session->userdata('logged_in');
            $username = $session_data['username'];
            $this->request->delivered($username, $deliveryId);

            $fields_str = '_name=complete&_domain=delivery&deliveryId='.$deliveryId;
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $esl);
                        curl_setopt($ch, CURLOPT_POST, 3);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_exec($ch);
                        curl_close($ch);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'http://students.cs.byu.edu/~kdevenis/proj4/guild/proj4-guild/CodeIgniter_2.1.3/index.php/event/consume');
                        curl_setopt($ch, CURLOPT_POST, 3);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_exec($ch);
                        curl_close($ch);
        }
}

?>