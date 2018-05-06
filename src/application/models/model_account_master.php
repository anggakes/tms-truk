<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_account_master extends CI_Model{

	
	
	
	public function countAccount($search_term=""){
		$this->db->like('user_account.name', $search_term);
		$this->db->or_like('user_account.username', $search_term);
		$this->db->or_like('user_account.email', $search_term);
		$this->db->or_like('user_account.user_type', $search_term);
		$this->db->select('*');
		$this->db->from('user_account');
		$this->db->join('user_role', 'user_account.user_access = user_role.id_role');
		
		return $this->db->get()->num_rows();
	}
	
	public function dataAccount($sampai,$dari,$search_term=""){
		$this->db->like('user_account.name', $search_term);
		$this->db->or_like('user_account.username', $search_term);
		$this->db->or_like('user_account.email', $search_term);
		$this->db->or_like('user_account.user_type', $search_term);
		$this->db->select('*');
		$this->db->from('user_account');
		$this->db->join('user_role', 'user_account.user_access = user_role.id_role');
		
		return $query = $this->db->get('',$sampai,$dari)->result();
	}
	
	

	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
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
	
	public function getAccount($where=" ")
	{
		$data = $this->db->query("SELECT * FROM user_account ".$where);
		return $data;
	}
	
	public function getTransporter($where=" ")
	{
		$data = $this->db->query("SELECT * FROM transporter ".$where);
		return $data;
	}
	
	public function getDistributor($where=" ")
	{
		$data = $this->db->query("SELECT * FROM distributor_master ".$where);
		return $data;
	}
	
	public function getRole($where=" ")
	{
		$data = $this->db->query("SELECT * FROM user_role ".$where);
		return $data;
	}
	
	public function getRoleEtools($where=" ")
	{
		$data = $this->db->query("SELECT * FROM role_etools ".$where);
		return $data;
	}
	
	public function getStatusSeaTransporter($where=" ")
	{
		$data = $this->db->query("SELECT * FROM transporter ".$where);
		return $data;
	}
	
	public function getStatusLandTransporter($where=" ")
	{
		$data = $this->db->query("SELECT * FROM transporter ".$where);
		return $data;
	}

	
	
	
	


	
	
	
	
}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */