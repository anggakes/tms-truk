<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user_account extends CI_Model{

	

	
	
	public function countDistributor($search_term="",$regional){
		$this->db->like('distributor_code', $search_term);
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		return $this->db->get('distributor')->num_rows();
	}
	
	public function dataDistributor($sampai,$dari,$search_term="",$regional){
		$this->db->like('distributor_code', $search_term);	
		if($regional!="")
		{
		$this->db->where('regional in ('.$regional.') ');
		}
		return $query = $this->db->get('distributor',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	public function getDistributor($where="")
	{
		$data = $this->db->query("SELECT * FROM distributor ".$where);
		return $data;
		}
	
	public function UpdateData($tableName,$data,$where)
	{
		$update = $this->db->update($tableName, $data,$where); 
		return $update;
		
	}
	
	public function getUser($where="")
	{
		$data = $this->db->query("SELECT * FROM user_account ".$where);
		return $data;
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
	
	public function getRegional($where=" ")
	{
		$data = $this->db->query("SELECT * FROM master_regional ".$where);
		return $data;
	}
	
	


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */