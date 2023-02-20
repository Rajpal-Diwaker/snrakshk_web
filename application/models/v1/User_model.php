<?php 
defined('BASEPATH') OR exit('No direct access allowed');

class User_model extends CI_Model
{
	public function login($array)
	{ 
		$query = $this->db->select('field_inspector_id')
						  ->where('email',$array['email'])
						  ->where('password',$array['password'])
						  ->get('field_inspectors');
        $num_rows = $query->num_rows();
        if ($num_rows > 0) 
		{
			$data = $query->result_array();
			if ($data) 
			{	
				$token = rand(100000000000000, 999999999999999);
				$this->db->set('token',$token)
						 ->where('field_inspector_id',$data[0]['field_inspector_id'])
						 ->update('field_inspectors');

				$quer = $this->db->select('field_inspector_id, full_name, area, aadhar_number,  employee_id, company_head, reasonal_head, supervisor, email, token, status')
						  ->where('field_inspector_id',$data[0]['field_inspector_id'])
						  ->where('status','1')
						  ->get('field_inspectors');
						  
				$logdata = $quer->result_array();
				if ($logdata[0]) 
				{
					return $logdata[0];
				}
				else
				{
					return 2;
				}
				
			}
		}
		else
		{	
			$qr = $this->db->select('*')
						   ->where('email',$array['email'])
						   ->get('field_inspectors');
			$nm_rows = $qr->num_rows();
			if ($nm_rows > 0) 
			{
				return 1;
			}
			else
			{
				return 0;	
			}
		}
	}
	//end function

	public function logout($array)
	{
		$update = $this->db->set('token','')
						   ->where('token',$array['token'])
						   ->update('field_inspectors');
		if ($update) 
		{
			return 1;
		}	
	}
	//end function

	public function questionlist($array)
	{
		// print_r($array);die;
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
		$num_rows = $checktoken->num_rows();
		if ($num_rows > 0) 
		{
			if($array['lang']=='en')
			{
			   $query = $this->db->select('question_category_id, category')
							  ->get('question_categories');
			}else 
			{
				if($array['lang']=='hi')
				{
					$query = $this->db->select('question_category_id,hindiCategory as category')
								->get('question_categories');
				}
			}				  
			$data = $query->result_array();
			if ($data) 
			{
				foreach ($data as $key => $value) 
				{
					if($array['lang']=='en')
					 {
					  $quer = $this->db->select('question_id,question,status')
									 ->where('question_category_id',$data[$key]['question_category_id'])
									 ->where('status','1')
									 ->get('questions');
					 }
					 else
					 {
						if($array['lang']=='hi')
						{
						$quer = $this->db->select('question_id,hindiquestion as question,status')
										->where('question_category_id',$data[$key]['question_category_id'])
										->where('status','1')
										->get('questions');
						}				
					 }				 
					$data[$key]['questiondata'] = $quer->result_array();
				}

				$que = $this->db->select('image_id, image')
								->where('status','1')
								->get('cylinder_images');
				$cylinserImagedata = $que->result_array();
				foreach ($cylinserImagedata as $key => $value) 
				{
					$cylinserImagedata[$key]['image'] = (!empty($value['image'])) ? base_url().'uploads/cylinderImages/'.$value['image'] : "";
				}
				$cyldata = array('instruction_images' => $cylinserImagedata);
				$questiondata = array('questions' => $data);
				$alldata = array_merge($questiondata,$cyldata);

				return $alldata;
			}
		}
	}
	//end function

	public function assigned_consumers($array)
	{	
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
							//    echo $this->db->last_query();die;
		$num_rows = $checktoken->num_rows();
		if ($num_rows > 0) 
		{	
			if ($array['type'] == 'pending') 
			{
				$query = $this->db->select('c.*, ac.assigned_consumer_id,ac.status,ac.creation_time')
								  ->from('assigned_consumer as ac')
								  ->join('consumers as c','c.c_id=ac.c_id')
								  ->where('ac.field_inspector_id',$array['field_inspector_id'])
								  ->where('status !=','2')
								  ->get();
				$data = $query->result_array();
				if ($data) 
				{
					return $data;
				}
				else
				{
					return 1;
				}
			}
			elseif ($array['type'] == 'completed') 
			{
				$query = $this->db->select('c.*, ac.assigned_consumer_id,ac.status')
								  ->from('assigned_consumer as ac')
								  ->join('consumers as c','c.c_id=ac.c_id')
								  ->where('ac.field_inspector_id',$array['field_inspector_id'])
								  ->where('status','2')
								  ->get();
								//   echo $this->db->last_query();die;
				$data = $query->result_array();
				if ($data) 
				{	
					foreach ($data as $key => $value) 
					{
						$quer = $this->db->select('creation_time')
										 ->where('assigned_consumer_id',$value['assigned_consumer_id'])
										 ->group_by('assigned_consumer_id')
										 ->get('instruction_image');
						$creationtime = $quer->result_array();
						$data[$key]['creation_time'] = $creationtime[0]['creation_time'];
					}
					return $data;
				}
				else
				{
					return 1;
				}
			}

		}
		else
		{
			return 0;
		}
	}
	//end function

	public function submitquestion($array)
	{	
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
		$num_rs = $checktoken->num_rows();
		if ($num_rs > 0) 
		{	
			$query = $this->db->select('*')
							  ->where('assigned_consumer_id',$array['assigned_consumer_id'])
							  ->where('field_inspector_id',$array['field_inspector_id'])
							  ->get('other_details');
			$num_rows = $query->num_rows();
			if ($num_rows > 0) 
			{	
				return 1;	
			}
			else
			{	
				$image_iddata = json_decode($array['image_id'],true);
				foreach ($image_iddata as $key => $value) 
				{	
					$instruction_imagedata = array(
											'field_inspector_id' => $array['field_inspector_id'],
											'assigned_consumer_id' => $array['assigned_consumer_id'],
											'image_id' => $value['image_id'],
											'answer' => $value['answer'],
											'creation_time' => date('Y-m-d H:i:s')
											);
					$insertchecklist = $this->db->insert('instruction_image',$instruction_imagedata);
				}

				// if (isset($insertchecklist)) 
				// {	
					$inspection = json_decode($array['inspection'],true);
					foreach ($inspection as $key => $value) 
					{
						$inspectiondata = array(
												'field_inspector_id' => $array['field_inspector_id'],
												'assigned_consumer_id' => $array['assigned_consumer_id'],
												'question_id' => $value['question_id'],
												'answer' => $value['answer'],
												'creation_time' => date('Y-m-d H:i:s')
												);
						$insertinspection = $this->db->insert('inspections',$inspectiondata);
					}

					// if (isset($insertinspection)) 
					// {
						$other_detaildata = array(
													'attendant' => $array['attendant'],
													'outdated' => (!empty($array['outdated']))?$array['outdated']:"",
													'any_complaint' => (!empty($array['any_complaint']))?$array['any_complaint']:"",
													'field_inspector_address_proof' => $array['field_inspector_address_proof'],
													'kitchen_image' => $array['kitchen_image'],
													'consumer_id_image' => $array['consumer_id_image'],
													'payment_mode' => $array['payment_mode'],
													'amount' => $array['amount'],
													'consumer_number_status' => $array['consumer_number_status'],
													'field_inspector_id' => $array['field_inspector_id'],
													'assigned_consumer_id' => $array['assigned_consumer_id'],
													'phone' => $array['phone'],
													'alternate_phone' => (!empty($array['alternate_phone']))?$array['alternate_phone']:"",
													'email' => (!empty($array['email']))?$array['email']:"",
													'total_members' => $array['total_members'],
													'employed' => $array['employed'],
													'total_lpg_consumption' => $array['total_lpg_consumption'],
													'number_of_phones' => $array['number_of_phones'],
													'two_wheeler' => $array['two_wheeler'],
													'four_wheeler' => $array['four_wheeler'],
													'latitude' => (!empty($array['latitude']))?$array['latitude']:"",
													'longitude' => (!empty($array['longitude']))?$array['longitude']:""
												);
						$this->db->insert('other_details',$other_detaildata);

						// $this->db->set('status','2')
						// 		 ->where('field_inspector_id',$array['field_inspector_id'])
						// 		 ->where('assigned_consumer_id',$array['assigned_consumer_id'])
						// 		 ->update('assigned_consumer');
						return 2;
					
			}
		}
		else
		{
			return 0;
		}
	}
	//end function


	public function submitquestion2($array)
	{	
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
		$num_rs = $checktoken->num_rows();
		if ($num_rs > 0) 
		{	
			$query = $this->db->select('*')
							  ->where('assigned_consumer_id',$array['assigned_consumer_id'])
							  ->where('field_inspector_id',$array['field_inspector_id'])
							  ->get('other_details');
			$num_rows = $query->num_rows();
			if ($num_rows > 0) 
			{	
				return 1;	
			}
			else
			{	
		$other_detaildata = array(      
								'attendant' => $array['attendant'],
								'field_inspector_id' => $array['field_inspector_id'],
								'assigned_consumer_id' => $array['assigned_consumer_id'],
								'phone' => $array['phone'],
								'alternate_phone' => (!empty($array['alternate_phone']))?$array['alternate_phone']:"",
								'email' => (!empty($array['email']))?$array['email']:"",
								);

						$this->db->insert('other_details',$other_detaildata);

						// echo $this->db->last_query();
						// $this->db->set('status','2')
						// 		 ->where('field_inspector_id',$array['field_inspector_id'])
						// 		 ->where('assigned_consumer_id',$array['assigned_consumer_id'])
						// 		 ->update('assigned_consumer');
						// 		//  echo $this->db->last_query();
						return 2;
					
			}
		}
		else
		{
			return 0;
		}
	}
	//end function

	public function changepassword($array)
	{	
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
		$num_rows = $checktoken->num_rows();
		if ($num_rows > 0) 
		{
			$query = $this->db->select('*')
							  ->where('field_inspector_id',$array['field_inspector_id'])
							  ->where('password',$array['oldpassword'])
							  ->get('field_inspectors');
			$num_rows = $query->num_rows();
			if ($num_rows > 0) 
			{
				$update = $this->db->set('password',$array['newpassword'])
								   ->where('field_inspector_id',$array['field_inspector_id'])
								   ->update('field_inspectors');
				if ($update) 
				{
					return 1;
				}
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 2;
		}

	}
	//end function

	public function resendotp($array)
	{
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
		$num_rows = $checktoken->num_rows();
		if ($num_rows > 0) 
		{
			$query = $this->db->select('consumer_otp')
							  ->where('c_id',$array['c_id'])
							  ->get('consumers');
			$data = $query->result_array();
			if ($data) 
			{
				return $data[0];
			}
			else
			{
				return 1;
			}
		}
		else
		{
			return 2;
		}
	}
	//end function

	public function consumernotavailable($array)
	{
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
		$num_rows = $checktoken->num_rows();
		if ($num_rows > 0) 
		{
			// $update = $this->db->set('status','0')
			// 				  ->where('assigned_consumer_id',$array['assigned_consumer_id'])
			// 				  ->update('assigned_consumer');
			if ($update) 
			{
				return 3;
			}
			else
			{
				return 1;
			}
		}
		else
		{
			return 2;
		}
	}
	//end function

	public function checkuser($array)
	{
		$checktoken = $this->db->select('*')
							   ->where('token',$array['token'])
							   ->where('field_inspector_id',$array['field_inspector_id'])
							   ->get('field_inspectors');
		$num_rows = $checktoken->num_rows();
		if ($num_rows > 0) 
		{
			$query = $this->db->select('*')
							  ->where('field_inspector_id',$array['field_inspector_id'])
							  ->where('status','1')
							  ->get('field_inspectors');
			$num_rows = $query->num_rows();
			if ($num_rows) 
			{
				return 3;
			}
			else
			{
				return 1;
			}
		}
		else
		{
			return 2;
		}
	}
	//edn function
}