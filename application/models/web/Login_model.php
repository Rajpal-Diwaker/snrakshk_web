<?php
defined('BASEPATH') OR exit('No direct script access allowed.');
/**
 * 
 */
class Login_model extends CI_Model
{
	public function login($array)
	{	
		$admindata = array('email' => $array['email'], 'password' => $array['password']);
		if ($array['admintype'] == "superadmin") 
		{ 
			$query = $this->db->select('*')
							  ->where($admindata)	
							  ->get('super_admin');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "superadmin";
				return $data[0];
			}
		}
		elseif ($array['admintype'] == "companyhead") 
		{
			$query = $this->db->select('*')
							  ->where($admindata)
							  ->where('status','1')	
							  ->get('company_head');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "companyhead";
				return $data[0];
			}
		}
		elseif ($array['admintype'] == "reasonalhead") 
		{
			$query = $this->db->select('*')
							  ->where($admindata)
							  ->where('status','1')	
							  ->get('reasonal_head');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "reasonalhead";
				return $data[0];
			}
		}
		elseif ($array['admintype'] == "supervisor") 
		{
			$query = $this->db->select('*')
							  ->where($admindata)
							  ->where('status','1')	
							  ->get('supervisor');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "supervisor";
				return $data[0];
			}
		}
		
	}
	//end function

	public function forgotprocess($array)
	{	
		$admindata = array('email' => $array['email']);
		if ($array['admintype'] == "superadmin") 
		{ 
			$query = $this->db->select('*')
							  ->where($admindata)	
							  ->get('super_admin');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "superadmin";
				$data[0]['uid'] = $data[0]['super_admin_id'];
			}
		}
		elseif ($array['admintype'] == "companyhead") 
		{
			$query = $this->db->select('*')
							  ->where($admindata)
							  ->where('status','1')	
							  ->get('company_head');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "companyhead";
				$data[0]['uid'] = $data[0]['company_head_id'];
			}
		}
		elseif ($array['admintype'] == "reasonalhead") 
		{
			$query = $this->db->select('*')
							  ->where($admindata)
							  ->where('status','1')	
							  ->get('reasonal_head');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "reasonalhead";
				$data[0]['uid'] = $data[0]['reasonal_head_id'];
			}
		}
		elseif ($array['admintype'] == "supervisor") 
		{
			$query = $this->db->select('*')
							  ->where($admindata)
							  ->where('status','1')	
							  ->get('supervisor');
			$num_rows = $query->num_rows();
			if($num_rows > 0){ 
				$data = $query->result_array();
				$data[0]['admintype'] = "supervisor";
				$data[0]['uid'] = $data[0]['supervisor_id'];
			}
		}

		if ($data[0]) 
		{
			$uid = base64_encode(convert_uuencode($data[0]['uid']));
			$admintype = base64_encode(convert_uuencode($data[0]['admintype']));
			$url = base_url().'web/Snrakshklog/changepassword/'.$uid.'/'.$admintype;	
			$email = 'snrakshk@gmail.com' ;
			$name = 'SNRAKSHK App';
			$message = '<html>
						<head>
						<title>Forgot password</title>
						</head>
						<body>
						<p>Dear User</p>
						<p>Click on the below link to reset your password.</p>
						<p><a href='.$url.'>Click Here</a></p>
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
			$mail->Subject = "SNRAKSHK App - Forgot password";
			$mail->Body    = $message;
			$mail->AltBody = $message;
			$mail->Send();
			return 1;
		}
	}
	//end function

	public function changepassword($array)
	{
		if ($array['admintype'] == "superadmin") 
		{ 
			$update = $this->db->set('password',$array['password'])
							  ->where('super_admin_id',$array['uid'])	
							  ->update('super_admin');
			if($update){ 
				return 1;
			}
		}
		elseif ($array['admintype'] == "companyhead") 
		{	
			$update = $this->db->set('password',$array['password'])
							  ->where('company_head_id',$array['uid'])	
							  ->update('company_head');
			if($update){ 
				return 1;
			}
		}
		elseif ($array['admintype'] == "reasonalhead") 
		{	
			$update = $this->db->set('password',$array['password'])
							  ->where('reasonal_head_id',$array['uid'])	
							  ->update('reasonal_head');
			if($update){ 
				return 1;
			}
		}
		elseif ($array['admintype'] == "supervisor") 
		{	
			$update = $this->db->set('password',$array['password'])
							  ->where('supervisor_id',$array['uid'])	
							  ->update('supervisor');
			if($update){ 
				return 1;
			}
		}
	} 
	//end function
}