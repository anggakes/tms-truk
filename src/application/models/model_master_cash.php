<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master_cash extends CI_Model{

	

	
	
	public function countMasterCashAccount($search_term=""){
		$this->db->like('name', $search_term);
		return $this->db->get('master_cash_account')->num_rows();
	}
	
	public function dataMasterCashAccount($sampai,$dari,$search_term=""){
		$this->db->like('name', $search_term);
		return $query = $this->db->get('master_cash_account',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getMasterCashAccount($where="")
	{
		$data = $this->db->query("SELECT * FROM master_cash_account ".$where);
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