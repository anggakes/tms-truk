<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_store extends CI_Model{

	

	public function countFilterMap($distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role){
		
		if($distributor!="")
		{
			$this->db->where('distributor_code in ('.$distributor.') ');
		}
		
		
		if($channel!="")
		{
			$this->db->where('channel_code in ('.$channel.') ');
		}
		
		if($day!="")
		{
			$this->db->where('day_visit in ("'.$day.'") ');
		}
		
		if($motorist!="")
		{
			$this->db->where('motorist_code in ("'.$motorist.'") ');
		}
		
		
		
		
		
		return $this->db->get('store')->num_rows();
	}
	
	public function filterMap($sampai,$dari,$distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role){

		if($distributor!="")
		{
			$this->db->where('distributor_code in ('.$distributor.') ');
		}
		
		
		if($channel!="")
		{
			$this->db->where('channel_code in ('.$channel.') ');
		}
		
		if($day!="")
		{
			$this->db->where('day_visit in ("'.$day.'") ');
		}
		
		if($motorist!="")
		{
			$this->db->where('motorist_code in ("'.$motorist.'") ');
		}
		
		
		if($product!="")
		{
		
			$this->db->limit(1);
			$this->db->join('product_orders', 'product_orders.customer_code = store.customer_code');
			
			//yang transaksi
			if($transaction_month=="yes")
			{
				//Range Bulan Diisi
				$mo =	date('m');
				$year = date('y');
				if($month!="")
				{
					$this->db->where('product_orders.id_product in ("'.$product.'") AND product_orders.date between "'.$year.'-'.$month.'-01 00:00:00'.'" AND  "'.$year.'-'.$month.'-31 23:59:59'.'" ');
				}
				//Range Bulan tidak diisi
				else
				{
					$this->db->where('product_orders.id_product in ("'.$product.'") AND product_orders.date between "'.$year.'-'.$mo.'-01 00:00:00'.'" AND  "'.$year.'-'.$mo.'-31 23:59:59'.'" ');
					
					}
				
			}
			// yang tidak transaksi
			else
			{
				
				//Range Bulan Diisi
				$mo =	date('m');
				$year = date('y');
				if($month!="")
				{
					$this->db->where('product_orders.id_product not in ("'.$product.'") AND product_orders.date between "'.$year.'-'.$month.'-01 00:00:00'.'" AND  "'.$year.'-'.$month.'-31 23:59:59'.'" ');
				}
				//Range Bulan tidak diisi
				else
				{
					$this->db->where('product_orders.id_product not in ("'.$product.'") AND product_orders.date between "'.$year.'-'.$mo.'-01 00:00:00'.'" AND  "'.$year.'-'.$mo.'-31 23:59:59'.'" ');
					
				}
			}
		
		
		}
		else
		{
			
			$this->db->limit(1);
			$this->db->join('product_orders', 'product_orders.customer_code = store.customer_code',"left");
			
			//yang transaksi
			if($transaction_month=="yes")
			{
				//Range Bulan Diisi
				$mo =	date('m');
				$year = date('y');
				if($month!="")
				{
					$this->db->where('product_orders.date between "'.$year.'-'.$month.'-01 00:00:00'.'" AND  "'.$year.'-'.$month.'-31 23:59:59'.'" ');
				}
				//Range Bulan tidak diisi
				else
				{
					$this->db->where('product_orders.date between "'.$year.'-'.$mo.'-01 00:00:00'.'" AND  "'.$year.'-'.$mo.'-31 23:59:59'.'" ');
					
				}
				
			}
			// yang tidak transaksi
			else
			{
				
				//Range Bulan Diisi
				$mo =	date('m');
				$year = date('y');
				if($month!="")
				{
					$this->db->where('product_orders.date between "'.$year.'-'.$month.'-01 00:00:00'.'" AND  "'.$year.'-'.$month.'-31 23:59:59'.'" AND product_orders.customer_code IS Null ');
				}
				//Range Bulan tidak diisi
				else
				{
					$this->db->where('product_orders.date between "'.$year.'-'.$mo.'-01 00:00:00'.'" AND  "'.$year.'-'.$mo.'-31 23:59:59'.'"  AND product_orders.customer_code IS Null ');
					
				}
			}
			
			
		}
		

		
		
		
		
		
		
		
		
		return $query = $this->db->get('store',$sampai,$dari)->result();
	}
	
	
	
	public function countStore($search_term="",$user_role,$code_role){
		if($user_role=="Ado")
		{
			$this->db->where('distributor_code = "'.$code_role.'" ');
		}
		$this->db->like('customer_code', $search_term);
		return $this->db->get('store')->num_rows();
	}
	
	public function dataStore($sampai,$dari,$search_term="",$user_role,$code_role){
		if($user_role=="Ado")
		{
			$this->db->where('distributor_code = "'.$code_role.'" ');
		}
		$this->db->like('customer_code', $search_term);
		return $query = $this->db->get('store',$sampai,$dari)->result();
	}
	
	
	
	
	
	
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	public function getStore($where="")
	{
		$data = $this->db->query("SELECT * FROM store ".$where);
		return $data;
		}
	
	public function getDistributor($where="")
	{
		$data = $this->db->query("SELECT * FROM distributor ".$where);
		return $data;
		}
	
	
	public function getMotorist($where="")
	{
		$data = $this->db->query("SELECT * FROM motorist ".$where);
		return $data;
		}
	
	
	public function getChannel($where="")
	{
		$data = $this->db->query("SELECT * FROM channel ".$where);
		return $data;
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