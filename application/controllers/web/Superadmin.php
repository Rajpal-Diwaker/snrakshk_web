<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
require APPPATH . 'third_party/phpmailer/class.phpmailer.php';
require APPPATH . 'libraries/PHPExcel.php';
/*
 * 
 */
class Superadmin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('web/Superadmin_model');
	}
	//end fuunction 

	public function changepassword()
	{
		$login = $this->session->userdata('email');
		if ($login != '')
	 	{
		 	$this->load->view('web/header');
			$this->load->view('web/superadmin/change_password');
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
			 	$response = $this->Superadmin_model->pass_change($data);
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

	public function companyheadlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$response['datas'] = $this->Superadmin_model->companyheadlist();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/companyheadlist',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login'); 
		}
		
	}
	//end function

	public function endiscompanyhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$get_status = $this->input->get('status',true);
			$data = array('company_head_id'=> $get_id, 'status' => $get_status);
			$response = $this->Superadmin_model->endiscompanyhead($data);
			if ($response) 
			{
				redirect('web/Superadmin/companyheadlist');
			}
			else
			{
				redirect('web/Superadmin/companyheadlist');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function addcompanyhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$this->load->view('web/header');
			$this->load->view('web/superadmin/addcompanyhead');
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function 

	public function companyheadprocess()
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
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Superadmin_model->companyheadprocess($postdata);
			if ($response == 1) 
			{	
				$this->session->set_flashdata('message_name', 'Company head added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addcompanyhead');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addcompanyhead');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addcompanyhead');
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editcompanyhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('company_head_id' => $get_id);
			$response['data'] = $this->Superadmin_model->editcompanyhead($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/editcompanyhead',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function editcompanyheadprocess()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$post = $this->input->post();
			$response = $this->Superadmin_model->editcompanyheadprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Company head updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editcompanyhead?id='.$post['company_head_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editcompanyhead?id='.$post['company_head_id']);
			}
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function viewcompanyhead()
	{
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$get_id = $this->input->get('id',true);
			$iddata = array('company_head_id' => $get_id);
			$response['data'] = $this->Superadmin_model->editcompanyhead($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/viewcompanyhead',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function reasonalheadlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$response['datas'] = $this->Superadmin_model->reasonalheadlist();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/reasonalheadlist',$response);
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
			$response = $this->Superadmin_model->endisreasonalhead($data);
			if ($response) 
			{
				redirect('web/Superadmin/reasonalheadlist');
			}
			else
			{
				redirect('web/Superadmin/reasonalheadlist');
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
			$response['companyheads'] = $this->Superadmin_model->companyheads();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/addreasonalhead',$response);
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
								'company_head' => $post['company_head'],
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Superadmin_model->reasonalheadprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Reasonal head added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addreasonalhead');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addreasonalhead');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addreasonalhead');
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
			$response['companyheads'] = $this->Superadmin_model->companyheads();
			$response['data'] = $this->Superadmin_model->editreasonalhead($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/editreasonalhead',$response);
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
			$response = $this->Superadmin_model->editreasonalheadprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Reasonal head updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editreasonalhead?id='.$post['reasonal_head_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editreasonalhead?id='.$post['reasonal_head_id']);
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
			$response['data'] = $this->Superadmin_model->editreasonalhead($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/viewreasonalhead',$response);
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
			$response['datas'] = $this->Superadmin_model->supervisorlist();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/supervisorlist',$response);
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
			$response = $this->Superadmin_model->endissupervisor($data);
			if ($response) 
			{
				redirect('web/Superadmin/supervisorlist');
			}
			else
			{
				redirect('web/Superadmin/supervisorlist');
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
			$response['companyheads'] = $this->Superadmin_model->companyheads();
			$response['reasonalheads'] = $this->Superadmin_model->reasonalheads();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/addsupervisor',$response);
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
								'company_head' => $post['company_head'],
								'reasonal_head' => $post['reasonal_head'],
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Superadmin_model->supervisorprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Supervisor added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addsupervisor');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addsupervisor');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addsupervisor');
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
			$response['companyheads'] = $this->Superadmin_model->companyheads();
			$response['reasonalheads'] = $this->Superadmin_model->reasonalheads();
			$response['data'] = $this->Superadmin_model->editsupervisor($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/editsupervisor',$response);
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
			$response = $this->Superadmin_model->editsupervisorprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Supervisor updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editsupervisor?id='.$post['supervisor_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editsupervisor?id='.$post['supervisor_id']);
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
			$response['data'] = $this->Superadmin_model->editsupervisor($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/viewsupervisor',$response);
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
			$response['datas'] = $this->Superadmin_model->fieldinspectorlist();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/fieldinspectorlist',$response);
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
			$response = $this->Superadmin_model->endisfieldinspector($data);
			if ($response) 
			{
				redirect('web/Superadmin/fieldinspectorlist');
			}
			else
			{
				redirect('web/Superadmin/fieldinspectorlist');
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
			$response['companyheads'] = $this->Superadmin_model->companyheads();
			$response['reasonalheads'] = $this->Superadmin_model->reasonalheads();
			$response['supervisors'] = $this->Superadmin_model->supervisors();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/addfieldinspector',$response);
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
								'company_head' => $post['company_head'],
								'reasonal_head' => $post['reasonal_head'],
								'supervisor' => $post['supervisor'],
								'email' => $post['email'],
								'password' => md5($post['password']),
								'mailpass' => $post['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$response = $this->Superadmin_model->fieldinspectorprocess($postdata);
			if ($response == 1) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector added successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addfieldinspector');
			}
			else if ($response == 2) 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addfieldinspector');
			}
			else if($response == 0)
			{
				$this->session->set_flashdata('message_name', 'Email already exist.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/addfieldinspector');
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
			$response['companyheads'] = $this->Superadmin_model->companyheads();
			$response['reasonalheads'] = $this->Superadmin_model->reasonalheads();
			$response['supervisors'] = $this->Superadmin_model->supervisors();
			$response['data'] = $this->Superadmin_model->editfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/editfi',$response);
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
			$response = $this->Superadmin_model->editfiprocess($post);
			if ($response) 
			{
				$this->session->set_flashdata('message_name', 'Field Inspector updated successfully.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editfi?id='.$post['field_inspector_id']);
			}
			else 
			{
				$this->session->set_flashdata('message_name', 'Please try again.');
				// After that you need to used redirect function instead of load view such as 
		        redirect('web/Superadmin/editfi?id='.$post['field_inspector_id']);
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
			$response['data'] = $this->Superadmin_model->viewfi($iddata);
			$this->load->view('web/header');
			$this->load->view('web/superadmin/viewfi',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login');
		}
	}
	//end function

	public function consumerlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$response['datas'] = $this->Superadmin_model->consumerlist();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/consumerlist',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login'); 
		}
		
	}
	//end function

	public function mergeConsumer()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$this->Superadmin_model->mergeConsumer();
			redirect('web/Superadmin/Importedconsumerlist'); 
		}
		else
		{
			redirect('web/Snrakshklog/login'); 
		}
		
	}
	//end function

	public function Importedconsumerlist()
	{	
		$login = $this->session->userdata('email');
		$admintype = $this->session->userdata('admintype');
		if ($login != '' && $admintype != '') {
			$response['datas'] = $this->Superadmin_model->Importedconsumerlist();
			$this->load->view('web/header');
			$this->load->view('web/superadmin/Importedconsumerlist',$response);
			$this->load->view('web/footer');
		}
		else
		{
			redirect('web/Snrakshklog/login'); 
		}
		
	}
	//end function

public function consumerImport()
	{
		if(isset($_FILES["file"]["name"]))
		{			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
				$DIST_CODE = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$CONS_NO = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$CONS_ID = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$CONS_NAME = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$ADDRESS = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				$CONS_CITY = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$AREA_NAME = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				$MOBILE = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$data[] = array(
							'DIST_CODE'  => $DIST_CODE,
							'CONS_NO'   => $CONS_NO,
							'CONS_ID'    => $CONS_ID,
							'CONS_NAME'  => $CONS_NAME,
							'ADDRESS'   => $ADDRESS,
							'CONS_CITY'   => $CONS_CITY,
							'AREA_NAME'   => $AREA_NAME,
							'MOBILE'   => $MOBILE,
						);
				}		
			}	
		$this->Superadmin_model->consumerImport($data);
		redirect('web/Superadmin/consumerlist');
		} 
	}
}