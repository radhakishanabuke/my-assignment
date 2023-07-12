<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	function __construct() {
        parent::__construct();
	$this->load->model('insert_model');

    }

	public function index()
	{
		$this->load->view('header');
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}

public function dashboard()
	{
		$this->load->view('dashboard');
		
	}

	function savedata(){
if(isset($_REQUEST['submit'])){
		$data = array(
			'name'=>$this->input->post('username'),
			'phone'=>$this->input->post('phoneNumber'),
			'email'=>$this->input->post('Emailid'),
			'password'=>$this->input->post('password'),
			'conformkey' => rand()
		);
		$this->insert_model->saverecords($data);
		$msg = "Registation EMail";
		$this->insert_model->do_email($this->input->post('Emailid'),'Confirm Registation',$msg);
		$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Registration completed</div>');
		redirect('welcome','refresh');
		}
	}

function verify($hash=NULL)
    {
        if ($this->insert_model->verifyEmailID($hash))
        {
            $this->session->set_flashdata('message','<div class="alert alert-success text-center">Your Email Address is successfully verified! Please login to access your account!</div>');
            redirect('welcome');
        }
        else
        {
            $this->session->set_flashdata('message','<div class="alert alert-danger text-center">Sorry! There is error verifying your Email Address!</div>');
            redirect('welcome');
        }
    }

function doLogin(){
    	$email = $this->input->post('email');
    	$password = $this->input->post('password');
		if($email != "" && $password !=""){
    		$username = $email;
	        $password = $password;
	       
	        $result = $this->insert_model->check_login('user', $username, $password);
	     	//echo $this->db->last_query();
	        $data = array();
			
	        if($result)    
	        {
	        	$data['user_name'] = $result->name;
	            $data['user_id'] = $result->id;
	           
	            $this->session->set_userdata($data);
			redirect('dash');	
	        }
        } else {
        	echo false;
        }
    }


function logout()
	{
		$this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_id');
        
        redirect(base_url(), 'refresh');
	}

	
}
   