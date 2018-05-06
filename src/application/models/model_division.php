<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_division extends CI_Model{

	

	
	
	public function countDivision($search_term=""){
		$this->db->like('division_name', $search_term);
		$this->db->or_like('division_code', $search_term);
		return $this->db->get('division')->num_rows();
	}
	
	public function dataDivision($sampai,$dari,$search_term=""){
		$this->db->like('division_name', $search_term);
		$this->db->or_like('division_code', $search_term);
		return $query = $this->db->get('division',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getDivision($where="")
	{
		$data = $this->db->query("SELECT * FROM division ".$where);
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