<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_order extends CI_Model{

	
	public function countOrderMonthly($search_term="",$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor){
		
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
		
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
	
		
		if($regional!="")
		{
			$this->db->where('distributor.regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		//$this->db->where("product_orders.id_product in (1,41) ");
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.") ");
		}
		
		$month_now = date('m');
		$year_now = date('Y');
	
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' ");  
		}
		else
		{
			$this->db->where("product_orders.date BETWEEN  '".$year_now."-".$month_now."-01 00:00:00' AND '".$year_now."-".$month_now."-31 23:59:59' "); 
			
			}
		
		if($search_term!="")
		{
			$this->db->where("store.motorist_code LIKE '%".$search_term."%' ");
		}
	
		$this->db->where("store.customer_status = 'active' ");
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		$this->db->join('motorist', 'motorist.id_motorist = product_orders.id_motorist');
		
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('store', 'store.customer_code = product_orders.customer_code');
		$this->db->group_by('product_orders.customer_code');
		$this->db->group_by('product_orders.id_product');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		return $this->db->get('product_orders')->num_rows();
	}
	
	public function dataOrderMonthly($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor){
		
		
			
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
		
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		if($regional!="")
		{
			$this->db->where('distributor.regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		//$this->db->where("product_orders.id_product in (1,41) ");
		
		if($search_term!="")
		{
			$this->db->where("store.motorist_code LIKE '%".$search_term."%' ");
		}
		
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.") ");
		}
		
		$month_now = date('m');
		$year_now = date('Y');
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
			
	
		}
		else
		{
			$this->db->where("product_orders.date BETWEEN  '".$year_now."-".$month_now."-01 00:00:00' AND '".$year_now."-".$month_now."-31 23:59:59' "); 
			
			
	
			}
		
		
	
	
		
		$this->db->where("store.customer_status = 'active' ");
		
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		$this->db->join('motorist', 'motorist.id_motorist = product_orders.id_motorist');
		
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('store', 'store.customer_code = product_orders.customer_code');
		$this->db->group_by('product_orders.customer_code');
		$this->db->group_by('product_orders.id_product');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		return $query = $this->db->get('product_orders',$sampai,$dari)->result();
	}
	
	
	public function countOrder($search_term="",$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor){
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
		
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		
		
		if($regional!="")
		{
			$this->db->where('distributor.regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		//$this->db->where("product_orders.id_product in (1,41) ");
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.") ");
		}
		
			if($search_term!="")
		{
			$this->db->where("store.motorist_code LIKE '%".$search_term."%' ");
		}
		
		$month_now = date('m');
		$year_now = date('Y');
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' ");  
		}
		else
		{
			$this->db->where("product_orders.date BETWEEN  '".$year_now."-".$month_now."-01 00:00:00' AND '".$year_now."-".$month_now."-31 23:59:59' "); 
			
			}
		
	
		$this->db->where("store.customer_status = 'active' ");
		$this->db->join('store', 'store.customer_code = product_orders.customer_code',"LEFT");
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		$this->db->join('motorist', 'motorist.id_motorist = product_orders.id_motorist');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		 
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type',"LEFT");
		
		return $this->db->get('product_orders')->num_rows();
	}
	
	public function dataOrder($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$date,$regional,$motorist_type,$product,$area,$distributor){
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
		
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		
		if($search_term!="")
		{
			$this->db->where("store.motorist_code LIKE '%".$search_term."%' ");
		}
		
		if($regional!="")
		{
			$this->db->where('distributor.regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('distributor.area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		//$this->db->where("product_orders.id_product in (1,41) ");
		
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.") ");
		}
		
		$month_now = date('m');
		$year_now = date('Y');
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("product_orders.date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		else
		{
			$this->db->where("product_orders.date BETWEEN  '".$year_now."-".$month_now."-01 00:00:00' AND '".$year_now."-".$month_now."-31 23:59:59' "); 
			
			}
		
		$this->db->where("store.customer_status = 'active' ");
		
		$this->db->join('store', 'store.customer_code = product_orders.customer_code',"LEFT"); 
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		$this->db->join('motorist', 'motorist.id_motorist = product_orders.id_motorist');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->group_by('store.customer_code'); 
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type',"LEFT");
		
		
		
		return $query = $this->db->get('product_orders',$sampai,$dari)->result();
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
	
	public function getNoo($where="")
	{
		$data = $this->db->query("SELECT * FROM noo ".$where);
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
	
	public function getMotoristType($where="")
		{
		$data = $this->db->query("SELECT * FROM motorist_type ".$where);
		return $data;
		}
	
public function getProduct($where="")
	{
		$data = $this->db->query("SELECT * FROM product ".$where);
		return $data;
	}

	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */