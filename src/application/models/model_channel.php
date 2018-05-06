<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_channel extends CI_Model{

	

	
	
	public function countChannel($search_term=""){
		$this->db->like('classification_code', $search_term);
		$this->db->or_like('channel_description', $search_term);
		$this->db->or_like('sample', $search_term);
		return $this->db->get('channel')->num_rows();
	}
	
	public function dataChannel($sampai,$dari,$search_term=""){
		$this->db->like('classification_code', $search_term);
		$this->db->or_like('channel_description', $search_term);
		$this->db->or_like('sample', $search_term);
		return $query = $this->db->get('channel',$sampai,$dari)->result();
		
	}
	
	
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
	
	


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */