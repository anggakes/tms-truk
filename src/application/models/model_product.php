<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_product extends CI_Model{

	

	
	
	public function countProduct($search_term=""){
		$this->db->or_like('product_code', $search_term);
		$this->db->or_like('product_description', $search_term);
		$this->db->join('warehouse', 'warehouse.id_warehouse = product.id_warehouse','LEFT');
		$this->db->join('supplier', 'supplier.id_supplier = product.id_supplier','LEFT');
		return $this->db->get('product')->num_rows();
	}
	
	public function dataProduct($sampai,$dari,$search_term=""){
		$this->db->or_like('product_code', $search_term);
		$this->db->or_like('product_description', $search_term);
		$this->db->join('warehouse', 'warehouse.id_warehouse = product.id_warehouse','LEFT');
		$this->db->join('supplier', 'supplier.id_supplier = product.id_supplier','LEFT');
		return $query = $this->db->get('product',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getProduct($where="")
	{
		$data = $this->db->query("SELECT * FROM product ".$where);
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