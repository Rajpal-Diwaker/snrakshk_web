<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
/*
 * 
 */
class Companyhead extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('web/Companyhead_model');
	}
	//end fuunction 

	public function changepassword()
	{
		$login = $this->session->userdata('email');
		if ($login != '')
	 	{
		 	$this->load->view('web/header');
			$this->load->view('web/companyhead/change_password');
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
			 	$response = $this->Companyhead_model->pass_change($data);
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

	public function reasonalheadlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$datass = array('companyheademail' => $login);
			$response['datas'] = $this->Companyhead_model->reasonalheadlist($datass);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/reasonalheadlist',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login'); 
		}
		
	}
	//end function

	public function endisreasonalhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$get_status = $this->input->get('status',true);
			$data = array('reasonal_head_id'=> $get_id, 'status' => $get_status);
			$response = $this->Companyhead_model->endisreasonalhead($data);
			if ($response) 
			{
				redirect('web/Companyhead/reasonalheadlist');
			}
			else
			{
				redirect('web/Companyhead/reasonalheadlist');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function addreasonalhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$this->load->view('web/header');
			$this->load->view('web/companyhead/addreasonalhead');
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function 

	public function resonalheadprocess()
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
								'companyheademail' => $login,
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Companyhead_model->reasonalheadprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Reasonal head added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addreasonalhead');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addreasonalhead');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addreasonalhead');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editreasonalhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('reasonal_head_id' => $get_id);
			$response['data'] = $this->Companyhead_model->editreasonalhead($iddata);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/editreasonalhead',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editreasonalheadprocess()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$post = $this->input->post();
			$response = $this->Companyhead_model->editreasonalheadprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Reasonal head updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/editreasonalhead?id='.$post['reasonal_head_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/editreasonalhead?id='.$post['reasonal_head_id']);
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function viewreasonalhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('reasonal_head_id' => $get_id);
			$response['data'] = $this->Companyhead_model->editreasonalhead($iddata);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/viewreasonalhead',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function supervisorlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$datass = array('companyheademail' => $login);
			$response['datas'] = $this->Companyhead_model->supervisorlist($datass);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/supervisorlist',$response);
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
			$response = $this->Companyhead_model->endissupervisor($data);
			if ($response) 
			{
				redirect('web/Companyhead/supervisorlist');
			}
			else
			{
				redirect('web/Companyhead/supervisorlist');
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
			$datass = array('companyheademail' => $login);
			$response['reasonalheads'] = $this->Companyhead_model->reasonalheads($datass);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/addsupervisor',$response);
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
								'companyheademail' => $login,
								'reasonal_head' => $post['reasonal_head'],
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Companyhead_model->supervisorprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Supervisor added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addsupervisor');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addsupervisor');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addsupervisor');
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
			$datass = array('companyheademail' => $login);
			$response['reasonalheads'] = $this->Companyhead_model->reasonalheads($datass);
			$response['data'] = $this->Companyhead_model->editsupervisor($iddata);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/editsupervisor',$response);
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
			$response = $this->Companyhead_model->editsupervisorprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Supervisor updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/editsupervisor?id='.$post['supervisor_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/editsupervisor?id='.$post['supervisor_id']);
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
			$response['data'] = $this->Companyhead_model->editsupervisor($iddata);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/viewsupervisor',$response);
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
			$datass = array('companyheademail' => $login);
			$response['datas'] = $this->Companyhead_model->fieldinspectorlist($datass);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/fieldinspectorlist',$response);
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
			$response = $this->Companyhead_model->endisfieldinspector($data);
			if ($response) 
			{
				redirect('web/Companyhead/fieldinspectorlist');
			}
			else
			{
				redirect('web/Companyhead/fieldinspectorlist');
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
			$datass = array('companyheademail' => $login);
			$response['reasonalheads'] = $this->Companyhead_model->reasonalheads($datass);
			$response['supervisors'] = $this->Companyhead_model->supervisors($datass);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/addfieldinspector',$response);
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
								'companyheademail' => $login,
								'reasonal_head' => $post['reasonal_head'],
								'supervisor' => $post['supervisor'],
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Companyhead_model->fieldinspectorprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addfieldinspector');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addfieldinspector');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/addfieldinspector');
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
			$datass = array('companyheademail' => $login);
			$response['reasonalheads'] = $this->Companyhead_model->reasonalheads($datass);
			$response['supervisors'] = $this->Companyhead_model->supervisors($datass);
			$response['data'] = $this->Companyhead_model->editfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/editfi',$response);
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
			$response = $this->Companyhead_model->editfiprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/editfi?id='.$post['field_inspector_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Companyhead/editfi?id='.$post['field_inspector_id']);
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
			$response['data'] = $this->Companyhead_model->viewfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/companyhead/viewfi',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function
}