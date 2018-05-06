<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_room_service_management extends CI_Model{

	
	
	public function countRoomServiceWarning($search_term=""){
		$this->db->like('vehicle_id', $search_term);
		$this->db->where("start_service_timestamp >= start_service_timestamp + INTERVAL 1 DAY ");
		return $this->db->get('room_service_management')->num_rows();
	}
	
	public function dataRoomServiceWarning($sampai,$dari,$search_term=""){
		$this->db->like('vehicle_id', $search_term);
		$this->db->where("HOUR(TIMEDIFF(NOW(), start_service_timestamp))>24 ");
		return $query = $this->db->get('room_service_management',$sampai,$dari)->result();
		
	}
	
	public function countRoomServiceManagementQueu($search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		$this->db->where('service_status', 'queue');
		return $this->db->get('room_service_management')->num_rows();
	}
	
	public function dataRoomServiceManagementQueu($sampai,$dari,$search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		$this->db->where('service_status', 'queue');
		return $query = $this->db->get('room_service_management',$sampai,$dari)->result();
		
	}
	
	
	public function countRoomServiceManagement($search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		$this->db->or_like('service_status', $search_term);
		return $this->db->get('room_service_management')->num_rows();
	}
	
	public function dataRoomServiceManagement($sampai,$dari,$search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		$this->db->or_like('service_status', $search_term);
		return $query = $this->db->get('room_service_management',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getRoomServiceManagement($where="")
	{
		$data = $this->db->query("SELECT * FROM room_service_management ".$where);
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