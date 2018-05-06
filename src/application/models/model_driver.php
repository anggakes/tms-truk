<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_driver extends CI_Model{

		
	public function countDistributor($search_term="",$regional){
		$this->db->like('distributor_code', $search_term);
		
		return $this->db->get('distributor')->num_rows();
	}
	
	public function dataDistributor($sampai,$dari,$search_term="",$regional){
		$this->db->like('distributor_code', $search_term);	
		
		return $query = $this->db->get('distributor',$sampai,$dari)->result();
		
	}

	
	
	public function countDriver($search_term=""){
		$this->db->or_like('driver_code', $search_term);
		return $this->db->get('driver')->num_rows();
	}
	
	public function dataDriver($sampai,$dari,$search_term=""){
		$this->db->or_like('driver_code', $search_term);
		return $query = $this->db->get('driver',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getDriver($where="")
	{
		$data = $this->db->query("SELECT * FROM driver ".$where);
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