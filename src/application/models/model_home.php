<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_home extends CI_Model{

	
	public function dataChartActiveAug($search_term="",$user_role,$code_role,$jenis_motorist,$regional,$product){
				
		$this->db->select('id_product_order,customer_code');
		$this->db->group_by('customer_code');
		$this->db->where("date between '2016-08-01 00:00:00' AND '2016-08-31 23:59:59'");
		if($jenis_motorist!="")
		{
			$this->db->where("type in (".$jenis_motorist.")");
		}
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.")");
		}
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		return $data = $this->db->get('product_orders');
		return $data;
		
	}
	
	public function dataChartActiveSept($search_term="",$user_role,$code_role,$jenis_motorist,$regional,$product){
		$this->db->select('id_product_order,customer_code');
		$this->db->group_by('customer_code');
		$this->db->where("date between '2016-09-01 00:00:00' AND '2016-09-31 23:59:59'");
		if($jenis_motorist!="")
		{
			$this->db->where("type in (".$jenis_motorist.")");
		}
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.")");
		}
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		return $data = $this->db->get('product_orders');
		return $data;
	}
	
	
	public function dataKontActiveAug($search_term="",$user_role,$code_role,$jenis_motorist,$regional,$product){
		if($product=="")
		{$data = $this->db->query("SELECT id_product_order FROM product_orders group by customer_code");}
		else
		{$data = $this->db->query('SELECT id_product_order FROM product_orders WHERE id_product in ("'.$product.'")  group by customer_code');}
		return $data;
	}
	

	
	public function dataChartSttAug($search_term="",$user_role,$code_role,$jenis_motorist,$regional,$product){
		
		$this->db->select('SUM(price_total) as price_total');
		
		$this->db->where("date between '2016-08-01 00:00:00' AND '2016-08-31 23:59:59'");	
		if($jenis_motorist!="")
		{
			$this->db->where("type in (".$jenis_motorist.")");
		}
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.")");
		}
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		return $data = $this->db->get('product_orders');
		return $data;
	}
	
	public function dataChartSttSep($search_term="",$user_role,$code_role,$jenis_motorist,$regional,$product){
		
		$this->db->select('SUM(price_total) as price_total');
		
		$this->db->where("date between '2016-09-01 00:00:00' AND '2016-09-31 23:59:59'");	
		if($jenis_motorist!="")
		{
			$this->db->where("type in (".$jenis_motorist.")");
		}
		if($product!="")
		{
			$this->db->where("product_orders.id_product in (".$product.")");
		}
		$this->db->join('product', 'product.id_product = product_orders.id_product');
		return $data = $this->db->get('product_orders');
		return $data;
	}
	
	
	public function dataKontSttAug($search_term="",$user_role,$code_role,$jenis_motorist,$regional,$product){
		
		if($product=="")
		{$data = $this->db->query("SELECT SUM(price_total) as price_total FROM product_orders ");}
		else
		{$data = $this->db->query('SELECT SUM(price_total) as price_total FROM product_orders WHERE id_product in ("'.$product.'")');}
		return $data;
		
	}
	
	
	
	public function countSummaryAbsence($search_term="",$user_role,$code_role,$bulan,$year){
		
		if($user_role=="Ado")
		{
			$this->db->where('motorist.distributor_code = "'.$code_role.'" ');
		}
		
		$this->db->like('motorist.motorist_code', $search_term);
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code','left');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataSummaryAbsence($sampai,$dari,$search_term="",$user_role,$code_role,$bulan,$year){
		
		if($bulan!="")
		{$bulan=$bulan;}
		else
		{$bulan = date('m');}
		
		if($year!="")
		{$year=$tahun;}
		else
		{$year = date('Y');}
		
		$tanggal_bulan_awal = $year.'-'.$bulan."-01 00:00:00";
		$tanggal_bulan_akhir = $year.'-'.$bulan."-31 23:59:59";
		
		
		$this->db->select(" * ,(SELECT COUNT(id_absence) FROM absence as a WHERE a.motorist_code = motorist.motorist_code AND status_absence = 'hadir' AND date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ) as total_hadir
		,(SELECT COUNT(id_absence) FROM absence as a WHERE a.motorist_code = motorist.motorist_code AND status_absence = 'sakit' AND date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ) as total_sakit
		,(SELECT COUNT(id_absence) FROM absence as a WHERE a.motorist_code = motorist.motorist_code AND status_absence = 'izin' AND date_absence between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."' ) as total_izin");
		
		if($user_role=="Ado")
		{
			$this->db->where('motorist.distributor_code = "'.$code_role.'" ');
		}
		$this->db->like('motorist.motorist_code', $search_term);
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code','left');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
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
	
	public function getAbsence($where="")
	{
		$data = $this->db->query("SELECT * FROM absence ".$where);
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
	
		public function getArea($where=" ")
	{
		$data = $this->db->query("SELECT * FROM master_area ".$where);
		return $data;
	}
	
	public function getMotoristType($where="")
	{
		$data = $this->db->query("SELECT * FROM motorist_type ".$where);
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
	
	public function getProduct($where="")
	{
		$data = $this->db->query("SELECT * FROM product ".$where);
		return $data;
	}
	
	





	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */