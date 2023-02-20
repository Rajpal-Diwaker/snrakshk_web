<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
/*
 * 
 */
class Supervisor extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('web/Supervisor_model');
	}
	//end fuunction 

	public function changepassword()
	{
		$login = $this->session->userdata('email');
		if ($login != '')
	 	{
		 	$this->load->view('web/header');
			$this->load->view('web/supervisor/change_password');
			$this->load->view('web/footer');
		}
		else
		{
			redirect('admin/Snrakshklog/login');
	 	}
	}
	//===end function

	public function changepasswordprocess()
	{
		$login = $this->session->userdata('email');
		if ($login != '')
	 	{
		 	$post = $this->input->post();
		    if(isset($post['new_pass']) == isset($post['confirm_new_pass']))
		 	{
		 		@$post['old_pass'] = md5($post['old_pass']);
			 	@$post['new_pass'] = md5($post['new_pass']);
			 	$oldpass = $post['old_pass'];
			 	$newpass = $post['new_pass'];
			 	$data = array('oldpass' => $oldpass, 'newpass' => $newpass, 'email' => $login);
			 	$response = $this->Supervisor_model->pass_change($data);
			    if($response == true)
			    {
					echo 1;die;
			    }
			    else
			    {
			   		echo 0;
			    }
			}
			else
			{
				echo "New Password and Confirm Password not matching.";
			}
	 	}
		else
		{
			redirect('admin/Snrakshklog/login');
	 	}
	}
	//===end function

	public function fieldinspectorlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$datass = array('supervisoremail' => $login);
			$response['datas'] = $this->Supervisor_model->fieldinspectorlist($datass);
			$this->load->view('web/header');
			$this->load->view('web/supervisor/fieldinspectorlist',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login'); 
		}
		
	}
	//end function

	public function endisfieldinspector()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$get_status = $this->input->get('status',true);
			$data = array('field_inspector_id'=> $get_id, 'status' => $get_status);
			$response = $this->Supervisor_model->endisfieldinspector($data);
			if ($response) 
			{
				redirect('web/Supervisor/fieldinspectorlist');
			}
			else
			{
				redirect('web/Supervisor/fieldinspectorlist');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function addfieldinspector()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$this->load->view('web/header');
			$this->load->view('web/supervisor/addfieldinspector');
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function 

	public function fieldinspectorprocess()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$post = $this->input->post();
			$postdata = array(
								'full_name' => $post['fullname'],
								'area' => $post['area'],
								'aadhar_number' => $post['aadhar_number'],
								'employee_id' => $post['employee_id'],
								'email' => $post['email'],
								'supervisoremail' => $login, 
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Supervisor_model->fieldinspectorprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Supervisor/addfieldinspector');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Supervisor/addfieldinspector');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Supervisor/addfieldinspector');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editfi()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('field_inspector_id' => $get_id);
			$response['data'] = $this->Supervisor_model->editfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/supervisor/editfi',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editfiprocess()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$post = $this->input->post();
			$response = $this->Supervisor_model->editfiprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Supervisor/editfi?id='.$post['field_inspector_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Supervisor/editfi?id='.$post['field_inspector_id']);
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function viewfi()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('field_inspector_id' => $get_id);
			$response['data'] = $this->Supervisor_model->viewfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/supervisor/viewfi',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function
}