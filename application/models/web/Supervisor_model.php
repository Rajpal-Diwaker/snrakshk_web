<?php
defined('BASEPATH') OR exit('No direct script access allowed.');
/**
 * 
 */
class Supervisor_model extends CI_Model
{
	public function pass_change($array){

		$data = array('password' => $array['newpass']);
		$this->db->where('password', $array['oldpass']);
		$this->db->where('email',$array['email']);
		$this->db->update('supervisor',$data);
		$affected_rows = $this->db->affected_rows('supervisor');
		if($affected_rows > 0)
		{
			return true;die;
		}
		else
		{
			return false;die;
		}
	}
	//end function

	public function fieldinspectorlist($array)
	{	
		$supervisordata = $this->db->select('supervisor_id')
								   ->where('email',$array['supervisoremail'])
								   ->get('supervisor');
		$supervisorId = $supervisordata->result_array();
		$query = $this->db->select('fi.field_inspector_id, fi.full_name as field_inspector_name, fi.status, fi.area')
						  ->from('field_inspectors as fi')
						  ->where('supervisor',$supervisorId[0]['supervisor_id'])
						  ->get();
		$data = $query->result_array();
		
		if ($data) 
		{	
			foreach ($data as $key => $value) 
			{
				//assigned consumer
				$ac = $this->db->select('count(ac.field_inspector_id) as total_consumer')
							   ->from('assigned_consumer as ac')
							   ->where('ac.field_inspector_id',$value['field_inspector_id'])
							   ->get();
				$acdata = $ac->result_array();
				if (isset($acdata[0])) 
				{
					$data[$key]['total_consumer'] = $acdata[0]['total_consumer'];
				}
				else
				{
					$data[$key]['total_consumer'] = "0";	
				} 

				$tc = $this->db->select('count(ac.field_inspector_id) as completed')
							   ->from('assigned_consumer as ac')
							   ->where('ac.status','2')
							   ->where('ac.field_inspector_id',$value['field_inspector_id'])
							   ->get();
				$tcdata = $tc->result_array();
				if (isset($acdata[0])) 
				{
					$data[$key]['completed'] = $tcdata[0]['completed'];
				}
				else
				{
					$data[$key]['completed'] = "0";	
				}
			}
			return $data;
		}
	}
	//end function

	public function endisfieldinspector($array)
	{	
		$update = $this->db->set('status',$array['status'])
						   ->where('field_inspector_id',$array['field_inspector_id'])
						   ->update('field_inspectors');
		if ($update) 
		{
			return 1;
		}
	}
	//end function

	public function editfi($array)
	{
		$query = $this->db->select('fi.*')
						  ->from('field_inspectors as fi')
						  ->where('field_inspector_id',$array['field_inspector_id'])
						  ->get();
		$data = $query->result_array();
		if ($data) 
		{
			return $data[0];
		}
	}
	//end function

	public function editfiprocess($array)
	{	
		 $userdata = array(
		 					'full_name' => $array['full_name'], 
		 					'area' => $array['area'], 
		 					'aadhar_number' => $array['aadhar_number'], 
		 					'employee_id' => $array['employee_id'], 
		 					'email' => $array['email']
		 					);
		$update = $this->db->set($userdata)
						   ->where('field_inspector_id',$array['field_inspector_id'])
						   ->update('field_inspectors');
		if ($update) 
		{
			$query = $this->db->select('fi.*')
							  ->from('field_inspectors as fi')
							  ->where('field_inspector_id',$array['field_inspector_id'])
							  ->get();
			$data = $query->result_array();
			return $data[0];
		}
	}
	//end function

	public function fieldinspectorprocess($array)
	{	
		$ch = $this->db->select('*')
					   ->where('email',$array['email'])
					   ->get('company_head');
		$num_rows_ch = $ch->num_rows();

		$rh = $this->db->select('*')
					   ->where('email',$array['email'])
					   ->get('reasonal_head');
		$num_rows_rh = $rh->num_rows();

		$s = $this->db->select('*')
					   ->where('email',$array['email'])
					   ->get('supervisor');
		$num_rows_s = $s->num_rows(); 

		$fi = $this->db->select('*')
					   ->where('email',$array['email'])
					   ->get('field_inspectors');
		$num_rows_fi = $fi->num_rows();

		if ($num_rows_fi > 0 || $num_rows_s > 0 || $num_rows_rh > 0 || $num_rows_ch > 0) 
		{	
			return 0;
		}
		else
		{	
			$query = $this->db->select('supervisor_id, company_head, reasonal_head')
							  ->where('email',$array['supervisoremail'])
							  ->get('supervisor');
			$data = $query->result_array();
			$array['company_head'] = $data[0]['company_head'];
			$array['reasonal_head'] = $data[0]['reasonal_head'];
			$array['supervisor'] = $data[0]['supervisor_id'];
			unset($array['supervisoremail']);
			$postdata = array(
								'full_name' => $array['fullname'],
								'area' => $array['area'],
								'aadhar_number' => $array['aadhar_number'],
								'employee_id' => $array['employee_id'],
								'email' => $array['email'],
								'password' => $array['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$insert = $this->db->insert('field_inspectors',$postdata);
			$insert_id = $this->db->insert_id();
			if ($insert) 
			{	
				$query = $this->db->select('email')
								  ->where('field_inspector_id',$insert_id)
								  ->get('field_inspectors');
				$data = $query->result_array();
				//send email
				$email = 'snrakshk@gmail.com' ;
				$name = 'SNRAKSHK App';
				$message = '<html>
							<head>
							<title>Login Credentials</title>
							</head>
							<body>
							<p>Dear User</p>
							<p>Your Username : '.$data[0]['email'].' and Password : '.$array['mailpass'].'.</p>
							<p>Please use these credentails for login.</p>
							<p> </p>
						 	<p>Kind regards,</p>
						 	<p>SNRAKSHK App</p>
							</body>
							</html>';
				
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPSecure = 'ssl';
				$mail->Host = 'smtp.gmail.com';  // specify main and backup server
				$mail->Port = '465';
				$mail->SMTPAuth = true;     // turn on SMTP authentication
				$mail->Username = "snrakshk@gmail.com";  // SMTP username
				$mail->Password = "snrakshk@123"; // SMTP password
				$mail->From = $email;
				$mail->FromName = $name;
				$mail->AddAddress($data[0]['email']);
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
				$mail->Subject = "SNRAKSHK App - Login Credentials";
				$mail->Body    = $message;
				$mail->AltBody = $message;
				$mail->Send();
				return 1;
			}
			else
			{
				return 2;
			}
		}
	}
	//end function

	public function viewfi($array)
	{	
		$query = $this->db->select('count(assigned_consumer_id) as completed')
						  ->where('status','2')
						  ->where('field_inspector_id',$array['field_inspector_id'])
						  ->get('assigned_consumer');
		$total_completed = $query->result_array();
		
		$quer = $this->db->select('count(assigned_consumer_id) as pending')
						 ->where('status !=','2')
						 ->where('field_inspector_id',$array['field_inspector_id'])
						 ->get('assigned_consumer');
		$total_pending = $quer->result_array();

		$qu = $this->db->select('area, status, full_name')
					   ->where('field_inspector_id',$array['field_inspector_id'])
					   ->get('field_inspectors');
		$area = $qu->result_array();

		$que = $this->db->select('c.full_name, ac.status')
						->from('assigned_consumer as ac')
						->join('consumers as c','c.c_id=ac.c_id')
						->where('ac.field_inspector_id',$array['field_inspector_id'])
						->order_by('ac.assigned_consumer_id','desc')
						->get();
		$consumerdata = $que->result_array();
		$data = array(
						'total_completed' => $total_completed[0], 
						'total_pendding' => $total_pending[0], 
						'area' => $area[0],
						'consumerdata' => $consumerdata
					);
		return $data;
	}
	//end function

}