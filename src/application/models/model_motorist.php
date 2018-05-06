<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_motorist extends CI_Model{

	
	public function countStoreJourney($user_role,$code_role,$ket,$motorist_code,$distributor_code,$day_visit,$frequently){
		
		if($motorist_code!='')
		{$this->db->where("store.motorist_code = '".$motorist_code."' ");}
		
		if($distributor_code!='')
		{$this->db->where("store.distributor_code = '".$distributor_code."' ");}
		
		if($day_visit!='')
		{$this->db->where("store.day_visit = '".$day_visit."' ");}
		
		if($frequently!='')
		{$this->db->where('store.frequency in ('.$frequently.') ');}
		//$this->db->join('noo', 'noo.latitude = store.latitude AND noo.longitude = store.longitude AND noo.motorist_code = store.motorist_code',"LEFT");
		return $this->db->get('store')->num_rows();
	}
	
	public function dataStoreJourney($sampai,$dari,$user_role,$code_role,$ket,$motorist_code,$distributor_code,$day_visit,$frequently){
		
		
		if($motorist_code!='')
		{$this->db->where("store.motorist_code = '".$motorist_code."' ");}
		
		if($distributor_code!='')
		{$this->db->where("store.distributor_code = '".$distributor_code."' ");}
		
		if($day_visit!='')
		{$this->db->where("store.day_visit = '".$day_visit."' ");}
		
		
		if($frequently!='')
		{$this->db->where('store.frequency in ('.$frequently.') ');}
		
		
		
		return $query = $this->db->get('store',$sampai,$dari)->result();
	}
	
	
	
	public function countNooSwitching($search_term="",$bulan,$tahun,$user_role,$code_role,$ket,$regional,$area,$distributor){
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
			$this->db->where('regional in ('.$regional.') ');
		}
		
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}

		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataNooSwitching($sampai,$dari,$bulan_2,$tahun,$search_term="",$user_role,$code_role,$ket,$regional,$area,$distributor){
		
		date_default_timezone_set('Asia/Jakarta');
		
		$year = date('Y');
		if($tahun!="")
		{$year=$tahun;}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		
		
		
		
		
		
		$tanggal_bulan_awal = $year."-01-01 00:00:00";
		$tanggal_bulan_akhir = $year."-01-31 23:59:59";
		
		$this->db->select(" * ,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-01-01 00:00:00'."' AND '".$year.'-01-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_januari,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-02-01 00:00:00'."' AND '".$year.'-02-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_februari,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-03-01 00:00:00'."' AND '".$year.'-03-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_maret,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-04-01 00:00:00'."' AND '".$year.'-04-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_april,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-05-01 00:00:00'."' AND '".$year.'-05-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_mei,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-06-01 00:00:00'."' AND '".$year.'-06-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_juni,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-07-01 00:00:00'."' AND '".$year.'-07-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_juli,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-08-01 00:00:00'."' AND '".$year.'-08-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_agustus,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-09-01 00:00:00'."' AND '".$year.'-09-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_september,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-10-01 00:00:00'."' AND '".$year.'-10-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_oktober,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-11-01 00:00:00'."' AND '".$year.'-11-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_november,
		(SELECT COUNT(id_store) FROM store as n WHERE motorist.motorist_code = n.motorist_code AND motorist.distributor_code = n.distributor_code AND n.customer_create_date between '".$year.'-12-01 00:00:00'."' AND '".$year.'-12-31 23:59:59'."' AND n.product = 'Bukan_Carnation' ) as total_store_desember");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->where("motorist.motorist_type = '2' ");
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	
	
	public function countOutletSwitching($search_term="",$bulan,$tahun,$user_role,$code_role,$ket,$regional,$motorist_type){
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
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		

		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataOutletSwitching($sampai,$dari,$bulan_2,$tahun,$search_term="",$user_role,$code_role,$ket,$regional,$motorist_type){
		
		date_default_timezone_set('Asia/Jakarta');
		
		$year = date('Y');
		if($tahun!="")
		{$year=$tahun;}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		$tanggal_bulan_awal = $year."-01-01 00:00:00";
		$tanggal_bulan_akhir = $year."-01-31 23:59:59";
		
		$this->db->select(" * ,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-01-01 00:00:00'."' AND '".$year.'-01-31 23:59:59'."' ) as total_store_januari,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-02-01 00:00:00'."' AND '".$year.'-02-29 23:59:59'."' ) as total_store_februari,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-03-01 00:00:00'."' AND '".$year.'-03-31 23:59:59'."' ) as total_store_maret,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-04-01 00:00:00'."' AND '".$year.'-04-31 23:59:59'."' ) as total_store_april,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-05-01 00:00:00'."' AND '".$year.'-05-31 23:59:59'."' ) as total_store_mei,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-06-01 00:00:00'."' AND '".$year.'-06-31 23:59:59'."' ) as total_store_juni,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-07-01 00:00:00'."' AND '".$year.'-07-31 23:59:59'."' ) as total_store_juli,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-08-01 00:00:00'."' AND '".$year.'-08-31 23:59:59'."' ) as total_store_agustus,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-09-01 00:00:00'."' AND '".$year.'-09-31 23:59:59'."' ) as total_store_september,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-10-01 00:00:00'."' AND '".$year.'-10-31 23:59:59'."' ) as total_store_oktober,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-11-01 00:00:00'."' AND '".$year.'-11-31 23:59:59'."' ) as total_store_november,
		(SELECT COUNT(customer_code) FROM store as s WHERE motorist.motorist_code = s.motorist_code AND motorist.distributor_code = s.distributor_code AND s.customer_create_date between '".$year.'-12-01 00:00:00'."' AND '".$year.'-12-31 23:59:59'."' ) as total_store_desember");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	
	public function countSalesSummaryAdo($search_term="",$user_role,$code_role,$ket){
		$this->db->like('motorist_code', $search_term);
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataSalesSummaryAdo($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$date){
		
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l');
		
		$date_now = date('Y-m-d');
		
		if($date!="")
		{
			$tanggal_pecah = explode("/", $date);
			$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		    $date_convert = date_create($date_now);
			$day = date_format($date_convert,"l");

		}
		$this->db->select(" * ,(SELECT setoran FROM absence as a WHERE a.motorist_code = motorist.motorist_code AND a.distributor_code = motorist.distributor_code AND date_absence LIKE '%".$date_now."%' limit 1) as total_daily_setoran,
		(SELECT SUM(price_total) FROM product_orders as o WHERE o.id_motorist = motorist.id_motorist AND date LIKE '%".$date_now."%') as total_daily_sales
		");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	public function countDailySummaryAdo($search_term="",$user_role,$code_role,$ket){
		$this->db->like('motorist_code', $search_term);
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataDailySummaryAdo($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$date){
		
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l');
		
		$date_now = date('Y-m-d');
		
		if($date!="")
		{
			$tanggal_pecah = explode("/", $date);
			$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		    $date_convert = date_create($date_now);
			$day = date_format($date_convert,"l");

		}
		$this->db->select(" * ,(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = distributor.distributor_code AND s.day_visit = '".$day."') as target_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND time_stamp_visit LIKE '%".$date_now."%') as total_call,
		(SELECT COUNT(id_noo) FROM noo as n WHERE n.motorist_code = motorist.motorist_code AND n.distributor_code = motorist.distributor_code AND customer_create_date LIKE '%".$date_now."%') as total_new_customer,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%') as total_effective_call
		");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	public function countMapMotorist($search_term="",$motorist_code,$distributor_code){

		$this->db->like('motorist_name', $search_term);
		$this->db->where("status_latitude = 'yes' AND motorist_code = '".$motorist_code."' AND distributor_code = '".$distributor_code."' ");
		return $this->db->get('store')->num_rows();
	}
	
	public function dataMapMotorist($sampai,$dari,$search_term="",$motorist_code,$distributor_code){

		$this->db->like('motorist_name', $search_term);
		$this->db->where("status_latitude = 'yes' AND motorist_code = '".$motorist_code."' AND distributor_code = '".$distributor_code."' ");
		return $query = $this->db->get('store',$sampai,$dari)->result();
		
	}
	
	
	public function countCallStrikeSidebar($user_role,$code_role,$id_motorist,$date){
		
		
		
		if($date!="")
		{
		$tanggal_pecah = explode("/", $date);
		$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
		}
		
		if($id_motorist!="")
		{
			$this->db->where("visit.id_motorist = '".$id_motorist."' ");
		
		
		
		return $this->db->get('visit')->num_rows();}
	}
	
	
	
	public function dataCallStrikeSidebar($sampai,$dari,$user_role,$code_role,$id_motorist,$date){
		
		
		if($date!="")
		{
		$tanggal_pecah = explode("/", $date);
		$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
		}
		
		if($id_motorist!="")
		{
		$this->db->where("visit.id_motorist = '".$id_motorist."' ");
		$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
		$this->db->order_by("visit.jam_checkin","asc");
		return $query = $this->db->get('visit',$sampai,$dari)->result();
		}
	}
	
	public function countCallStrike($user_role,$code_role,$id_motorist,$date){
		
		
		$tanggal_pecah = explode("/", $date);
		$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		
		$this->db->where("visit.id_motorist = '".$id_motorist."' ");
		$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
		$this->db->order_by("visit.jam_checkin","asc");
		return $this->db->get('visit')->num_rows();
	}
	
	
	
	public function dataCallStrike($sampai,$dari,$user_role,$code_role,$id_motorist,$date){
		

		
	
		$tanggal_pecah = explode("/", $date);
		$date_now = $tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
		
		$this->db->where("visit.id_motorist = '".$id_motorist."' ");
		$this->db->where("time_stamp_visit LIKE '%".$date_now."%' ");
		$this->db->order_by("visit.jam_checkin","asc");
		return $query = $this->db->get('visit',$sampai,$dari)->result();
		
	}

	
	
	public function countMotorist($search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor){
		
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
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('distributor.distributor_code in ('.$distributor.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataMotorist($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor){
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		
		
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('distributor.distributor_code in ('.$distributor.') ');
		}
		
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	
	
	public function countDailyCallstrike($search_term=""){
		//$this->db->like('motorist.motorist_name', $search_term);
		//$this->db->like('motorist.motorist_name', $search_term);
		//$this->db->or_like('motorist.motorist_code', $search_term);
		//$this->db->join('motorist', 'motorist.id_motorist = orders.id_motorist');
		//$this->db->join('store', 'orders.id_store = store.id_store');
		return $this->db->get('orders')->num_rows();
	}
	
	public function dataDailyCallstrike($sampai,$dari,$search_term=""){
		//$this->db->like('motorist.motorist_name', $search_term);
		//$this->db->or_like('motorist.motorist_code', $search_term);
		//$this->db->join('motorist', 'motorist.id_motorist = orders.id_motorist');
		//$this->db->join('store', 'store.id_store = orders.id_store');
		return $query = $this->db->get('orders',$sampai,$dari)->result();
		
	}
	
	
	public function countDailySummary($search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor){
		$this->db->like('motorist_code', $search_term);
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataDailySummary($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$date,$regional,$motorist_type,$area,$distributor){
		
		date_default_timezone_set('Asia/Jakarta');
		
		$day = date('l');
		
		
		
		$date_now = date('Y-m-d');
		$date_convert = date_create($date_now);
		$day = date_format($date_convert,"l");
		if($date!="")
		{
			$tanggal_pecah = explode("/", $date);
			$date_now=$tanggal_pecah[2].'-'.$tanggal_pecah[0].'-'.$tanggal_pecah[1];
			$date_convert = date_create($date_now);
			$day = date_format($date_convert,"l");
		}
		$this->db->select(" * ,(SELECT COUNT(id_store) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND s.day_visit = '".$day."' AND customer_status = 'active' ) as target_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND time_stamp_visit LIKE '%".$date_now."%') as total_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'extra_call' AND time_stamp_visit LIKE '%".$date_now."%') as total_extra_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'order' AND time_stamp_visit LIKE '%".$date_now."%') as total_effective_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'extra_call' AND time_stamp_visit LIKE '%".$date_now."%') as total_extra_effective_call,
		(SELECT SUM(price_total) FROM product_orders as p WHERE p.id_motorist = motorist.id_motorist AND date LIKE '%".$date_now."%') as total_daily_sales,
		(SELECT setoran FROM absence as a WHERE a.motorist_code = motorist.motorist_code AND a.distributor_code = motorist.distributor_code AND date_absence LIKE '%".$date_now."%' limit 1) as total_daily_setoran
		");
		
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
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	
	public function countJourneyMotorist($search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor){
		$this->db->like('motorist_code', $search_term);
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function journeyMotorist($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor){
		
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l');
		$date_now = date('Y-m-d');
		
		$this->db->select(" * ,(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND customer_status = 'active' AND frequency = 'f2' AND s.distributor_code = motorist.distributor_code AND s.day_visit = 'monday') as f2_monday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'monday') as f1_monday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'monday') as w_monday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'tuesday') as f1_tuesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'tuesday') as f2_tuesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'tuesday') as w_tuesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'wednesday') as f2_wednesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'wednesday') as f1_wednesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'wednesday') as w_wednesday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'thursday') as f2_thursday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'thursday') as f1_thursday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code  AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'thursday') as w_thursday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'friday') as f2_friday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'friday') as f1_friday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'friday') as w_friday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F2' AND s.day_visit = 'saturday') as f2_saturday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code  AND customer_status = 'active' AND frequency = 'W' AND s.day_visit = 'saturday') as w_saturday,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active' AND frequency = 'F1' AND s.day_visit = 'saturday') as f1_saturday
		
		");
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	
	public function countMonthlySummary($search_term="",$bulan,$tahun,$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor){
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
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		

		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataMonthlySummary($sampai,$dari,$bulan_2,$tahun,$search_term="",$user_role,$code_role,$ket,$regional,$motorist_type,$area,$distributor){
		
		date_default_timezone_set('Asia/Jakarta');
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		$bulan = date('m');
		if($bulan_2!="")
		{$bulan=$bulan_2;}
		
		$year = date('Y');
		if($tahun!="")
		{$year=$tahun;}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($distributor!="")
		{
			
			$this->db->where('motorist.distributor_code in ('.$distributor.') ');
		}
		if($area!="")
		{
			$this->db->where('area in ('.$area.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		
		$this->db->select(" * ,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code ) as target_call,
		(SELECT COUNT(id_noo) FROM noo as n WHERE n.motorist_code = motorist.motorist_code AND n.distributor_code = motorist.distributor_code AND customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_noo,
		(SELECT COUNT(id_store) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_create_date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_store,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_extra_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'order' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_effective_call,
		(SELECT COUNT(customer_code) FROM visit as v WHERE v.id_motorist = motorist.id_motorist AND status_visit = 'call' AND status_order = 'extra_call' AND time_stamp_visit between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_extra_effective_call,
		(SELECT SUM(total_order) FROM orders as o WHERE o.id_motorist = motorist.id_motorist AND date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_monthly_sales,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code) as total_outlet,
		(SELECT COUNT(customer_code) FROM store as s WHERE s.motorist_code = motorist.motorist_code AND s.distributor_code = motorist.distributor_code AND customer_status = 'active') as total_outlet_active");
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");		
		}
		$this->db->like('motorist_code', $search_term);
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
		
	}
	
	
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
		$this->db->select(" *,visit.jam_checkin as waktu_visit,visit.latitude as latitude,visit.longitude as longitude ,(SELECT COUNT(id_order) FROM product_orders as p WHERE p.id_order = orders.id_order ) as total_sku");
 		$this->db->from('visit');
		$this->db->where($where);
  		$this->db->join('orders', 'orders.id_order = visit.id_order',"LEFT");
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