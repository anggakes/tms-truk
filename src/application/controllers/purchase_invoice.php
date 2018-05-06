<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_invoice extends CI_Controller {

	function __construct()  {
 		parent::__construct();
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			$this->load->model('model_account_master');
			$this->load->model('model_purchase_invoice');
			$this->load->library('tank_auth');
			
	}
	
	
	
	public function CashTransaction()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_purchase_invoice']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_purchase_invoice->countCashTransaction($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/purchase_invoice/CashTransaction/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_purchase_invoice->dataCashTransaction($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Po',
				'content' => $this->load->view('cash_transaction',array('data_cash_transaction'=>$data,'data_role'=>$data_role,'search'=>$search),true),
				'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	
	public function BankTransaction()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			
			
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_purchase_invoice']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_purchase_invoice->countBankTransaction($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/purchase_invoice/BankTransaction/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_purchase_invoice->dataBankTransaction($config['per_page'],$dari,$search);
			
		
			$comp = array(
				'title' => ' Po',
				'content' => $this->load->view('bank_transaction',array('data_bank_transaction'=>$data,'data_role'=>$data_role,'search'=>$search),true),
				'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	public function chargePayment()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_purchase_invoice']=='yes')
			{
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$invoice_number = $_POST['charge_payment_invoice_number'];
				$invoice_type = $_POST['charge_payment_invoice_type'];
				$id_invoice = $_POST['charge_payment_id_invoice'];
				$confirm_payment = $_POST['charge_payment'];
				$payment_method = $_POST['charge_payment_method'];
				$account = $_POST['charge_account'];
				
				echo $confirm_payment;
				//Total Amount
				$total_amount = 0;
				if($invoice_type == 'tms')
				{
					
					$data_purchase_tms = $this->db->query("SELECT SUM(cost) as amount FROM purchase_tms WHERE id_invoice = '".$id_invoice."' ")->result_array();
					$data_purchase_tms_cost = $this->db->query("SELECT SUM(amount) as amount FROM purchase_additional_cost_tms WHERE id_invoice = '".$id_invoice."' ")->result_array();
					$total_amount = $data_purchase_tms[0]['amount']+$data_purchase_tms_cost[0]['amount'];
					
				}
				else if ($invoice_type == 'io')
				{
					$data_product_orders_pi = $this->db->query("SELECT SUM(qty) as amount FROM product_orders_invoice WHERE id_invoice = '".$id_invoice."' ")->result_array();
					$total_amount = $data_product_orders_pi[0]['amount'];
					
				}
				
				
				
				if($invoice_type == 'tms')
				{
					
					//Check Transaction Exist or no
					$select_transaction = $this->db->query("SELECT * FROM transaction WHERE id_invoice = '".$id_invoice."' ");
					$data_transaction = $select_transaction->result_array();
					$check_transaction = $select_transaction->num_rows();
					if($check_transaction>=1)
					{
							//insert ke dalam table transaction
							$data_update = array(
								"type" => $invoice_type,
								"confirmation" => $confirm_payment,
								"payment_method" => $payment_method,
								"amount" => $total_amount,
								"account" => $account
							);
							
							$where = array(
								"id_invoice" => $id_invoice
							);
							
							//Update Data
							$res = $this->model_purchase_invoice->UpdateData("transaction",$data_update,$where);
							
							
						//check Transasksi lama
						if($data_transaction[0]['confirmation']=='confirmed')
						{
								//Kembalikan Data Lama
								if($data_transaction[0]['payment_method']=='bank')
								{
									$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance - '".$data_transaction[0]['amount']."' WHERE id_master_bank_account = '".$account."' ");
								}
								else if($data_transaction[0]['payment_method']=='cash')
								{
									$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance - '".$data_transaction[0]['amount']."' WHERE id_cash_account = '".$account."' ");
								}
						}
						
						
								if($confirm_payment=='confirmed')
								{
									
									//update dengan data baru
									if($payment_method=='bank')
									{
										$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance + '".$total_amount."' WHERE id_master_bank_account = '".$account."' ");
									}
									else if($data_transaction[0]['payment_method']=='cash')
									{
										$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance + '".$total_amount."' WHERE id_cash_account = '".$account."' ");
									}
								}
						
					}
					else
					{
						
						//insert ke dalam table transaction
						$data_insert = array(
							"type" => $invoice_type,
							"id_invoice" => $id_invoice,
							"confirmation" => $confirm_payment,
							"payment_method" => $payment_method,
							"amount" => $total_amount,
							"account" => $account
						);
						
						//Insert Data
						$res = $this->model_purchase_invoice->insertData("transaction",$data_insert);
						
						//Check apakah confirmasi atau tidak
						if($confirm_payment=='confirmed')
						{
							//Kurangin Harga
							if($payment_method=='bank')
							{
								$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = '233' WHERE id_master_bank_account = '".$account."' ");
								
							}
							else if($payment_method=='cash')
							{
								$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance + '".$total_amount."' WHERE id_cash_account = '".$account."' ");
							}
							
						}
					}
					
					$update_purchase_invoice = $this->db->query("UPDATE purchase_invoice SET confirmation = '".$confirm_payment."',payment_method='".$payment_method."',account='".$account."' WHERE id_purchase_invoice = '".$id_invoice."' ");
				}
				else if($invoice_type == 'io')
				{
					//Check Transaction Exist or no
					$select_transaction = $this->db->query("SELECT * FROM transaction WHERE id_invoice = '".$id_invoice."' ");
					$data_transaction = $select_transaction->result_array();
					$check_transaction = $select_transaction->num_rows();
					if($check_transaction>=1)
					{
						   //insert ke dalam table transaction
							$data_update = array(
								"type" => $invoice_type,
								"id_invoice" => $id_invoice,
								"confirmation" => $confirm_stock,
								"amount" => $total_amount
							);
							
							$where = array(
								"id_invoice" => $id_invoice
							);
							
							//Update Data
							$res = $this->model_purchase_invoice->UpdateData("transaction",$data_update,$where);
							
							
							//check Transasksi lama
							if($data_transaction[0]['confirmation']=='confirmed')
							{
								$data_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
								$data_io = $this->db->query("SELECT * FROM  product_orders_io WHERE id_io =  '".$data_invoice[0]['id_reference']."' AND status_approved = 'approved' ")->result();
								foreach($data_io as $data_io)
								{
									$update_stock_inventory = $this->db->query("UPDATE inventory_list SET stock = stock-'".$data_io->qty_approved."' WHERE id_location = '".$data_io->id_location."' AND id_product = '".$data_io->id_product."'  ");
								}
								
								//Kembalikan Data Lama
								if($data_transaction[0]['payment_method']=='bank')
								{
									$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance - '".$data_transaction[0]['amount']."' WHERE id_master_bank_account = '".$account."' ");
								}
								else if($data_transaction[0]['payment_method']=='cash')
								{
									$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance - '".$data_transaction[0]['amount']."' WHERE id_cash_account = '".$account."' ");
								}
								
							}
							
							if($confirm_stock=='confirmed')
							{
								$data_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
								$data_io = $this->db->query("SELECT * FROM  product_orders_io WHERE id_io =  '".$data_invoice[0]['id_reference']."' AND status_approved = 'approved' ")->result();
								
								foreach($data_io as $data_io)
								{
									$update_stock_inventory = $this->db->query("UPDATE inventory_list SET stock = stock+'".$data_io->qty_approved."' WHERE id_location = '".$data_io->id_location."' AND id_product = '".$data_io->id_product."'  ");
								}
								
								
								//update dengan data baru
									if($payment_method=='bank')
									{
										$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance + '".$total_amount."' WHERE id_master_bank_account = '".$account."' ");
									}
									else if($data_transaction[0]['payment_method']=='cash')
									{
										$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance + '".$total_amount."' WHERE id_cash_account = '".$account."' ");
									}
									
									
							}
							
						
					}
					else{
						
						//insert ke dalam table transaction
						$data_insert = array(
							"type" => $invoice_type,
							"id_invoice" => $id_invoice,
							"confirmation" => $confirm_stock,
							"amount" => $total_amount
						);
						
						//Insert Data
						$res = $this->model_purchase_invoice->insertData("transaction",$data_insert);
						if($confirm_stock=='confirmed')
						{
							$data_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
							$data_io = $this->db->query("SELECT * FROM  product_orders_io WHERE id_io =  '".$data_invoice[0]['id_reference']."' AND status_approved = 'approved' ")->result();
							
							foreach($data_io as $data_io)
							{
								echo $data_io->qty_approved;
								$update_stock_inventory = $this->db->query("UPDATE inventory_list SET stock = stock + '".$data_io->qty_approved."' WHERE id_location = '".$data_io->id_location."' AND id_product = '".$data_io->id_product."'  ");
							}
							
							
							//Kurangin Harga
							if($payment_method=='bank')
							{
								$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance + '".$total_amount."' WHERE id_master_bank_account = '".$account."' ");
							}
							else if($payment_method=='cash')
							{
								$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance + '".$total_amount."' WHERE id_cash_account = '".$account."' ");
							}
							
						}
						
					}
					
					$update_purchase_invoice = $this->db->query("UPDATE purchase_invoice SET confirmation = '".$confirm_payment."',payment_method='".$payment_method."',account='".$account."' WHERE id_purchase_invoice = '".$id_invoice."' ");
				}
				
					
				
				
				
			$this->session->set_flashdata('message_success',"Purchase Invoice has been successfully saved!");
			redirect('purchase_invoice');	
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	public function confirmedPayment()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['edit_purchase_invoice']=='yes')
			{
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$invoice_number = $_POST['confirmed_payment_invoice_number'];
				$invoice_type = $_POST['confirmed_payment_invoice_type'];
				$id_invoice = $_POST['confirmed_payment_id_invoice'];
				$confirm_payment = $_POST['confirm_payment'];
				$payment_method = $_POST['payment_method'];
				$account = $_POST['account'];
				$confirm_stock = $_POST['confirm_stock'];
				
				echo $confirm_payment;
				//Total Amount
				$total_amount = 0;
				if($invoice_type == 'tms')
				{
					$data_purchase_tms = $this->db->query("SELECT SUM(cost) as amount FROM purchase_tms WHERE id_invoice = '".$id_invoice."' ")->result_array();
					$data_purchase_tms_cost = $this->db->query("SELECT SUM(amount) as amount FROM purchase_additional_cost_tms WHERE id_invoice = '".$id_invoice."' ")->result_array();
					$total_amount = $data_purchase_tms[0]['amount']+$data_purchase_tms_cost[0]['amount'];
					
				}
				else if ($invoice_type == 'po')
				{
					$data_product_orders_pi = $this->db->query("SELECT SUM(price_total) as amount FROM product_orders_invoice WHERE id_invoice = '".$id_invoice."' ")->result_array();
					$total_amount = $data_product_orders_pi[0]['amount'];
					
				}
				else if ($invoice_type == 'io')
				{
					$data_product_orders_pi = $this->db->query("SELECT SUM(qty) as amount FROM product_orders_invoice WHERE id_invoice = '".$id_invoice."' ")->result_array();
					$total_amount = $data_product_orders_pi[0]['amount'];
					
				}
				
				
				
				if($invoice_type == 'tms' || $invoice_type == 'po')
				{
					//Check Transaction Exist or no
					$select_transaction = $this->db->query("SELECT * FROM transaction WHERE id_invoice = '".$id_invoice."' ");
					$data_transaction = $select_transaction->result_array();
					$check_transaction = $select_transaction->num_rows();
					if($check_transaction>=1)
					{
							//insert ke dalam table transaction
							$data_update = array(
								"type" => $invoice_type,
								"confirmation" => $confirm_payment,
								"payment_method" => $payment_method,
								"amount" => $total_amount,
								"account" => $account
							);
							
							$where = array(
								"id_invoice" => $id_invoice
							);
							
							//Update Data
							$res = $this->model_purchase_invoice->UpdateData("transaction",$data_update,$where);
							
							
						//check Transasksi lama
						if($data_transaction[0]['confirmation']=='confirmed')
						{
								//Kembalikan Data Lama
								if($data_transaction[0]['payment_method']=='bank')
								{
									$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance + '".$data_transaction[0]['amount']."' WHERE id_master_bank_account = '".$account."' ");
								}
								else if($data_transaction[0]['payment_method']=='cash')
								{
									$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance + '".$data_transaction[0]['amount']."' WHERE id_cash_account = '".$account."' ");
								}
						}
						
						
								if($confirm_payment=='confirmed')
								{
									//update dengan data baru
									if($payment_method=='bank')
									{
										$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance - '".$total_amount."' WHERE id_master_bank_account = '".$account."' ");
									}
									else if($data_transaction[0]['payment_method']=='cash')
									{
										$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance - '".$total_amount."' WHERE id_cash_account = '".$account."' ");
									}
								}
						
					}
					else
					{
						//insert ke dalam table transaction
						$data_insert = array(
							"type" => $invoice_type,
							"id_invoice" => $id_invoice,
							"confirmation" => $confirm_payment,
							"payment_method" => $payment_method,
							"amount" => $total_amount,
							"account" => $account
						);
						
						//Insert Data
						$res = $this->model_purchase_invoice->insertData("transaction",$data_insert);
						
						//Check apakah confirmasi atau tidak
						if($confirm_payment=='confirmed')
						{
							//Kurangin Harga
							if($payment_method=='bank')
							{
								$update_payment = $this->db->query("UPDATE master_bank_account SET statement_balance = statement_balance - '".$total_amount."' WHERE id_master_bank_account = '".$account."' ");
							}
							else if($payment_method=='cash')
							{
								$update_payment = $this->db->query("UPDATE master_cash_account SET balance = balance - '".$total_amount."' WHERE id_cash_account = '".$account."' ");
							}
							
						}
					}
					
					$update_purchase_invoice = $this->db->query("UPDATE purchase_invoice SET confirmation = '".$confirm_payment."',payment_method='".$payment_method."',account='".$account."' WHERE id_purchase_invoice = '".$id_invoice."' ");
				}
				else if($invoice_type == 'io')
				{
					//Check Transaction Exist or no
					$select_transaction = $this->db->query("SELECT * FROM transaction WHERE id_invoice = '".$id_invoice."' ");
					$data_transaction = $select_transaction->result_array();
					$check_transaction = $select_transaction->num_rows();
					if($check_transaction>=1)
					{
						   //insert ke dalam table transaction
							$data_update = array(
								"type" => $invoice_type,
								"id_invoice" => $id_invoice,
								"confirmation" => $confirm_stock,
								"amount" => $total_amount
							);
							
							$where = array(
								"id_invoice" => $id_invoice
							);
							
							//Update Data
							$res = $this->model_purchase_invoice->UpdateData("transaction",$data_update,$where);
							
							
							//check Transasksi lama
							if($data_transaction[0]['confirmation']=='confirmed')
							{
								$data_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
								$data_io = $this->db->query("SELECT * FROM  product_orders_io WHERE id_io =  '".$data_invoice[0]['id_reference']."' AND status_approved = 'approved' ")->result();
								foreach($data_io as $data_io)
								{
									$update_stock_inventory = $this->db->query("UPDATE inventory_list SET stock = stock+'".$data_io->qty_approved."' WHERE id_location = '".$data_io->id_location."' AND id_product = '".$data_io->id_product."'  ");
								}
							}
							
							if($confirm_stock=='confirmed')
							{
								$data_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
								$data_io = $this->db->query("SELECT * FROM  product_orders_io WHERE id_io =  '".$data_invoice[0]['id_reference']."' AND status_approved = 'approved' ")->result();
								
								foreach($data_io as $data_io)
								{
									$update_stock_inventory = $this->db->query("UPDATE inventory_list SET stock = stock-'".$data_io->qty_approved."' WHERE id_location = '".$data_io->id_location."' AND id_product = '".$data_io->id_product."'  ");
								}
								
							}
							
						
					}
					else{
						
						//insert ke dalam table transaction
						$data_insert = array(
							"type" => $invoice_type,
							"id_invoice" => $id_invoice,
							"confirmation" => $confirm_stock,
							"amount" => $total_amount
						);
						
						//Insert Data
						$res = $this->model_purchase_invoice->insertData("transaction",$data_insert);
						if($confirm_stock=='confirmed')
						{
							$data_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
							$data_io = $this->db->query("SELECT * FROM  product_orders_io WHERE id_io =  '".$data_invoice[0]['id_reference']."' AND status_approved = 'approved' ")->result();
							
							foreach($data_io as $data_io)
							{
								echo $data_io->qty_approved;
								$update_stock_inventory = $this->db->query("UPDATE inventory_list SET stock = stock - '".$data_io->qty_approved."' WHERE id_location = '".$data_io->id_location."' AND id_product = '".$data_io->id_product."'  ");
							}
							
						}
						
					}
					
					$update_purchase_invoice = $this->db->query("UPDATE purchase_invoice SET confirmation = '".$confirm_stock."',payment_method='-' WHERE id_purchase_invoice = '".$id_invoice."' ");
					
				}
				
				
			$this->session->set_flashdata('message_success',"Purchase Invoice has been successfully saved!");
			redirect('purchase_invoice');	
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	public function deletePurchaseInvoiceAll()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_purchase_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$id_purchase_invoice_delete = $_POST['id_purchase_invoice_delete_all'];
				
		
					//Update Product
					$res = $this->db->query("DELETE FROM purchase_invoice WHERE id_purchase_invoice in (".$id_purchase_invoice_delete.") ");
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data purchase_invoice has been successfully deleted!");
						redirect('purchase_invoice');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data PurchaseInvoice failed to delete!");
						redirect('purchase_invoice');
					}
				
				
				
				
				
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	

	
	
	public function deletePurchaseInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			if($data_role[0]['delete_purchase_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$id_purchase_invoice_delete = $_POST['id_purchase_invoice_delete'];
				$where = array("id_purchase_invoice" => $id_purchase_invoice_delete);
				
		
					//Update Product
					$res = $this->model_purchase_invoice->DeleteData("purchase_invoice",$where);
					if($res>=1)
					{
						$this->session->set_flashdata('message_success',"Data purchase_invoice has been successfully deleted!");
						redirect('purchase_invoice');
						
						}
					else
					{
						$this->session->set_flashdata('message_failed',"Data PurchaseInvoice failed to delete!");
						redirect('purchase_invoice');
					}
				
				
				
				
				
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function exportPurchaseInvoice()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		if ($this->tank_auth->is_logged_in()) {
		$user	= $this->tank_auth->get_username();
		$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
		$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		$user_role = $data_account[0]['user_type'];
		$code_role = $data_account[0]['code'];
		
		if($data_role[0]['export_purchase_invoice']=='yes')
		{
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		
		$date = date("m-d-Y");
		$this->db->or_like('purchase_invoice_code', $search);
		$query = $this->db->get('purchase_invoice');
        if(!$query)
        return false;
 
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		
 
        $objPHPExcel->setActiveSheetIndex(0);
 		$objPHPExcel->getActiveSheet()->setShowGridlines(false);
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		
		$Fontstyle = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'ffffff')
		));
		
		$FontstyleTitle = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size' => 15
		));
		
		$styleAlign = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    	);
		
		//Set Width Column
		foreach(range('B','Z') as $columnID)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Master PurchaseInvoice");
		//Merge And Center Title
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Date : ".$date);
		
		//Merge And Center Date
		$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		
		//Set Font Color Title
		$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($FontstyleTitle);
		
		//Set Font Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray($Fontstyle);
		
		//Set Backgroung Color Header
		$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '62a8ea')
				)
			)
		);


		
        // Field names in the first row
         // Field names in the first row
        $fields = array(
		
		"No" => "No",
		"PurchaseInvoice Code" => "PurchaseInvoice Code",
		"PurchaseInvoice Name" => "PurchaseInvoice Name"
		
		);
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
            $col++;
        }
		
		
		

 
        // Fetching the table data
        $row = 5;
		$no = 1;
        foreach($query->result_array() as $data)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data['purchase_invoice_code']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data['purchase_invoice_name']);
 
            $row++;
			$no++;
        }
		
	   $last_row = $row-1;
	   //Set Border
       $objPHPExcel->getActiveSheet()->getStyle("A4".":"."C".$last_row)->applyFromArray($BStyle);
	   $objPHPExcel->getActiveSheet()->getStyle("A4".":"."C".$last_row)->applyFromArray($styleAlign);
       $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 		
		
	   // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Master-purchase_invoice-'.$date.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
		
			}
			else
			{
				$data = "You dont have permission to access this page";
				$comp = array(
			
				'title' => ' Permission Denied',
				'content' => $this->load->view('accessdenied',array('data'=>$data),true),
				'sidebar' => $this->html_sidebar()
				);
				$this->load->view("common/common",$comp);
			
				}
			
			}
		else
		{
			redirect('/auth/login/');
			}
			
		}
	
	public function importPurchaseInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['import_purchase_invoice']=='yes')
			{
				
				
			if ($_POST) {
			ini_set('memory_limit', '-1');
		    $fileName = $_FILES['import_file']['name'];
			$config['upload_path'] = './files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 100000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import_file') )
			{
				$this->session->set_flashdata('message_failed','Import Failed, Please upload file excel extension!');
				redirect('purchase_invoice');
				
				
			}
			else
			{

			$media = $this->upload->data('import');
			
			$inputFileName = './files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
												
												
				
				
			
					//jika master data tidak kosong maka akan diisi		
					$check = $this->model_purchase_invoice->getPurchaseInvoice("WHERE purchase_invoice_code  = '".$rowData[0][0]."' ");
					if($check->num_rows() >=1 )
					{
						
						$data_update = array(
							"purchase_invoice_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
							
						);
						$where = array(
							"purchase_invoice_code" => $rowData[0][0]
						);
						
						$res = $this->model_purchase_invoice->UpdateData("purchase_invoice",$data_update,$where);
					
						}
					else
					{
						$data_insert = array(
							"purchase_invoice_code" => $rowData[0][0],
							"purchase_invoice_name" => $rowData[0][1],
							"password" => md5($rowData[0][2])
						);
						
						//Insert Data
						$res = $this->model_purchase_invoice->insertData("purchase_invoice",$data_insert);
					
					}
					
				
				
			}
				@unlink($inputFileName);
				$this->session->set_flashdata('message_success','Data imported successfully');
				redirect('purchase_invoice');
			
               
			}
			
			 	
            }
		
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function addPurchaseInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_purchase_invoice']=='yes')
			{
				
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$invoice_date = explode('-',$_POST['invoice_date']);
				$invoice_date = $invoice_date[2].'-'.$invoice_date[1].'-'.$invoice_date[0];
				$invoice_number = $_POST['invoice_number'];
				$invoice_method = $_POST['invoice_method'];
				$purchase_invoice = $_POST['purchase_invoice'];
				
				
				$check_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE invoice_number = '".$invoice_number."' ")->num_rows();
				echo $check_invoice;
				if($check_invoice>=1)
				{
					
					$this->session->set_flashdata('message_failed',"Data invoice Already Exist!");
					redirect('purchase_invoice');
				}
				else
				{
					
					
					
					if($purchase_invoice=='po')
					{
						//PO
						$id_po = $_POST['po_id'];
						
						$data_insert = array(
						"id_reference" => $id_po,
						"invoice_method" => $invoice_method,
						"invoice_date" => $invoice_date,
						"invoice_number" => $invoice_number,
						"invoice_type" => $purchase_invoice,
						"created_date" => $timestamp,
						"created_by" => $username
						);
						$res = $this->model_purchase_invoice->insertData("purchase_invoice",$data_insert);
						
						$data_invoice = $this->db->query("SELECt * FROM purchase_invoice WHERE invoice_number = '".$invoice_number."' ")->result_array();
						$data_last_invoice = $data_invoice[0]['id_purchase_invoice'];
						
						
						$data_po = $this->db->query("SELECT * FROM product_orders_po WHERE id_po = '".$id_po."' AND status_approved = 'approved' ")->result();
						foreach($data_po as $data_po)
						{
							$data_insert = array(
								"id_product" => $data_po->id_product,
								"product_code" => $data_po->id_product,
								"price" => $data_po->price,
								"price_total" => $data_po->price*$data_po->qty_approve,
								"id_invoice" => $data_last_invoice,
								"product_name" => $data_po->product_name,
								"qty" => $data_po->qty_approve
							);
							$res = $this->model_purchase_invoice->insertData("product_orders_invoice",$data_insert);
							
						}
					}
					else if($purchase_invoice=='io')
					{
						$id_io = $_POST['io_id'];
						
						$data_insert = array(
						"id_reference" => $id_io,
						"invoice_method" => $invoice_method,
						"invoice_date" => $invoice_date,
						"invoice_number" => $invoice_number,
						"invoice_type" => $purchase_invoice,
						"created_date" => $timestamp,
						"created_by" => $username
						);
						$res = $this->model_purchase_invoice->insertData("purchase_invoice",$data_insert);
						
						$data_invoice = $this->db->query("SELECt * FROM purchase_invoice WHERE invoice_number = '".$invoice_number."' ")->result_array();
						$data_last_invoice = $data_invoice[0]['id_purchase_invoice'];
						
						
						//IO
						
						$data_io = $this->db->query("SELECT * FROM product_orders_io WHERE id_io = '".$id_io."' AND status_approved = 'approved' ")->result();
						foreach($data_io as $data_io)
						{
							$data_insert = array(
								"id_product" => $data_io->id_product,
								"product_code" => $data_io->id_product,
								"price" => $data_io->price,
								"price_total" => $data_io->price*$data_io->qty_approved,
								"id_invoice" => $data_last_invoice,
								"product_name" => $data_io->product_name,
								"qty" => $data_io->qty_approved
							);
							$res = $this->model_purchase_invoice->insertData("product_orders_invoice",$data_insert);
							
							
						}
					}
					else if($purchase_invoice=='tms')
					{
						//TMS
						$id_manifest = $_POST['manifest_id'];
						
						
						$data_insert = array(
						"id_reference" => $id_manifest,
						"invoice_method" => $invoice_method,
						"invoice_date" => $invoice_date,
						"invoice_number" => $invoice_number,
						"invoice_type" => $purchase_invoice,
						"created_date" => $timestamp,
						"created_by" => $username
						);
						$res = $this->model_purchase_invoice->insertData("purchase_invoice",$data_insert);
						
						$data_invoice = $this->db->query("SELECt * FROM purchase_invoice WHERE invoice_number = '".$invoice_number."' ")->result_array();
						$data_last_invoice = $data_invoice[0]['id_purchase_invoice'];
						
						
						//TMS 
						$data_tms = $this->db->query("SELECT * FROM master_manifest WHERE id_manifest = '".$id_manifest."' ")->result();
						foreach($data_tms as $data_tms)
						{
							$rate = 0;
							
							if($invoice_method=='sales')
							{$rate = $data_tms->client_rate; }
							else if($invoice_method=='purchase')
							{$rate = $data_tms->rate;}
							
							$data_insert = array(
								"id_invoice" => $data_last_invoice,
								"manifest" => $data_tms->id_manifest,
								"delivery_date" => $data_tms->delivery_date,
								"client_id" => $data_tms->client_id,
								"client_name" => $data_tms->client_name,
								"origin" => $data_tms->origin_id.'-'.$data_tms->origin_address.'-'.$data_tms->origin_area,
								"destination" => $data_tms->destination_id.'-'.$data_tms->destination_address.'-'.$data_tms->destination_area,
								"origin_id" => $data_tms->origin_id,
								"destination_id" => $data_tms->destination_id,
								"cost" => $rate,
							);
							$res = $this->model_purchase_invoice->insertData("purchase_tms",$data_insert);
							
						}
						
						
						//TMS Additional Cost
						$data_additional_cost = $this->db->query("SELECT * FROM manifest_additional_cost WHERE manifest = '".$id_manifest."' ")->result();
						foreach($data_additional_cost as $data_additional_cost)
						{
							$data_insert = array(
								"additional_type" => $data_additional_cost->additional_type,
								"manifest" => $data_additional_cost->manifest,
								"delivery_date" => $data_additional_cost->delivery_date,
								"trip" => $data_additional_cost->trip,
								"id_invoice" => $data_last_invoice,
								"amount" => $data_additional_cost->amount,
								"description" => $data_additional_cost->description
							);
							$res = $this->model_purchase_invoice->insertData("purchase_additional_cost_tms",$data_insert);
							
						}
						
					}
					
					$this->session->set_flashdata('message_success',"Data Invoice has been successfully saved!");
					redirect('purchase_invoice');
				}
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	
	
	
	
	public function editPurchaseInvoice()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			ini_set('memory_limit', '-1');
			
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['add_purchase_invoice']=='yes')
			{
				
			
				// Get Variable Post
				$timestamp = date('Y:m:d H:i:s');
				$username = $user;
				$invoice_date = explode('-',$_POST['edit_invoice_date']);
				$invoice_date = $invoice_date[2].'-'.$invoice_date[1].'-'.$invoice_date[0];
				$invoice_number = $_POST['edit_invoice_number'];
				$purchase_invoice = $_POST['edit_purchase_invoice'];
				$id_invoice = $_POST['id_update_purchase_invoice'];
				
				
				$check_invoice = $this->db->query("SELECT * FROM purchase_invoice WHERE invoice_number = '".$invoice_number."' AND 	id_purchase_invoice !='".$id_invoice."' ")->num_rows();
				echo $check_invoice;
				if($check_invoice>=1)
				{
					
					$this->session->set_flashdata('message_failed',"Data invoice Already Exist!");
					redirect('purchase_invoice');
				}
				else
				{
					
					
					
					if($purchase_invoice=='po')
					{
						//PO
						$id_po = $_POST['edit_po_id'];
						
						$data_update = array(
						"id_reference" => $id_po,
						"invoice_date" => $invoice_date,
						"invoice_number" => $invoice_number,
						"invoice_type" => $purchase_invoice,
						"updated_date" => $timestamp,
						"updated_by" => $username
						);
						$where = array(
						"id_purchase_invoice" => $id_invoice
						);
						$res = $this->model_purchase_invoice->UpdateData("purchase_invoice",$data_update,$where);
						
						$data_invoice = $this->db->query("SELECt * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
						$id_po_lama = $data_invoice[0]['id_reference'];
						
						
						if($id_po_lama!=$id_po)
						{
							$delete_data = $this->db->query("DELETE FROM product_orders_invoice WHERE id_invoice = '".$id_invoice."' ");
							$data_po = $this->db->query("SELECT * FROM product_orders_po WHERE id_po = '".$id_po."' AND status_approved = 'approved' ")->result();
							foreach($data_po as $data_po)
							{
								$data_insert = array(
									"id_product" => $data_po->id_product,
									"product_code" => $data_po->id_product,
									"price" => $data_po->price,
									"price_total" => $data_po->price*$data_po->qty_approve,
									"id_invoice" => $data_last_invoice,
									"product_name" => $data_po->product_name,
									"qty" => $data_po->qty_approve
								);
								$res = $this->model_purchase_invoice->insertData("product_orders_invoice",$data_insert);
							}
						}
						
						
						
						
					}
					else if($purchase_invoice=='io')
					{
						$id_io = $_POST['edit_io_id'];
						
						$data_update = array(
						"id_reference" => $id_io,
						"invoice_date" => $invoice_date,
						"invoice_number" => $invoice_number,
						"invoice_type" => $purchase_invoice,
						"updated_date" => $timestamp,
						"updated_by" => $username
						);
						$where = array(
						"id_purchase_invoice" => $id_invoice
						);
						$res = $this->model_purchase_invoice->UpdateData("purchase_invoice",$data_update,$where);
						$data_invoice = $this->db->query("SELECt * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
						$id_io_lama = $data_invoice[0]['id_reference'];
						
						
						
						//IO
						if($id_io_lama!=$id_io)
						{
							$delete_data = $this->db->query("DELETE FROM product_orders_invoice WHERE id_invoice = '".$id_invoice."' ");
								
							$data_io = $this->db->query("SELECT * FROM product_orders_io WHERE id_io = '".$id_io."' AND status_approved = 'approved' ")->result();
							foreach($data_io as $data_io)
							{
								$data_insert = array(
									"id_product" => $data_io->id_product,
									"product_code" => $data_io->id_product,
									"price" => $data_io->price,
									"price_total" => $data_io->price*$data_io->qty_approved,
									"id_invoice" => $data_last_invoice,
									"product_name" => $data_io->product_name,
									"qty" => $data_io->qty_approved
								);
								$res = $this->model_purchase_invoice->insertData("product_orders_invoice",$data_insert);
								
								
							}
						}
					}
					else if($purchase_invoice=='tms')
					{
						//TMS
						$id_manifest = $_POST['edit_manifest_id'];
						
						
						$data_update = array(
						"id_reference" => $id_manifest,
						"invoice_date" => $invoice_date,
						"invoice_number" => $invoice_number,
						"invoice_type" => $purchase_invoice,
						"updated_date" => $timestamp,
						"updated_by" => $username
						);
						$where = array(
						"id_purchase_invoice" => $id_invoice
						);
						$res = $this->model_purchase_invoice->UpdateData("purchase_invoice",$data_update,$where);
						
						$data_invoice = $this->db->query("SELECt * FROM purchase_invoice WHERE id_purchase_invoice = '".$id_invoice."' ")->result_array();
						$id_manifest_lama = $data_invoice[0]['id_reference'];
						
						if($id_manifest_lama!=$id_manifest)
						{
							$delete_data = $this->db->query("DELETE FROM purchase_tms WHERE id_invoice = '".$id_invoice."' ");
							
						
						//TMS 
						$data_tms = $this->db->query("SELECT * FROM master_manifest WHERE id_manifest = '".$id_manifest."' ")->result();
						foreach($data_tms as $data_tms)
						{
							$data_insert = array(
								"id_invoice" => $data_last_invoice,
								"manifest" => $data_tms->id_manifest,
								"delivery_date" => $data_tms->delivery_date,
								"client_id" => $data_tms->client_id,
								"client_name" => $data_tms->client_name,
								"origin" => $data_tms->origin_id.'-'.$data_tms->origin_address.'-'.$data_tms->origin_area,
								"destination" => $data_tms->destination_id.'-'.$data_tms->destination_address.'-'.$data_tms->destination_area,
								"origin_id" => $data_tms->origin_id,
								"destination_id" => $data_tms->destination_id,
								"cost" => $data_tms->rate,
							);
							$res = $this->model_purchase_invoice->insertData("purchase_tms",$data_insert);
							
						}
						
						$delete_data = $this->db->query("DELETE FROM purchase_additional_cost_tms WHERE id_invoice = '".$id_invoice."' ");
						//TMS Additional Cost
						$data_additional_cost = $this->db->query("SELECT * FROM manifest_additional_cost WHERE manifest = '".$id_manifest."' ")->result();
						foreach($data_additional_cost as $data_additional_cost)
						{
							$data_insert = array(
								"additional_type" => $data_additional_cost->additional_type,
								"manifest" => $data_additional_cost->manifest,
								"delivery_date" => $data_additional_cost->delivery_date,
								"trip" => $data_additional_cost->trip,
								"id_invoice" => $data_last_invoice,
								"amount" => $data_additional_cost->amount,
								"description" => $data_additional_cost->description
							);
							$res = $this->model_purchase_invoice->insertData("purchase_additional_cost_tms",$data_insert);
							
						}
						}
						
					}
					
					$this->session->set_flashdata('message_success',"Data Invoice has been successfully saved!");
					redirect('purchase_invoice');
				}
				
			
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	
	
	
	public function index()
	{
		
			date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			$user_role = $data_account[0]['user_type'];
			$code_role = $data_account[0]['code'];
			
			if($data_role[0]['see_purchase_invoice']=='yes')
			{	
			$this->load->library('table');
			$this->load->library('pagination');
			$search = isset($_GET['search']) ? $_GET['search'] : '';
			
			
			$jumlah= $this->model_purchase_invoice->countPurchaseInvoice($search);
			
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['base_url'] = base_url().'index.php/purchase_invoice/purchase_invoice/';
			$config['total_rows'] = $jumlah;
			$config['first_link'] = 'First';
			$config['last_link'] = 'End';
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['per_page'] = 5; 	
			if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			
			$dari = $this->uri->segment('3');
			$data = $this->model_purchase_invoice->dataPurchaseInvoice($config['per_page'],$dari,$search);
			
			$data_bank_account_receive = $this->db->query("SELECt * FROM master_bank_account ")->result();
			$data_cash_account_receive = $this->db->query("SELECt * FROM master_cash_account ")->result();
			
			$data_bank_account_spend = $this->db->query("SELECt * FROM master_bank_account ")->result();
			$data_cash_account_spend = $this->db->query("SELECt * FROM master_cash_account ")->result();
			
			$comp = array(
				'title' => ' PurchaseInvoice',
				'content' => $this->load->view('purchase_invoice',array('data_bank_account_receive'=>$data_bank_account_receive,'data_cash_account_receive'=>$data_cash_account_receive,'data_bank_account_spend'=>$data_bank_account_spend,'data_cash_account_spend'=>$data_cash_account_spend,'data_purchase_invoice'=>$data,'data_role'=>$data_role,'search'=>$search),true),
				'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			}
		else
		{
			$data = "You dont have permission to access this page";
			$comp = array(
			
			'title' => ' Permission Denied',
			'content' => $this->load->view('accessdenied',array('data'=>$data),true),
			'sidebar' => $this->html_sidebar()
			);
			$this->load->view("common/common",$comp);
			
			}
			
		}
		else
		{
			redirect('/auth/login/');
			}
		
	}
	
	public function html_sidebar()
	{
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$user	= $this->tank_auth->get_username();
			
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
			return $this->load->view("common/sidebar_admin",array('data_account'=>$data_account,'data_role'=>$data_role),true);
		}
	}
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */