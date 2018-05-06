<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_warehouse extends CI_Model{

	

	
	
	public function countWarehouse($search_term=""){
		$this->db->or_like('warehouse_name', $search_term);
		$this->db->or_like('warehouse_code', $search_term);
		return $this->db->get('warehouse')->num_rows();
	}
	
	public function dataWarehouse($sampai,$dari,$search_term=""){
		$this->db->or_like('warehouse_name', $search_term);
		$this->db->or_like('warehouse_code', $search_term);
		return $query = $this->db->get('warehouse',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getWarehouse($where="")
	{
		$data = $this->db->query("SELECT * FROM warehouse ".$where);
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