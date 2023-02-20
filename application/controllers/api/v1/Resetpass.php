<?php
defined('BASEPATH') OR exit('No direct script access allowed.');

class Resetpass extends CI_Controller
{

public function __construct()
{
parent::__construct();
$this->data = $this->input->post();
$this->load->helper(array('form', 'url'));
$this->load->library('email');
$this->load->model('v1/Forgot_model');
}

public function changepassword()
{
 	$this->load->view('reset_password');
} 
//===end function

public function reset()
{	
	$id = $this->uri->segment(5);
	$uid = convert_uudecode(base64_decode($id));

	$post = $this->input->post();
	@$post['newpass'] = md5($post['newpass']);
	$data = array(
					'field_inspector_id' => $uid, 
					'password' => (isset($post['newpass']) && $post['newpass'] != "" ? $post['newpass'] : "")
					);

	$response = $this->Forgot_model->changepassword($data);

	if ($response == 1) 
	{	
		echo 1;
	}
	else
	{
		echo 0;
	}
}
//===end function 

}