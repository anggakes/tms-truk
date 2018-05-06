<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_truck_absent extends CI_Model{

	
	public function countTruckAbsentFilter($search_term=""){
		$this->db->like('vehicle_id', $search_term);
		$this->db->where("action_kelengkapan_oli_mesin = 'Tidak Baik' 
		OR action_kecukupan_air_radioator = 'Tidak Baik' 
		OR action_kondisi_ban = 'Tidak Baik' 
		OR action_kondisi_accu = 'Tidak Baik' 
		OR action_kontrol_lampu = 'Tidak Baik' 
		OR action_angin_untuk_rem = 'Tidak Baik' 
		OR action_test_mesin = 'Tidak Baik' 
		OR 	action_kondisi_body_truck = 'Tidak Baik' 
		OR action_kecukupan_isi_solar = 'Tidak Baik' 
		OR action_kelengkapan_safety = 'Tidak Baik' 
		OR action_kelengkapan_document = 'Tidak Baik' 
		");
		return $this->db->get('truck_absent')->num_rows();
	}
	
	public function dataTruckAbsentFilter($sampai,$dari,$search_term=""){
		$this->db->like('vehicle_id', $search_term);
		$this->db->where("action_kelengkapan_oli_mesin = 'Tidak Baik' 
		OR action_kecukupan_air_radioator = 'Tidak Baik' 
		OR action_kondisi_ban = 'Tidak Baik' 
		OR action_kondisi_accu = 'Tidak Baik' 
		OR action_kontrol_lampu = 'Tidak Baik' 
		OR action_angin_untuk_rem = 'Tidak Baik' 
		OR action_test_mesin = 'Tidak Baik' 
		OR 	action_kondisi_body_truck = 'Tidak Baik' 
		OR action_kecukupan_isi_solar = 'Tidak Baik' 
		OR action_kelengkapan_safety = 'Tidak Baik' 
		OR action_kelengkapan_document = 'Tidak Baik' 
		");
		return $query = $this->db->get('truck_absent',$sampai,$dari)->result();
		
	}
	
	
	public function countTruckAbsent($search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		return $this->db->get('truck_absent')->num_rows();
	}
	
	public function dataTruckAbsent($sampai,$dari,$search_term=""){
		$this->db->or_like('vehicle_id', $search_term);
		return $query = $this->db->get('truck_absent',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getTruckAbsent($where="")
	{
		$data = $this->db->query("SELECT * FROM truck_absent ".$where);
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