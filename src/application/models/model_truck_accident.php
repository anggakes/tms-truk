<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_truck_accident extends CI_Model{

	

	
	
	public function countTruckAccident($search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		return $this->db->get('truck_accident')->num_rows();
	}
	
	public function dataTruckAccident($sampai,$dari,$search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		return $query = $this->db->get('truck_accident',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getTruckAccident($where="")
	{
		$data = $this->db->query("SELECT * FROM truck_accident ".$where);
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