<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_customer extends CI_Model{

	

	
	
	public function countCustomer($search_term=""){
		$this->db->or_like('customer_id', $search_term);
		$this->db->or_like('customer_name', $search_term);
		return $this->db->get('customer')->num_rows();
	}
	
	public function dataCustomer($sampai,$dari,$search_term=""){
		$this->db->or_like('customer_id', $search_term);
		$this->db->or_like('customer_name', $search_term);
		return $query = $this->db->get('customer',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getCustomer($where="")
	{
		$data = $this->db->query("SELECT * FROM customer ".$where);
		return $data;
		}
	
	public function getArea($where="")
	{
		$data = $this->db->query("SELECT * FROM master_area ".$where);
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
	
	
	
	
	


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */