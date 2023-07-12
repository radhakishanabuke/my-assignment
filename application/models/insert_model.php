<?php

class insert_model extends CI_Model{
	
function __construct()
    {
        parent::__construct();
$this->load->library('email');
    }

    function  saverecords($data){
        $this->db->insert('user',$data);
        
    }

function verifyEmailID($key)
    {
        $data = array('status' => 1);
        $this->db->where('md5(email)', $key);
        $this->db->update('user', $data);
	$this->session->set_flashdata('message', 'Account Verification Done');
		redirect('welcome','refresh');
    }

function check_login($table, $username, $password)
    {
        $this->db->select('*');
        $this->db->from($table);		
        $this->db->where('email', $username);
       
        $this->db->where('password', $password);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }


    function do_email($to_email = '', $subject = '', $message = '') {
         $from_email = 'yourgmail@gmail.com'; //change this to yours
        $subject = 'Verify Your Email Address';
        $message = "Dear User,<br /><br />Please click on the below activation link to verify your email address.<br /><br />". base_url()."/user/verify/" . md5($to_email) . "<br /><br /><br />Thanks<br />ABC Team";
        
        //configure email settings
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com'; //smtp host name
        $config['smtp_port'] = '465'; //smtp port number
        $config['smtp_user'] = $from_email;
        $config['smtp_pass'] = '********'; //$from_email password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->email->initialize($config);
        
        //send mail
        $this->email->from($from_email, 'ABC TEAM');
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }
}
?>
