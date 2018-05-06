<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_direct_cost extends CI_Model{

	

	
	
	public function countDirectCost($search_term=""){
		$this->db->or_like('client_name', $search_term);
		$this->db->or_like('client_id', $search_term);
		return $this->db->get('direct_cost')->num_rows();
	}
	
	public function dataDirectCost($sampai,$dari,$search_term=""){
		$this->db->or_like('client_name', $search_term);
		$this->db->or_like('client_id', $search_term);
		return $query = $this->db->get('direct_cost',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getDirectCost($where="")
	{
		$data = $this->db->query("SELECT * FROM direct_cost ".$where);
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