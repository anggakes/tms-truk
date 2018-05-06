<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dsor extends CI_Model{


	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getMotoristData($where="")
	{
		$this->db->select("*");
 		$this->db->from('motorist');
		$this->db->where($where);
  		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
  		$query = $this->db->get();
  		return $query->result_array();
	}
	
	
	
	public function getVisitData($where="")
	{
		$this->db->select(" * ,(SELECT COUNT(id_order) FROM product_orders as p WHERE p.id_order = orders.id_order ) as total_sku");
 		$this->db->from('visit');
		$this->db->where($where);
  		$this->db->join('orders', 'orders.id_order = visit.id_order');
  		$query = $this->db->get();
  		return $query->result_array();
	}
		
	public function getMotorist($where="")
	{
		$data = $this->db->query("SELECT * FROM motorist ".$where);
		return $data;
		}
		
	public function getMotoristDetail($where="")
	{
		$data = $this->db->query("SELECT * FROM motorist ".$where);
		return $data;
		}
		
	
	public function getDistributor($where="")
	{
		
		$data = $this->db->query("SELECT * FROM distributor ".$where);
		return $data;
		}
	
		public function getMotoristType($where="")
		{
		$data = $this->db->query("SELECT * FROM motorist_type ".$where);
		return $data;
		}
	
	
	
		
		
	public function getMotoristTypeDetail($where="")
	{
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$data = $this->db->query("SELECT * FROM motorist_type ".$where);
		return $data;
	}
	
	
	public function getProductOrders($where="")
	{
		$this->db->select("*");
		$this->db->where($where);
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		return $query = $this->db->get('product_orders')->result();
	}
	

	
	public function getMotoristList($where="")
	{
			
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');	
		$this->db->join('distributor', 'distributor.distributor_code2 = motorist.distributor_code');	
		$data = $this->db->query("SELECT * FROM motorist ".$where);
		return $data;
	}
	
	
	public function getOrders($where="")
	{
		date_default_timezone_set('Asia/Jakarta');
		$bulan = date('m');
		$year = date('Y');
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l');
		$date_now = date('Y-m-d');
		
		$this->db->select(" * ,(SELECT COUNT(id_product_order) FROM product_orders as p WHERE p.id_order = orders.id_order) as total_sku_sold");
		$this->db->where($where);
		$this->db->join('motorist', 'motorist.id_motorist = orders.id_motorist');
		$this->db->join('store', 'store.customer_code= orders.customer_code');
		return $query = $this->db->get('orders')->result_array();
		}
	
	public function getStock($where="")
	{
		
		$this->db->select("*");
		$this->db->where($where);
		$this->db->join('motorist', 'motorist.id_motorist = stock.id_motorist');
		$this->db->join('product', 'product.id_product= stock.id_product');
		return $query = $this->db->get('stock')->result_array();
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
	
	
	
	public function getRegional($where=" ")
	{
		$data = $this->db->query("SELECT * FROM master_regional ".$where);
		return $data;
	}
	
	


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */