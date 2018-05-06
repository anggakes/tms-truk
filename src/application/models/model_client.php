<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_client extends CI_Model{

	

	
	
	public function countClient($search_term=""){
		$this->db->or_like('client_id', $search_term);
		$this->db->or_like('client_name', $search_term);
		return $this->db->get('master_client')->num_rows();
	}
	
	public function dataClient($sampai,$dari,$search_term=""){
		$this->db->or_like('client_id', $search_term);
		$this->db->or_like('client_name', $search_term);
		return $query = $this->db->get('master_client',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getClient($where="")
	{
		$data = $this->db->query("SELECT * FROM master_client ".$where);
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