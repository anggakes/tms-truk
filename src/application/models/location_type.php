<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_location_type extends CI_Model{

	

	
	
	public function countLocationType($search_term=""){
		$this->db->or_like('location_type', $search_term);
		return $this->db->get('location_type')->num_rows();
	}
	
	public function dataLocationType($sampai,$dari,$search_term=""){
		$this->db->or_like('location_type', $search_term);
		return $query = $this->db->get('location_type',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getLocationType($where="")
	{
		$data = $this->db->query("SELECT * FROM location_type ".$where);
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