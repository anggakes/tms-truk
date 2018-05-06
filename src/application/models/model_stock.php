<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_stock extends CI_Model{

	

	public function countSummaryStock($search_term="",$user_role,$code_role,$ket,$bulan,$year,$regional,$motorist_type,$area,$distributor){
		
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
		
		$this->db->like('motorist.motorist_code', $search_term);
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code','left');
		return $this->db->get('motorist')->num_rows();
	}
	
	public function dataSummaryStock($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$bulan,$year,$regional,$motorist_type,$area,$distributor){
		
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
		
		
		$this->db->select(" *,(SELECT SUM(stock) FROM stock as s WHERE s.id_motorist = motorist.id_motorist  AND date between '".$tanggal_bulan_awal."' AND '".$tanggal_bulan_akhir."') as total_stock_all");
		
		$this->db->where("motorist.motorist_type in (".$ket.") ");
		if($user_role=="Ado")
		{
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		$this->db->like('motorist.motorist_code', $search_term);
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type','left');
		$this->db->join('distributor', 'distributor.distributor_code = motorist.distributor_code','left');
		return $query = $this->db->get('motorist',$sampai,$dari)->result();
	}
	
	
	
	public function countAbsence($search_term="",$user_role,$code_role,$date){
		if($user_role=="Ado")
		{
			$this->db->where('distributor_code = "'.$code_role.'" ');
		}
		
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("absence.date_absence BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		if($user_role=="Ado")
		{
			$this->db->where('motorist.distributor_code = "'.$code_role.'" ');
		}
		$this->db->like('motorist.motorist_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = absence.motorist_code','left');
		
		return $this->db->get('absence')->num_rows();
	}
	
	public function dataAbsence($sampai,$dari,$search_term="",$user_role,$code_role,$date){
		
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("absence.date_absence BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		if($user_role=="Ado")
		{
			$this->db->where('motorist.distributor_code = "'.$code_role.'" ');
		}
		$this->db->like('motorist.motorist_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = absence.motorist_code','left');
		return $query = $this->db->get('absence',$sampai,$dari)->result();
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
	
	


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */