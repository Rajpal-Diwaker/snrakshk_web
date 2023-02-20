<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
require APPPATH . 'third_party/phpmailer/class.phpmailer.php';
/*
 * 
 */
class Snrakshklog extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('web/Login_model');
		
	}
	//end fuunction 

	public function login()
	{	
		if($this->input->method() == 'get'){
			$this->load->view('web/login');
		}
		
	}
	//===end function

	public function loginprocess()
	{
	 	$post = $this->input->post();
	 	unset($post['submit']);
	 	$post['password'] = md5($post['password']);
		$response = $this->Login_model->login($post);
		if($response)
		{	
			$this->session->set_userdata('admintype',$response['admintype']);
		    $this->session->set_userdata('email',$response['email']);
		    echo $response['admintype'];die;
		}
		else
		{
			echo 0;
		}	
	}
	//end function

	public function forgot()
	{
		if($this->input->method() == 'get'){
			$this->load->view('web/forgot');
		}
	}
	//end function

	public function forgotprocess()
	{
		$post = $this->input->post();
	 	unset($post['submit']);
	 	$response = $this->Login_model->forgotprocess($post);
		if($response == 1)
		{	
			echo 1;
		}
		else
		{
			echo 0;
		}	
	}
	//end function

	public function changepassword()
	{
	 	$this->load->view('web/resetpassword');
	} 
	//===end function

	public function reset()
	{	
		$id = $this->uri->segment(4);
		$uid = convert_uudecode(base64_decode($id));
		$admintypeid = $this->uri->segment(5);
		$admintype = convert_uudecode(base64_decode($admintypeid));

		$post = $this->input->post();
		@$post['newpass'] = md5($post['newpass']);
		$data = array(	
						'admintype' => $admintype,
						'uid' => $uid, 
						'password' => (isset($post['newpass']) && $post['newpass'] != "" ? $post['newpass'] : "")
						);

		$response = $this->Login_model->changepassword($data);

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

	public function logout()
	{	
		$this->session->unset_userdata('admintype');
		$this->session->unset_userdata('email');
		redirect('web/Snrakshklog/login'); 
	}
	//end function
}