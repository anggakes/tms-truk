<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_room_service extends CI_Model{

	

	
	
	public function countRoomService($search_term=""){
		$this->db->like('room_service_id', $search_term);
		$this->db->or_like('room_service_name', $search_term);
		return $this->db->get('room_service')->num_rows();
	}
	
	public function dataRoomService($sampai,$dari,$search_term=""){
		$this->db->like('room_service_id', $search_term);
		$this->db->or_like('room_service_name', $search_term);
		return $query = $this->db->get('room_service',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getRoomService($where="")
	{
		$data = $this->db->query("SELECT * FROM room_service ".$where);
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