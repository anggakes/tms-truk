<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_master_unit extends CI_Model{

	

	
	
	public function countMasterUnit($search_term=""){
		$this->db->select('*,master_unit.vehicle_type as id_vehicle_type');
		$this->db->or_like('vehicle_id', $search_term);
		$this->db->join('vehicle_type', 'vehicle_type.id_vehicle_type = master_unit.vehicle_type','LEFT');
		return $this->db->get('master_unit')->num_rows();
	}
	
	public function dataMasterUnit($sampai,$dari,$search_term=""){
		$this->db->select('*,master_unit.vehicle_type  as id_vehicle_type ');
		$this->db->or_like('vehicle_id', $search_term);
		$this->db->join('vehicle_type', 'vehicle_type.id_vehicle_type = master_unit.vehicle_type','LEFT');
		return $query = $this->db->get('master_unit',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getMasterunit($where="")
	{
		$data = $this->db->query("SELECT * FROM master_unit ".$where);
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