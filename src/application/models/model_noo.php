<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_noo extends CI_Model{

	

	public function detailStore($id_store){
		//echo $code_role.$user_role;
		$this->db->where('id_store = "'.$id_store.'" ');
		$this->db->join('noo', 'store.customer_contact = noo.customer_contact AND store.distributor_code = noo.distributor_code AND store.motorist_code = noo.motorist_code AND store.latitude = noo.latitude  AND store.longitude = noo.longitude  ');
		return $query = $this->db->get('store')->result_array();
	}
	
	
	
	public function countNoo($search_term="",$user_role,$code_role,$ket,$date,$regional,$motorist_type,$distributor){
		
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
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
			
			$this->db->where("noo.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		
		if($user_role=="Ado")
		{
			if($ket=="sergap")
			{$this->db->where("motorist.motorist_type in (3,4) ");}
		    else
			{
			$this->db->where("motorist.motorist_type in (1,2) ");
			}
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			if($ket=="sergap")
			{$this->db->where("motorist.motorist_type in (3,4) ");}
		    else
			{
			$this->db->where("motorist.motorist_type in (1,2) ");
			}
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		
		
		$this->db->like('noo.motorist_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = noo.motorist_code AND motorist.distributor_code = noo.distributor_code  ');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('distributor', 'distributor.distributor_code = noo.distributor_code');
		return $this->db->get('noo')->num_rows();
	}
	
	public function dataNoo($sampai,$dari,$search_term="",$user_role,$code_role,$ket,$date,$regional,$motorist_type,$distributor){
		//echo $code_role.$user_role;
		if($date != '')
		{
			$tanggal_range_pecah = explode(" - ", $date);
			$tanggal_from = $tanggal_range_pecah[0];
			$tanggal_from = explode("/", $tanggal_from);
			$tanggal_from = $tanggal_from[2].'-'.$tanggal_from[0].'-'.$tanggal_from[1];
			
			$tanggal_to = $tanggal_range_pecah[1];
			$tanggal_to = explode("/", $tanggal_to);
			$tanggal_to = $tanggal_to[2].'-'.$tanggal_to[0].'-'.$tanggal_to[1];
			
			$this->db->where("noo.customer_create_date BETWEEN '".$tanggal_from." 00:00:00' AND '".$tanggal_to." 23:59:59' "); 
		}
		
		if($regional!="")
		{
			$this->db->where('regional in ('.$regional.') ');
		}
		
		if($motorist_type!="")
		{
			$this->db->where('motorist.motorist_type in ('.$motorist_type.') ');
		}
		
		if($user_role=="Administrator" || $user_role=="Regional")
		{
			if($distributor!='')
			{
				$this->db->where("motorist.distributor_code = '".$distributor."' ");
				
				}
		}
		
		if($user_role=="Ado")
		{
			if($ket=="sergap")
			{$this->db->where("motorist.motorist_type in (3,4) ");}
		    else
			{
			$this->db->where("motorist.motorist_type in (1,2) ");
			}
			$this->db->where("motorist.distributor_code = '".$code_role."' ");
		}
		else if($user_role=="Regional")
		{
			if($ket=="sergap")
			{$this->db->where("motorist.motorist_type in (3,4) ");}
		    else
			{
			$this->db->where("motorist.motorist_type in (1,2) ");
			}
			$this->db->where("distributor.regional = '".$code_role."' ");
				
		}
		
		
		$this->db->like('noo.motorist_code', $search_term);
		$this->db->join('motorist', 'motorist.motorist_code = noo.motorist_code AND motorist.distributor_code = noo.distributor_code  ');
		$this->db->join('motorist_type', 'motorist_type.id_motorist_type = motorist.motorist_type');
		$this->db->join('distributor', 'distributor.distributor_code = noo.distributor_code');
		return $query = $this->db->get('noo',$sampai,$dari)->result();
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


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */