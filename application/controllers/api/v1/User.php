<?php
defined('BASEPATH') OR exit('No direct script access allowed.');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'third_party/phpmailer/class.phpmailer.php';
class User extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata,true);
		if ($request) 
    	{	
    		$this->data = $request;
    	}
		elseif($this->input->post())
		{	
			$this->data = $this->input->post();
        }
		elseif($this->input->get())
		{
			$this->data = $this->input->get();
		}
		$this->load->library('email');
		$this->load->helper(array('form', 'url'));
		$this->load->model('v1/User_model');
		$this->load->model('v1/Forgot_model');
	}
	//end function

	//---------->>>>>>>>>>>>> error check <<<<<<<<<<<<<<--------------//
	function getErrorMsg($required=array(), $request=array())
	{ 	
		$notExist = true;
		foreach($required as $value)
		{ 
			if(array_key_exists($value, $request))
			{    
				if($request[$value]=="")
				{     
					$data = array(
									"statusCode"=> 400,
									"statusMsg"=>"FAILED",
									"error_string"=>$value." is empty."
								 ); 
					$this->response($data, 400);
					//echo json_encode($data);
					exit; 
				} 
			}
			else
			{ 
				$data = array(
								"statusCode"=> 400,
								"statusMsg"=>"FAILED",
								"error_string"=>$value. " key is missing."
							 ); 
				$this->response($data, 400);
				//echo json_encode($data);
				exit;   
			}  
		} 
		return $notExist; 
	}

	//----------------->>>>>>>>>>>>> error check end <<<<<<<<<<<<<<---------------//

	public function login_post()
	{	
		$arrayRequired=array('email','password');
		$var = $this->getErrorMsg($arrayRequired, $this->data);
		$post = $this->data;
		$post['password'] = md5($post['password']);
		$userdata = array(
							'email' => $post['email'], 
							'password' => $post['password']
							);
		$response = $this->User_model->login($userdata);
		if ($response == 0) 
		{	
			$data=array(
						"statusCode" => 400, 
						"statusMsg"  => "Incorrect email. Please check and try again."
						);
			$this->response($data, 400);
			//echo json_encode($data);
		}
		elseif ($response == 1) 
		{
			$data=array(
						"statusCode" => 400, 
						"statusMsg"  => "Incorrect Password. Please check and try again."
						);
			$this->response($data, 400);
			//echo json_encode($data);
		}
		elseif ($response == 2) 
		{
			$data=array(
						"statusCode" => 403 , 
						"APICODERESULT"  => "Your account deactivated."
						);
			$this->response($data,403);
		}
		else
		{
			$data=array(
						"statusCode" => 200, 
						"statusMsg"  => "Login Successfully.", 
						"result" => $response
						);
			$this->response($data, 200);
			//echo json_encode($data);
		}
	}
	//end function


	public function forgot_post()
	{
		$arrayRequired = array(
								'email'
								);
		$var = $this->getErrorMsg($arrayRequired, $this->data);
		$post = $this->post();
		$data = array('email' => $post['email']);
		$response = $this->Forgot_model->forgot($data);
		if ($response == 0) 
		{
			$data=array(
						"statusCode" => 400 , 
						"statusMsg"  => "Email not valid."
						);
			$this->response($data,400);	
		}
		else
		{	
			$uid = base64_encode(convert_uuencode($response['field_inspector_id']));
			$url = base_url().'api/v1/Resetpass/changepassword/'.$uid;	
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
			$mail->AddAddress($response['email']);
			$mail->WordWrap = 50;
			$mail->IsHTML(true);
			$mail->Subject = "SNRAKSHK App - Forgot password";
			$mail->Body    = $message;
			$mail->AltBody = $message;
			$mail->Send();
			
			$data=array(
						"statusCode" => 200 , 
						"statusMsg"  => "A link has been sent to your registered email address."
						);

			$this->response($data,200);
		}

	}
	//===end function

	public function logout_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
								'field_inspector_id'
								);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->post();
			$data = array('field_inspector_id' => $post['field_inspector_id'], 'token' => $headers['token']);
			$response = $this->User_model->logout($data);
			if ($response) 
			{
				$data=array(
		                      "statusCode"      => 200,
		                      "statusMsg"  => "Success.",
		                    );
				$this->response($data,200);
			}
			else
			{
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}

		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function

	public function questionlist_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
								'field_inspector_id','lang'
								);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->data;
			$data = array('field_inspector_id' => $post['field_inspector_id'], 'token' => $headers['token'],'lang' => $post['lang']);
			$response = $this->User_model->questionlist($data);
			if ($response) 
			{
				$data=array(
		                      "statusCode"      => 200,
		                      "statusMsg"  => "Question list.",
		                      "result" => $response
		                    );
				$this->response($data,200);
			}
			else
			{
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function

	public function assigned_consumers_post()
	{	
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
								'field_inspector_id',
								'type'
								);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->data;
			$data = array('field_inspector_id' => $post['field_inspector_id'], 'token' => $headers['token'], 'type' => $post['type']);
			// print_r($this->data);die;
			$response = $this->User_model->assigned_consumers($data);
			if ($response == 1) 
			{
				$data=array(
		                      "statusCode"      => 200,
		                      "statusMsg"  => "No Consumer found.",
		                      "result" => []
		                    );
				$this->response($data,200);
			}
			else if ($response == 0) {
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
			else
			{
				$data=array(
		                      "statusCode"      => 200,
		                      "statusMsg"  => "Consumer list.",
		                      "result" => $response
		                    );
				$this->response($data,200);
			}
		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function

	public function submitquestion_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
								'field_inspector_id',
								'assigned_consumer_id',
								'image_id',
								'inspection',
								'attendant',
								'payment_mode',
								'amount',
								'consumer_number_status',
								'phone',
								'total_members',
								'employed',
								'total_lpg_consumption',
								'number_of_phones',
								'two_wheeler',
								'four_wheeler'
								);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->post();
			$field_inspector_address_proof = "";
			$kitchen_image = "";
			$consumer_id_image = "";
			
			if (isset($_FILES['field_inspector_address_proof']) && !empty($_FILES['field_inspector_address_proof']['name'])) 
			{
				$image1 = $_FILES['field_inspector_address_proof']['name'];
				//setting user profile picture name randomlly
				//rand(1, 999999999)
				$field_inspector_address_proof = $post['assigned_consumer_id'].'-'.$image1;
				//configuring for image upload
			    $config['upload_path']  = './uploads/'.$post['assigned_consumer_id'];
			    $config['allowed_types'] = '*';
			    // $config['max_size']    = 0;
			   	// $config['max_width']   = 1024;
			    // $config['max_height']  = 768;
			    $config['file_name']	= $field_inspector_address_proof;
			    $config['orig_name']	= $image1;
			    //creating folder for user image upload
			    if (!is_dir('uploads/'.$post['assigned_consumer_id'])) {
					mkdir('./uploads/'.$post['assigned_consumer_id'], 0777, TRUE);
				}
				//loading upload library 
			    $this->load->library('upload', $config);
			    //checking do_upload function working or not
			    if ( ! $this->upload->do_upload('field_inspector_address_proof'))
			    {	
			       echo $this->upload->display_errors();
			    }
			}

			if (isset($_FILES['kitchen_image']) && !empty($_FILES['kitchen_image']['name'])) 
			{
				$image2 = $_FILES['kitchen_image']['name'];
				//setting user profile picture name randomlly
				$kitchen_image = $post['assigned_consumer_id'].'-'.$image2;
				//configuring for image upload
			    $config['upload_path']  = './uploads/'.$post['assigned_consumer_id'];
			    $config['allowed_types'] = '*';
			    // $config['max_size']    = 0;
			   	// $config['max_width']   = 1024;
			    // $config['max_height']  = 768;
			    $config['file_name']	= $field_inspector_address_proof;
			    $config['orig_name']	= $image2;
			    //creating folder for user image upload
			    if (!is_dir('uploads/'.$post['assigned_consumer_id'])) {
					mkdir('./uploads/'.$post['assigned_consumer_id'], 0777, TRUE);
				}
				//loading upload library 
			    $this->load->library('upload', $config);
			    //checking do_upload function working or not
			    if ( ! $this->upload->do_upload('kitchen_image'))
			    {	
			       echo $this->upload->display_errors();
			    }
			}

			if (isset($_FILES['consumer_id_image']) && !empty($_FILES['consumer_id_image']['name'])) 
			{
				$image3 = $_FILES['consumer_id_image']['name'];
				//setting user profile picture name randomlly
				$consumer_id_image = $post['assigned_consumer_id'].'-'.$image3;
				//configuring for image upload
			    $config['upload_path']  = './uploads/'.$post['assigned_consumer_id'];
			    $config['allowed_types'] = '*';
			    // $config['max_size']    = 0;
			   	// $config['max_width']   = 1024;
			    // $config['max_height']  = 768;
			    $config['file_name']	= $consumer_id_image;
			    $config['orig_name']	= $image3;
			    //creating folder for user image upload
			    if (!is_dir('uploads/'.$post['assigned_consumer_id'])) {
					mkdir('./uploads/'.$post['assigned_consumer_id'], 0777, TRUE);
				}
				//loading upload library 
			    $this->load->library('upload', $config);
			    //checking do_upload function working or not
			    if ( ! $this->upload->do_upload('consumer_id_image'))
			    {	
			       echo $this->upload->display_errors();
			    }
			}

			$postdata = array(
								'field_inspector_id' => $post['field_inspector_id'],
								'assigned_consumer_id' => $post['assigned_consumer_id'],
								'image_id' => $post['image_id'],
								'inspection' => $post['inspection'],
								'attendant' => $post['attendant'],
								'outdated' => (!empty($post['outdated']))?$post['outdated']:"",
								'field_inspector_address_proof' => $field_inspector_address_proof,
								'any_complaint' => (!empty($post['any_complaint']))?$post['any_complaint']:"",
								'kitchen_image' => $kitchen_image,
								'consumer_id_image' => $consumer_id_image,
								'payment_mode' => $post['payment_mode'],
								'amount' => $post['amount'],
								'consumer_number_status' => $post['consumer_number_status'],
								'phone' => $post['phone'],
								'alternate_phone' => (!empty($post['alternate_phone']))?$post['alternate_phone']:"",
								'email' => (!empty($post['email']))?$post['email']:"",
								'total_members' => $post['total_members'],
								'employed' => $post['employed'],
								'total_lpg_consumption' => $post['total_lpg_consumption'],
								'number_of_phones' => $post['number_of_phones'],
								'two_wheeler' => $post['two_wheeler'],
								'four_wheeler' => $post['four_wheeler'],
								'latitude' => (!empty($post['latitude']))?$post['latitude']:"",
								'longitude' => (!empty($post['longitude']))?$post['longitude']:"",
								'token' => $headers['token']
								);
			
			$response = $this->User_model->submitquestion($postdata);
			
			if ($response == 1) 
			{
				$data = array(
								"statusCode"      => 200,
		                      	"statusMsg"  => "Data Already submited.",
							 ); 
				$this->response($data, 200);
			}
			elseif ($response == 0) {
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
			elseif ($response == 2) 
			{
				$data = array(
								"statusCode"      => 200,
		                      	"statusMsg"  => "success",
							 ); 
				$this->response($data, 200);
			}

		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function


	public function submitquestion2_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$post = $this->data;
			$postdata = array(
				'field_inspector_id' => $post['field_inspector_id'],
				'assigned_consumer_id' => $post['assigned_consumer_id'],
				'attendant' => $post['attendant'],
				'phone' => $post['phone'],
				'alternate_phone' => (!empty($post['alternate_phone']))?$post['alternate_phone']:"",
				'email' => (!empty($post['email']))?$post['email']:"",
				'token' => $headers['token']
				);
				// echo '<pre>';print_r($post); print_r($postdata);die;
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->post();
			$field_inspector_address_proof = "";
			$kitchen_image = "";
			$consumer_id_image = "";
			
			$response = $this->User_model->submitquestion2($postdata);
			
			if ($response == 1) 
			{
				$data = array(
								"statusCode"      => 200,
		                      	"statusMsg"  => "Data Already submited.",
							 ); 
				$this->response($data, 200);
			}
			elseif ($response == 0) {
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
			elseif ($response == 2) 
			{
				$data = array(
								"statusCode"      => 200,
		                      	"statusMsg"  => "success",
							 ); 
				$this->response($data, 200);
			}

		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function


	public function changepassword_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
									'oldpassword',
									'newpassword',
									'field_inspector_id'
									);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->post();
			$post['oldpassword'] = md5($post['oldpassword']);
			$post['newpassword'] = md5($post['newpassword']);
			$userdata = array(
								'oldpassword' => $post['oldpassword'],
								'newpassword' => $post['newpassword'],
								'field_inspector_id' => $post['field_inspector_id'],
								'token' => $headers['token']
								);
			$response = $this->User_model->changepassword($userdata);
			if ($response == 1) 
			{	
				$data=array(
							"statusCode" => 200 , 
							"statusMsg"  => "Password changed successfully."
							);
				$this->response($data,200);	
			}
			elseif ($response == 0) 
			{
				$data=array(
							"statusCode" => 400 , 
							"statusMsg"  => "Please enter correct old password."
							);
				$this->response($data,400);	
			}
			elseif ($response == 2) {
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
			else
			{
				$data=array(
								"statusCode" => 400 , 
								"statusMsg"  => "Please try again."
								);
				$this->response($data,400);	
			}
		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function

	public function resendotp_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
									'c_id',
									'field_inspector_id'
									);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->post();
			$userdata = array(
								'c_id' => $post['c_id'],
								'field_inspector_id' => $post['field_inspector_id'],
								'token' => $headers['token']
								);
			$response = $this->User_model->resendotp($userdata);
			if ($response == 1) 
			{	
				$data=array(
							"statusCode" => 400 , 
							"statusMsg"  => "Please try again."
							);
				$this->response($data,400);
			}
			elseif ($response == 2) 
			{
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
			else
			{
				$data=array(
								"statusCode" => 200 , 
								"statusMsg"  => "Consumer otp.",
								"result" => $response
								);
				$this->response($data,200);	
			}
		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function

	public function consumernotavailable_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
									'assigned_consumer_id',
									'field_inspector_id'
									);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->post();
			$userdata = array(
								'assigned_consumer_id' => $post['assigned_consumer_id'],
								'field_inspector_id' => $post['field_inspector_id'],
								'token' => $headers['token']
								);
			$response = $this->User_model->consumernotavailable($userdata);
			if ($response == 1) 
			{	
				$data=array(
							"statusCode" => 400 , 
							"statusMsg"  => "Please try again."
							);
				$this->response($data,400);
			}
			elseif ($response == 2) 
			{
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
			elseif($response == 3)
			{
				$data=array(
								"statusCode" => 200 , 
								"statusMsg"  => "success"
								);
				$this->response($data,200);	
			}
		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function

	public function checkuser_post()
	{
		$headers = apache_request_headers();
		if(isset($headers['token']) && !empty($headers['token']))
		{	
			$arrayRequired = array(
									'field_inspector_id'
									);
			$var = $this->getErrorMsg($arrayRequired, $this->data);
			$post = $this->post();
			$userdata = array(
								'field_inspector_id' => $post['field_inspector_id'],
								'token' => $headers['token']
								);
			$response = $this->User_model->checkuser($userdata);
			if ($response == 1) 
			{	
				$data=array(
							"statusCode" => 403 , 
							"statusMsg"  => "Your account deactivated."
							);
				$this->response($data,403);
			}
			elseif ($response == 2) 
			{
				$data=array(
		                      "statusCode"      => 400,
		                      "statusMsg"  => "Please provide valid token.",
		                    );
				$this->response($data,400);
			}
			elseif($response == 3)
			{
				$data=array(
								"statusCode" => 200 , 
								"statusMsg"  => "Active user."
								);
				$this->response($data,200);	
			}
		}
		else
		{
			$data = array(
							"statusCode"      => 400,
	                      	"statusMsg"  => "Invalid access!!!",
						 ); 
			$this->response($data, 400);
		}
	}
	//end function
}