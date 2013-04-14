<?php

class Pages extends CI_Controller {

	public function __construct() {
	        parent::__construct();
	}	
	
	public function view($page = 'home', $user = null)
	{
		if ( ! file_exists('application/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}

		$this->load->helper('form');

		//check login
		if ($user === null)
		{
			$data['title'] = 'Login';			

			$this->load->view('templates/header', $data);
			$this->load->view('pages/login', $data);
			$this->load->view('templates/footer', $data);	
		}
		else
		{
			$data['title'] = ucfirst($page); // Capitalize the first letter
	
			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer', $data);
		}
	}

	public function login()
	{
		$username = $this->input->post('username');
		
		if ($username === 'admin')
		{
			$this->load->view('templates/header', $data);
			$this->load->view('pages/admin_homepage', $data);
			$this->load->view('templates/footer', $data);
		}
		else
		{
			try
			{			
				//$this->load->database();
				$db = new PDO('sqlite:./application/db/flowershop');
				$result = $db->query('Select * FROM Users;');
				$data['result'] = $result;
				//$query = $this->db->query('.tables');
				//$query = $this->db->get('Users');
				//$row = $query->row_array();
				//$data['pw'] = $row['password'];
				//$data['pw'] = 'nope';
				$file = file_get_contents('./application/files/users.json');
				$json = json_decode($file, true);
				$data['json'] = $json;
				//var_dump($json['users']['username']);			
			}
			catch (Exception $e)
			{
				show_error("could not load database: " + $e);
			}

			//$this->load->model('userModel');
			//if ($this->userModel->checkExists($data['username'], $json))
			$found = false;
			foreach ($json['users'] as $user)
			{
				if ($username == $user['username'])
				{
					$found = true;
					$data['user'] = $user;
				}
			}

			if ($found)
			{			
				$this->load->view('templates/header', $data);
				$this->load->view('pages/homepage', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				$this->load->helper('form');				
				$this->load->view('templates/header', $data);
				$this->load->view('pages/register', $data);
				$this->load->view('templates/footer', $data);
			}
		}
	}

	public function esl($userId = 0, $esl = null)
	{
		$this->load->helper('form');				
		$this->load->view('templates/header', $data);
		$this->load->view('pages/setEsl', $data);
		$this->load->view('templates/footer', $data);		
	}

	public function setEsl($userId = 0, $esl = '') 
	{
		$file = file_get_contents('./application/files/users.json');
		$json = json_decode($file, true);		

		foreach ($json['users'] as $user)
		{
			if ($userId == $user['id'])
			{
				$user['esl'] = $esl;
				$data['user'] = $user;
			}
		}

		$newJson = json_encode($json);
		file_put_contents('./application/files/users.json', $newJson);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/homepage', $data);
		$this->load->view('templates/footer', $data);				
	}
}
