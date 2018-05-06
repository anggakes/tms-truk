<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master_data_category extends CI_Model{

	

	
	
	public function countMasterDataCategory($search_term=""){
		$this->db->like('description', $search_term);
		$this->db->or_like('category', $search_term);
		return $this->db->get('master_data_category')->num_rows();
	}
	
	public function dataMasterDataCategory($sampai,$dari,$search_term=""){
		$this->db->like('description', $search_term);
		$this->db->or_like('category', $search_term);
		return $query = $this->db->get('master_data_category',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getMasterDataCategory($where="")
	{
		$data = $this->db->query("SELECT * FROM master_data_category ".$where);
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