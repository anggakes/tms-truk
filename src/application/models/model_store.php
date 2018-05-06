<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_store extends CI_Model{

	
	public function countStoreStt($search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name){
			if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("regional = '".$code_role."' ");
				
		}
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code in (".$distributor.")  ");
				
				}
		}
		
		$this->db->like('customer_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('store')->num_rows();
	}
	
	public function dataStoreStt($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name){
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("regional = '".$code_role."' ");
				
		}
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code in (".$distributor.")  ");
				
				}
		}
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->like('customer_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('master_loyalty', 'master_loyalty.id_loyalty = store.loyalty_store',"LEFT");
		return $query = $this->db->get('store',$sampai,$dari)->result();
	}
	
	public function countStoreSwitching($user_role,$code_role,$bulan,$motorist_code,$distributor_code,$tahun){
		if($tahun!='')
		{$year = $tahun;}
	    else
		{$year = date('Y');}
		
		
		$this->db->where('store.product != "carnation" ');
		$this->db->where('store.distributor_code = "'.$distributor_code.'" ');
		$this->db->where('store.motorist_code = "'.$motorist_code.'" ');
		$this->db->where("store.customer_create_date between '".$year."-".$bulan."-01 00:00:00' AND  '".$year."-".$bulan."-31 23:59:59' ");
		return $this->db->get('store')->num_rows();
	}
	
	
	public function dataStoreSwitching($sampai,$dari,$user_role,$code_role,$bulan,$motorist_code,$distributor_code,$tahun){
		
		if($tahun!='')
		{$year = $tahun;}
	    else
		{$year = date('Y');}
		$this->db->select(" * ,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-01-01 00:00:00'."' AND '".$year.'-01-31 23:59:59'."' ) as total_order_januari,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-02-01 00:00:00'."' AND '".$year.'-02-31 23:59:59'."' ) as total_order_februari,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-03-01 00:00:00'."' AND '".$year.'-03-31 23:59:59'."' ) as total_order_maret,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-04-01 00:00:00'."' AND '".$year.'-04-31 23:59:59'."' ) as total_order_april,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-05-01 00:00:00'."' AND '".$year.'-05-31 23:59:59'."' ) as total_order_mei,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-06-01 00:00:00'."' AND '".$year.'-06-31 23:59:59'."' ) as total_order_juni,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-07-01 00:00:00'."' AND '".$year.'-07-31 23:59:59'."' ) as total_order_juli,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-08-01 00:00:00'."' AND '".$year.'-08-31 23:59:59'."' ) as total_order_agustus,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-09-01 00:00:00'."' AND '".$year.'-09-31 23:59:59'."' ) as total_order_september,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-10-01 00:00:00'."' AND '".$year.'-10-31 23:59:59'."' ) as total_order_oktober,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-11-01 00:00:00'."' AND '".$year.'-11-31 23:59:59'."' ) as total_order_november,
		(SELECT SUM(total_order) FROM orders as o WHERE store.customer_code = o.customer_code AND o.date between '".$year.'-12-01 00:00:00'."' AND '".$year.'-12-31 23:59:59'."' ) as total_order_desember");
		
		$this->db->where('store.product != "carnation" ');
		$this->db->where('store.distributor_code = "'.$distributor_code.'" ');
		$this->db->where('store.motorist_code = "'.$motorist_code.'" ');
		$this->db->where("store.customer_create_date between '".$year."-".$bulan."-01 00:00:00' AND  '".$year."-".$bulan."-31 23:59:59' ");
		return $query = $this->db->get('store',$sampai,$dari)->result();
	}
	
	
	
	public function filterMapTotal($distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$tahun){

		if($distributor!="")
		{
			
			$this->db->where('store.distributor_code in ('.$distributor.') ');
		}
		
		
		if($regional!="")
		{
			$this->db->where('store.regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('store.motorist_type in ('.$motorist_type.') ');
		}
		
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		$this->db->where("store.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("store.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("store.regional = '".$code_role."' ");
				
		}
		
		
		
		if($channel!="")
		{
			$this->db->where('channel_code in ('.$channel.') ');
		}
		
		if($day!="")
		{
			$this->db->where('day_visit in ('.$day.') ');
		}
		
		if($motorist!="")
		{
			$this->db->where('store.motorist_code in ('.$motorist.') ');
		}
		
		
		if($product!="")
		{
			$mo =	date('m');
			$year = date('y');
			if($tahun!='')
			{$year = $tahun;}
		
			if($month!="")
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$month-01 00:00:00' AND '$year-$month-31 00:00:00' ","LEFT");
			}
			else
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$mo-01 00:00:00' AND '$year-$mo-31 00:00:00' ","LEFT");
			}
				//yang transaksi
				if($transaction_month=="yes")
				{
				
					$this->db->where('product_orders.customer_code IS NOT NULL ');

				
				}
			// yang tidak transaksi
			else
			{
					//Range Bulan Diisi
					$this->db->where('product_orders.customer_code IS NULL ');
				
			}
			}
		
		$this->db->group_by('store.customer_code');
		return $query = $this->db->get('store')->num_rows();
	}
	

	public function countFilterMap($distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$tahun){
		
		
		if($distributor!="")
		{
			
			$this->db->where('store.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($regional!="")
		{
			$this->db->where('store.regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('store.motorist_type in ('.$motorist_type.') ');
		}
		
		
		
		$this->db->where("store.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("store.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("store.regional = '".$code_role."' ");
				
		}
		
		
		
		if($channel!="")
		{
			$this->db->where('channel_code in ('.$channel.') ');
		}
		
		if($day!="")
		{
			$this->db->where('day_visit in ('.$day.') ');
		}
		
		if($motorist!="")
		{
			$this->db->where('store.motorist_code in ('.$motorist.') ');
		}
		
		
		if($product!="")
		{
			$mo =	date('m');
			$year = date('y');
			if($tahun!='')
			{$year = $tahun;}
			if($month!="")
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$month-01 00:00:00' AND '$year-$month-31 00:00:00' ","LEFT");
			}
			else
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$mo-01 00:00:00' AND '$year-$mo-31 00:00:00' ","LEFT");
			}
				//yang transaksi
				if($transaction_month=="yes")
				{
				
					$this->db->where('product_orders.customer_code IS NOT NULL ');

				
				}
			// yang tidak transaksi
			else
			{
					//Range Bulan Diisi
					$this->db->where('product_orders.customer_code IS NULL ');
				
			}
			}
		
		$this->db->group_by('store.customer_code');
		return $this->db->get('store')->num_rows();
	}
	
	public function filterMap($sampai,$dari,$distributor,$channel,$motorist,$day,$product,$month,$transaction_month,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$tahun){
		$this->db->select(" * ,store.customer_code as customer_code_bayangan");
		if($distributor!="")
		{
			
			$this->db->where('store.distributor_code in ('.$distributor.') ');
		}
		
		
		if($regional!="")
		{
			$this->db->where('store.regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('store.motorist_type in ('.$motorist_type.') ');
		}
		
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		$this->db->where("store.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("store.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("store.regional = '".$code_role."' ");
				
		}
		
		
		
		if($channel!="")
		{
			$this->db->where('channel_code in ('.$channel.') ');
		}
		
		if($day!="")
		{
			$this->db->where('day_visit in ('.$day.') ');
		}
		
		if($motorist!="")
		{
			$this->db->where('store.motorist_code in ('.$motorist.') ');
		}
		
		
		if($product!="")
		{
			$mo =	date('m');
			
			$year = date('y');
			if($tahun!='')
			{$year = $tahun;}
			if($month!="")
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$month-01 00:00:00' AND '$year-$month-31 00:00:00' ","LEFT");
			}
			else
			{
				$this->db->join('product_orders', "store.customer_code = product_orders.customer_code AND  id_product in (".$product.") AND product_orders.date between '$year-$mo-01 00:00:00' AND '$year-$mo-31 00:00:00' ","LEFT");
			}
				//yang transaksi
				if($transaction_month=="yes")
				{
				
					$this->db->where('product_orders.customer_code IS NOT NULL ');

				
				}
			// yang tidak transaksi
			else
			{
					//Range Bulan Diisi
					$this->db->where('product_orders.customer_code IS NULL ');
				
			}
			}
			
		
		$this->db->group_by('store.customer_code');
		return $query = $this->db->get('store',$sampai,$dari)->result();
	}
	
	
	
	public function countStore($search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name,$area,$distributor){
			if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		$this->db->where("motorist.motorist_type in (1,3) ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("regional = '".$code_role."' ");
				
		}
		
		if($area!="")
		{
			$this->db->where('store.area in ('.$area.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('store.distributor_code in ('.$distributor.') ');
		}
		
		
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		
		$this->db->like('customer_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('store')->num_rows();
	}
	
	public function dataStore($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name,$area,$distributor){
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("regional = '".$code_role."' ");
				
		}
		
		if($area!="")
		{
			$this->db->where('store.area in ('.$area.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('store.distributor_code in ('.$distributor.') ');
		}
		
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->like('customer_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('master_loyalty', 'master_loyalty.id_loyalty = store.loyalty_store',"LEFT");
		return $query = $this->db->get('store',$sampai,$dari)->result();
	}
	
	
	
	
	
	
	public function countStockPoint($search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name){
			if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{	
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("regional = '".$code_role."' ");
				
		}
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		
		
		$this->db->where('channel_code = "00000" ');
		
		$this->db->like('customer_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('store')->num_rows();
	}
	
	public function dataStockPoint($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$motorist_code,$distributor,$date,$store_name){
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("store.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			
			$this->db->where("regional = '".$code_role."' ");
				
		}
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($store_name!="")
		{
			$this->db->where('customer_name LIKE "%'.$store_name.'%" ');
		}
		
		
		if($motorist_code!='')
		{
			$this->db->where("motorist.motorist_code = '".$motorist_code."' ");
		}
		
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		$this->db->where('channel_code = "00000" ');
		$this->db->like('customer_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = store.motorist_code AND motorist.distributor_code = store.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('master_loyalty', 'master_loyalty.id_loyalty = store.loyalty_store',"LEFT");
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
	


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */