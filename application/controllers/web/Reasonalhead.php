<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
/*
 * 
 */
class Reasonalhead extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('web/Reasonalhead_model');
	}
	//end fuunction 

	public function changepassword()
	{
		$login = $this->session->userdata('email');
		if ($login != '')
	 	{
		 	$this->load->view('web/header');
			$this->load->view('web/reasonalhead/change_password');
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
			 	$response = $this->Reasonalhead_model->pass_change($data);
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

	public function supervisorlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$response['datas'] = $this->Reasonalhead_model->supervisorlist($login);
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/supervisorlist',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login'); 
		}
	}
	//end function

	public function endissupervisor()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$get_status = $this->input->get('status',true);
			$data = array('supervisor_id'=> $get_id, 'status' => $get_status);
			$response = $this->Reasonalhead_model->endissupervisor($data);
			if ($response) 
			{
				redirect('web/Reasonalhead/supervisorlist');
			}
			else
			{
				redirect('web/Reasonalhead/supervisorlist');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function addsupervisor()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/addsupervisor');
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function 

	public function supervisorprocess()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$post = $this->input->post();
			$postdata = array(
								'full_name' => $post['fullname'],
								'address' => $post['address'],
								'aadhar_number' => $post['aadhar_number'],
								'employee_id' => $post['employee_id'],
								'reasonalheademail' => $login,
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Reasonalhead_model->supervisorprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Supervisor added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/addsupervisor');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/addsupervisor');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/addsupervisor');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editsupervisor()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('supervisor_id' => $get_id);
			$response['data'] = $this->Reasonalhead_model->editsupervisor($iddata);
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/editsupervisor',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editsupervisorprocess()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$post = $this->input->post();
			$response = $this->Reasonalhead_model->editsupervisorprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Supervisor updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/editsupervisor?id='.$post['supervisor_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/editsupervisor?id='.$post['supervisor_id']);
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function viewsupervisor()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('supervisor_id' => $get_id);
			$response['data'] = $this->Reasonalhead_model->editsupervisor($iddata);
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/viewsupervisor',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function fieldinspectorlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');		
		if ($login != '' && $admintype != '') {
			$datass = array('reasonalheademail' => $login);
			$response['datas'] = $this->Reasonalhead_model->fieldinspectorlist($datass);
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/fieldinspectorlist',$response);
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
			$response = $this->Reasonalhead_model->endisfieldinspector($data);
			if ($response) 
			{
				redirect('web/Reasonalhead/fieldinspectorlist');
			}
			else
			{
				redirect('web/Reasonalhead/fieldinspectorlist');
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
			$datass = array('reasonalheademail' => $login);
			$response['supervisors'] = $this->Reasonalhead_model->supervisors($datass);
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/addfieldinspector',$response);
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
								'reasonalheademail' => $login,
								'supervisor' => $post['supervisor'],
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
								
			$response = $this->Reasonalhead_model->fieldinspectorprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/addfieldinspector');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/addfieldinspector');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/addfieldinspector');
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
			$datass = array('reasonalheademail' => $login);
			$response['supervisors'] = $this->Reasonalhead_model->supervisors($datass);
			$response['data'] = $this->Reasonalhead_model->editfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/editfi',$response);
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
			$response = $this->Reasonalhead_model->editfiprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/editfi?id='.$post['field_inspector_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Reasonalhead/editfi?id='.$post['field_inspector_id']);
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
			$response['data'] = $this->Reasonalhead_model->viewfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/reasonalhead/viewfi',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function
}