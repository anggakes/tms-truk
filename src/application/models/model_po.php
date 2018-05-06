<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_po extends CI_Model{

	

	
	
	public function countPo($search_term=""){
		$this->db->or_like('id_po', $search_term);
		return $this->db->get('master_po')->num_rows();
	}
	
	public function dataPo($sampai,$dari,$search_term=""){
		$this->db->or_like('id_po', $search_term);
		$this->db->join('supplier', 'master_po.supplier_code = supplier.supplier_code','LEFT');
		return $query = $this->db->get('master_po',$sampai,$dari)->result();
		
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