<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_purchase_invoice extends CI_Model{

	
	public function countBankTransaction($search_term=""){
		$this->db->like('transaction.id_invoice', $search_term);
		$this->db->where('transaction.payment_method', 'bank');
		$this->db->join('master_bank_account', 'master_bank_account.id_master_bank_account = transaction.account','LEFT');
		$this->db->join('purchase_invoice', 'purchase_invoice.id_purchase_invoice = transaction.id_invoice','LEFT');
		return $this->db->get('transaction')->num_rows();
	}
	
	public function dataBankTransaction($sampai,$dari,$search_term=""){
		$this->db->like('transaction.id_invoice', $search_term);
		$this->db->where('transaction.payment_method', 'bank');
		$this->db->join('master_bank_account', 'master_bank_account.id_master_bank_account = transaction.account','LEFT');
		$this->db->join('purchase_invoice', 'purchase_invoice.id_purchase_invoice = transaction.id_invoice','LEFT');
		return $query = $this->db->get('transaction',$sampai,$dari)->result();
		
	}
	
	
	
	public function countCashTransaction($search_term=""){
		$this->db->like('transaction.id_invoice', $search_term);
		$this->db->where('transaction.payment_method', 'cash');
		$this->db->join('master_cash_account', 'master_cash_account.id_cash_account = transaction.account','LEFT');
		$this->db->join('purchase_invoice', 'purchase_invoice.id_purchase_invoice = transaction.id_invoice','LEFT');
		return $this->db->get('transaction')->num_rows();
	}
	
	public function dataCashTransaction($sampai,$dari,$search_term=""){
		$this->db->like('transaction.id_invoice', $search_term);
		$this->db->where('transaction.payment_method', 'cash');
		$this->db->join('master_cash_account', 'master_cash_account.id_cash_account = transaction.account','LEFT');
		$this->db->join('purchase_invoice', 'purchase_invoice.id_purchase_invoice = transaction.id_invoice','LEFT');
		return $query = $this->db->get('transaction',$sampai,$dari)->result();
		
	}
	
	
	public function countPurchaseInvoice($search_term=""){
		$this->db->or_like('invoice_number', $search_term);
		return $this->db->get('purchase_invoice')->num_rows();
	}
	
	public function dataPurchaseInvoice($sampai,$dari,$search_term=""){
		$this->db->or_like('invoice_number', $search_term);
		return $query = $this->db->get('purchase_invoice',$sampai,$dari)->result();
		
	}
	
	
	public function insertData($mytable,$data)
	{
		$res = $this->db->insert($mytable,$data);
		return $res;
		
	}
	
	public function getDriver($where="")
	{
		$data = $this->db->query("SELECT * FROM driver ".$where);
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