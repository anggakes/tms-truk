<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pr extends CI_Model{

	

	
	
	public function countPr($search_term=""){
		$this->db->or_like('division_name', $search_term);
		$this->db->or_like('id_pr', $search_term);
		return $this->db->get('master_pr')->num_rows();
	}
	
	public function dataPr($sampai,$dari,$search_term=""){
		$this->db->or_like('division_name', $search_term);
		$this->db->or_like('id_pr', $search_term);
		return $query = $this->db->get('master_pr',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getPr($where="")
	{
		$data = $this->db->query("SELECT * FROM master_pr ".$where);
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