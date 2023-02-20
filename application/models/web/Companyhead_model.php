<?php
defined('BASEPATH') OR exit('No direct script access allowed.');
/**
 * 
 */
class Companyhead_model extends CI_Model
{	
	public function pass_change($array){

		$data = array('password' => $array['newpass']);
		$this->db->where('password', $array['oldpass']);
		$this->db->where('email',$array['email']);
		$this->db->update('company_head',$data);
		$affected_rows = $this->db->affected_rows('company_head');
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
	
	public function reasonalheadlist($array)
	{	
		$companyheaddata = $this->db->select('company_head_id')
								   ->where('email',$array['companyheademail'])
								   ->get('company_head');
		$companyHeadId = $companyheaddata->result_array();
		$query = $this->db->select('rh.reasonal_head_id, rh.full_name as reasonal_head_name, rh.status')
						  ->from('reasonal_head as rh')
						  ->where('company_head',$companyHeadId[0]['company_head_id'])
						  ->get();
		$data = $query->result_array();
		foreach ($data as $key => $value) 
		{
			//supervisor 
			$s = $this->db->select('count(s.reasonal_head) as total_supervisor')
						   ->from('supervisor as s')
						   ->where('s.reasonal_head',$value['reasonal_head_id'])
						   ->get();
			$sdata = $s->result_array();
			if (isset($sdata[0])) 
			{
				$data[$key]['total_supervisor'] = $sdata[0]['total_supervisor'];
			}
			else
			{
				$data[$key]['total_supervisor'] = "0";	
			} 

			//field inspector
			$fi = $this->db->select('count(fi.reasonal_head) as total_field_inspector')
						   ->from('field_inspectors as fi')
						   ->where('fi.reasonal_head',$value['reasonal_head_id'])
						   ->get();
			$fidata = $fi->result_array();
			if (isset($sdata[0])) 
			{
				$data[$key]['total_field_inspector'] = $fidata[0]['total_field_inspector'];
			}
			else
			{
				$data[$key]['total_field_inspector'] = "0";	
			} 

			//assigned consumer
			$ac = $this->db->select('count(ac.reasonal_head_id) as total_consumer')
						   ->from('assigned_consumer as ac')
						   ->where('ac.reasonal_head_id',$value['reasonal_head_id'])
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
		}
		if ($data) 
		{
			return $data;
		}
	}
	//end function

	public function endisreasonalhead($array)
	{
		$update = $this->db->set('status',$array['status'])
						   ->where('reasonal_head_id',$array['reasonal_head_id'])
						   ->update('reasonal_head');
		if ($update) 
		{
			return 1;
		}
	}
	//end function

	public function reasonalheadprocess($array)
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
			$companyheaddata = $this->db->select('company_head_id')
									    ->where('email',$array['companyheademail'])
									    ->get('company_head');
			$companyHeadId = $companyheaddata->result_array();
			$array['company_head'] = $companyHeadId[0]['company_head_id'];
			unset($array['companyheademail']);
			$postdata = array(
								'full_name' => $array['full_name'],
								'address' => $array['address'],
								'aadhar_number' => $array['aadhar_number'],
								'employee_id' => $array['employee_id'],
								'email' => $array['email'],
								'password' => $array['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$insert = $this->db->insert('reasonal_head',$postdata);
			$insert_id = $this->db->insert_id();
			if ($insert) 
			{	
				$query = $this->db->select('email')
								  ->where('reasonal_head_id',$insert_id)
								  ->get('reasonal_head');
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

	public function editreasonalhead($array)
	{
		$query = $this->db->select('rh.*')
						  ->from('reasonal_head as rh')
						  ->join('company_head as ch','ch.company_head_id=rh.company_head')
						  ->where('reasonal_head_id',$array['reasonal_head_id'])
						  ->get();
		$data = $query->result_array();
		if ($data) 
		{
			return $data[0];
		}
	}
	//end function

	public function editreasonalheadprocess($array)
	{	
		$userdata = array('full_name' => $array['fullname'], 'address' => $array['address'], 'aadhar_number' => $array['aadhar_number'], 'employee_id' => $array['employee_id'], 'email' => $array['email']);
		$update = $this->db->set($userdata)
						   ->where('reasonal_head_id',$array['reasonal_head_id'])
						   ->update('reasonal_head');
		if ($update) 
		{
			$query = $this->db->select('rh.*')
							  ->from('reasonal_head as rh')
							  ->join('company_head as ch','ch.company_head_id=rh.company_head')
							  ->where('reasonal_head_id',$array['reasonal_head_id'])
							  ->get();
			$data = $query->result_array();
			return $data[0];
		}
	}
	//end function

	public function supervisorlist($array)
	{	
		$companyheaddata = $this->db->select('company_head_id')
								    ->where('email',$array['companyheademail'])
								    ->get('company_head');
		$companyHeadId = $companyheaddata->result_array();
		$query = $this->db->select('s.supervisor_id, s.full_name as supervisor_name, s.status, s.reasonal_head')
						  ->from('supervisor as s')
						  ->where('s.company_head',$companyHeadId[0]['company_head_id'])
						  ->get();
		$data = $query->result_array();
		foreach ($data as $key => $value) 
		{
			//supervisor 
			$s = $this->db->select('rh.full_name as reasonal_head_name')
						   ->from('reasonal_head as rh')
						   ->where('rh.reasonal_head_id',$value['reasonal_head'])
						   ->get();
			$sdata = $s->result_array();
			if (isset($sdata[0])) 
			{
				$data[$key]['reasonal_head_name'] = $sdata[0]['reasonal_head_name'];
			}
			else
			{
				$data[$key]['reasonal_head_name'] = "0";	
			} 

			//field inspector
			$fi = $this->db->select('count(fi.supervisor) as total_field_inspector')
						   ->from('field_inspectors as fi')
						   ->where('fi.supervisor',$value['supervisor_id'])
						   ->get();
			$fidata = $fi->result_array();
			if (isset($sdata[0])) 
			{
				$data[$key]['total_field_inspector'] = $fidata[0]['total_field_inspector'];
			}
			else
			{
				$data[$key]['total_field_inspector'] = "0";	
			} 

			//assigned consumer
			$ac = $this->db->select('count(ac.supervisor_id) as total_consumer')
						   ->from('assigned_consumer as ac')
						   ->where('ac.supervisor_id',$value['supervisor_id'])
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
		}
		if ($data) 
		{
			return $data;
		}
	}
	//end function

	public function endissupervisor($array)
	{	
		$update = $this->db->set('status',$array['status'])
						   ->where('supervisor_id',$array['supervisor_id'])
						   ->update('supervisor');
		if ($update) 
		{
			return 1;
		}
	}
	//end function

	public function editsupervisor($array)
	{	
		$query = $this->db->select('s.*,rh.full_name as reasonal_head_name')
						  ->from('supervisor as s')
						  ->join('reasonal_head as rh','rh.reasonal_head_id=s.reasonal_head')
						  ->where('s.supervisor_id',$array['supervisor_id'])
						  ->get();
		$data = $query->result_array();
		if ($data) 
		{
			return $data[0];
		}
	}
	//end function

	public function editsupervisorprocess($array)
	{	
		$userdata = array('full_name' => $array['fullname'], 'address' => $array['address'], 'aadhar_number' => $array['aadhar_number'], 'employee_id' => $array['employee_id'], 'reasonal_head' => $array['reasonal_head'], 'email' => $array['email']);
		$update = $this->db->set($userdata)
						   ->where('supervisor_id',$array['supervisor_id'])
						   ->update('supervisor');
		if ($update) 
		{
			$query = $this->db->select('s.*,rh.full_name as reasonal_head_name')
							  ->from('supervisor as s')
							  ->join('reasonal_head as rh','rh.reasonal_head_id=s.reasonal_head')
							  ->where('supervisor_id',$array['supervisor_id'])
							  ->get();
			$data = $query->result_array();
			return $data[0];
		}
	}
	//end function

	public function fieldinspectorlist($array)
	{	
		$companyheaddata = $this->db->select('company_head_id')
								    ->where('email',$array['companyheademail'])
								    ->get('company_head');
		$companyHeadId = $companyheaddata->result_array();
		$query = $this->db->select('fi.field_inspector_id, fi.full_name as field_inspector_name, fi.status, fi.company_head, fi.reasonal_head, fi.supervisor')
						  ->from('field_inspectors as fi')
						  ->where('company_head',$companyHeadId[0]['company_head_id'])
						  ->get();
		$data = $query->result_array();
		foreach ($data as $key => $value) 
		{
			//supervisor 
			$rh = $this->db->select('rh.full_name as reasonal_head_name')
						   ->from('reasonal_head as rh')
						   ->where('rh.reasonal_head_id',$value['reasonal_head'])
						   ->get();
			$rhdata = $rh->result_array();
			if (isset($rhdata[0])) 
			{
				$data[$key]['reasonal_head_name'] = $rhdata[0]['reasonal_head_name'];
			}
			else
			{
				$data[$key]['reasonal_head_name'] = "0";	
			} 

			//field inspector
			$s = $this->db->select('s.full_name as supervisor_name')
						   ->from('supervisor as s')
						   ->where('s.supervisor_id',$value['supervisor'])
						   ->get();
			$sdata = $s->result_array();
			if (isset($sdata[0])) 
			{
				$data[$key]['supervisor_name'] = $sdata[0]['supervisor_name'];
			}
			else
			{
				$data[$key]['supervisor_name'] = "0";	
			} 

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
		}
		if ($data) 
		{
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
		$query = $this->db->select('fi.*,s.full_name as supervisor_name,rh.full_name as reasonal_head_name')
						  ->from('field_inspectors as fi')
						  ->join('reasonal_head as rh','rh.reasonal_head_id=fi.reasonal_head')
						  ->join('supervisor as s','s.supervisor_id=fi.supervisor')
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
		$userdata = array('full_name' => $array['fullname'], 'area' => $array['area'], 'aadhar_number' => $array['aadhar_number'], 'employee_id' => $array['employee_id'], 'reasonal_head' => $array['reasonal_head'], 'supervisor' => $array['supervisor'], 'email' => $array['email']);
		$update = $this->db->set($userdata)
						   ->where('field_inspector_id',$array['field_inspector_id'])
						   ->update('field_inspectors');
		if ($update) 
		{
			$query = $this->db->select('fi.*,s.full_name as supervisor_name,rh.full_name as reasonal_head_name')
							  ->from('field_inspectors as fi')
							  ->join('reasonal_head as rh','rh.reasonal_head_id=fi.reasonal_head')
							  ->join('supervisor as s','s.supervisor_id=fi.supervisor')
							  ->where('field_inspector_id',$array['field_inspector_id'])
							  ->get();
			$data = $query->result_array();
			return $data[0];
		}
	}
	//end function

	public function reasonalheads($array)
	{	
		$companyheaddata = $this->db->select('company_head_id')
								    ->where('email',$array['companyheademail'])
								    ->get('company_head');
		$companyHeadId = $companyheaddata->result_array();
		$query = $this->db->select('*')
						  ->where('status','1')
						  ->where('company_head',$companyHeadId[0]['company_head_id'])
						  ->get('reasonal_head');
		$data = $query->result_array();
		if($data)
		{
			return $data;
		}
	}
	//end function

	public function supervisors($array)
	{	
		$companyheaddata = $this->db->select('company_head_id')
								    ->where('email',$array['companyheademail'])
								    ->get('company_head');
		$companyHeadId = $companyheaddata->result_array();
		$query = $this->db->select('*')
						  ->where('status','1')
						  ->where('company_head',$companyHeadId[0]['company_head_id'])
						  ->get('supervisor');
		$data = $query->result_array();
		if($data)
		{
			return $data;
		}
	}
	//end function



	public function supervisorprocess($array)
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
			$companyheaddata = $this->db->select('company_head_id')
								    ->where('email',$array['companyheademail'])
								    ->get('company_head');
			$companyHeadId = $companyheaddata->result_array();
			$array['company_head'] = $companyHeadId[0]['company_head_id'];
			unset($array['companyheademail']);
			$postdata = array(
								'full_name' => $array['full_name'],
								'address' => $array['address'],
								'aadhar_number' => $array['aadhar_number'],
								'employee_id' => $array['employee_id'],
								'reasonal_head' => $array['reasonal_head'],
								'email' => $array['email'],
								'password' => $array['password'],
								'creation_time' => date('Y-m-d H:i:s'),
								'updation_time' => date('Y-m-d H:i:s')
								);
			$insert = $this->db->insert('supervisor',$postdata);
			$insert_id = $this->db->insert_id();
			if ($insert) 
			{	
				$query = $this->db->select('email')
								  ->where('supervisor_id',$insert_id)
								  ->get('supervisor');
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
			$query = $this->db->select('company_head_id')
							  ->where('email',$array['companyheademail'])
							  ->get('company_head');
			$data = $query->result_array();
			$array['company_head'] = $data[0]['company_head_id'];
			unset($array['companyheademail']);
			$postdata = array(
								'full_name' => $array['full_name'],
								'area' => $array['area'],
								'aadhar_number' => $array['aadhar_number'],
								'employee_id' => $array['employee_id'],
								'reasonal_head' => $array['reasonal_head'],
								'supervisor' => $array['supervisor'],
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
	//edn function

	

}