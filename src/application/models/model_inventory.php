<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_inventory extends CI_Model{
	
	
	public function countStockTransfer($search_term=""){
		$this->db->like('inventory_list.id_product', $search_term);
		$this->db->or_like('product.product_code', $search_term);
		$this->db->or_like('product.product_description', $search_term);
		$this->db->or_like('location.warehouse_code', $search_term);
		$this->db->or_like('location_type.location_type', $search_term);
		$this->db->join('location', 'inventory_list.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product.id_product = inventory_list.id_product','LEFT');
		return $this->db->get('inventory_list')->num_rows();
	}
	
	public function dataStockTransfer($sampai,$dari,$search_term=""){
		$this->db->like('inventory_list.id_product', $search_term);
		$this->db->or_like('product.product_code', $search_term);
		$this->db->or_like('product.product_description', $search_term);
		$this->db->or_like('location.warehouse_code', $search_term);
		$this->db->or_like('location_type.location_type', $search_term);
		$this->db->join('location', 'inventory_list.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product.id_product = inventory_list.id_product','LEFT');
		return $query = $this->db->get('inventory_list',$sampai,$dari)->result();
		
	}
	
	
	
	public function countStockCheck($search_term=""){
		$this->db->like('inventory_list.id_product', $search_term);
		$this->db->or_like('product.product_code', $search_term);
		$this->db->or_like('product.product_description', $search_term);
		$this->db->or_like('location.warehouse_code', $search_term);
		$this->db->or_like('location_type.location_type', $search_term);
		$this->db->join('location', 'inventory_list.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product.id_product = inventory_list.id_product','LEFT');
		return $this->db->get('inventory_list')->num_rows();
	}
	
	public function dataStockCheck($sampai,$dari,$search_term=""){
		$this->db->like('inventory_list.id_product', $search_term);
		$this->db->or_like('product.product_code', $search_term);
		$this->db->or_like('product.product_description', $search_term);
		$this->db->or_like('location.warehouse_code', $search_term);
		$this->db->or_like('location_type.location_type', $search_term);
		$this->db->join('location', 'inventory_list.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product.id_product = inventory_list.id_product','LEFT');
		return $query = $this->db->get('inventory_list',$sampai,$dari)->result();
		
	}
	

	
	
	public function countInventoryList($search_term=""){
		$this->db->like('inventory_list.id_product', $search_term);
		$this->db->or_like('product.product_code', $search_term);
		$this->db->or_like('product.product_description', $search_term);
		$this->db->or_like('location.warehouse_code', $search_term);
		$this->db->or_like('location_type.location_type', $search_term);
		$this->db->join('location', 'inventory_list.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product.id_product = inventory_list.id_product','LEFT');
		return $this->db->get('inventory_list')->num_rows();
	}
	
	public function dataInventoryList($sampai,$dari,$search_term=""){
		$this->db->like('inventory_list.id_product', $search_term);
		$this->db->or_like('product.product_code', $search_term);
		$this->db->or_like('product.product_description', $search_term);
		$this->db->or_like('location.warehouse_code', $search_term);
		$this->db->or_like('location_type.location_type', $search_term);
		$this->db->join('location', 'inventory_list.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product.id_product = inventory_list.id_product','LEFT');
		return $query = $this->db->get('inventory_list',$sampai,$dari)->result();
		
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