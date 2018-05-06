<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_invoice extends CI_Model{

	

	
	
	public function countInvoice($search_term=""){
		$this->db->like('client_id', $search_term);
		$this->db->or_like('invoice_number', $search_term);
		return $this->db->get('master_invoice')->num_rows();
	}
	
	public function dataInvoice($sampai,$dari,$search_term=""){
		$this->db->like('client_id', $search_term);
		$this->db->or_like('invoice_number', $search_term);
		return $query = $this->db->get('master_invoice',$sampai,$dari)->result();
		
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