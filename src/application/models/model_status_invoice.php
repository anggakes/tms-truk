<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_status_invoice extends CI_Model{

	

	
	
	public function countStatusInvoice($search_term=""){
		
		$this->db->or_like('manifest', $search_term);
		$this->db->or_like('do_number', $search_term);
		$this->db->join('master_manifest', 'master_manifest.id_manifest = transport_order.manifest','LEFT');
		return $this->db->get('transport_order')->num_rows();
	}
	
	public function dataStatusInvoice($sampai,$dari,$search_term=""){
		$this->db->select("*,transport_order.origin_id as origin_id_echo,transport_order.origin_address as origin_address_echo,transport_order.destination_id as destination_id_echo,transport_order.destination_address as destination_address_echo ");
		$this->db->or_like('manifest', $search_term);
		$this->db->or_like('do_number', $search_term);
		$this->db->join('master_manifest', 'master_manifest.id_manifest = transport_order.manifest','LEFT');
		return $query = $this->db->get('transport_order',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getIo($where="")
	{
		$data = $this->db->query("SELECT * FROM master_io ".$where);
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