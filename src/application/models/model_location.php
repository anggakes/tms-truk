<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_location extends CI_Model{

	public function countLocation($search_term=""){
		$this->db->or_like('location_code', $search_term);
		$this->db->join('location_type', 'location_type.id_location_type = location.id_location_type','LEFT');
		return $this->db->get('location')->num_rows();
	}
	
	public function dataLocation($sampai,$dari,$search_term=""){
		$this->db->or_like('location_code', $search_term);
		$this->db->join('location_type', 'location_type.id_location_type = location.id_location_type','LEFT');
		return $query = $this->db->get('location',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getLocation($where="")
	{
		$data = $this->db->query("SELECT * FROM location ".$where);
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