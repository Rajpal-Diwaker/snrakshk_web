<?php
defined('BASEPATH') OR exit('No direct script access allowed.');

class Forgot_model extends CI_Model
{

	public function forgot($array)
	{	
		$query = $this->db->select('*')
						  ->where($array)
						  ->get('field_inspectors');
		$num_rows = $query->num_rows();
		if ($num_rows > 0) 
		{
		 	$data = $query->result_array();
		 	return $data[0];
		}
		else
		{	
			return 0;
		}
	}
	//===end function

	public function changepassword($array)
	{
		$update = $this->db->set('password',$array['password'])
						   ->where('field_inspector_id',$array['field_inspector_id'])
						   ->update('field_inspectors');
		if ($update) 
		{
			return 1;
		}
	}
	//===end function

}
