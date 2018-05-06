<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_chart_admin extends CI_Model{

	

	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	public function getChannel($where="")
	{
		$data = $this->db->query("SELECT * FROM channel ".$where);
		return $data;
		}
	
	public function UpdateData($tableName,$data,$where)
	{
		$update = $this->db->update($tableName, $data,$where); 
		return $update;
		
	}
	
	public function DeleteData($mytable,$where)
	{
	
		$delete = $this->db->delete($mytable,$where);
		return $delete; 
		
		}
	
	public function getRole($where=" ")
	{
		$data = $this->db->query("SELECT * FROM user_role ".$where);
		return $data;
	}
	
	
	
	public function getMotorist($where="")
	{
		$data = $this->db->query("SELECT * FROM motorist ".$where);
		return $data;
	}
	
	public function getProduct($where="")
	{
		$data = $this->db->query("SELECT * FROM product ".$where);
		return $data;
		}

	public function getMotoristType($where="")
	{
		$data = $this->db->query("SELECT * FROM motorist_type ".$where);
		return $data;
	}
	
	public function getRegional($where="")
	{
		$data = $this->db->query("SELECT * FROM master_regional ".$where);
		return $data;
	}
	
	public function getArea($where="")
	{
		$data = $this->db->query("SELECT * FROM master_area ".$where);
		return $data;
	}
	
	public function getDistributor($where="")
	{
		$data = $this->db->query("SELECT * FROM distributor ".$where);
		return $data;
	}
	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */