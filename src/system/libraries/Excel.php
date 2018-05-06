date_default_timezone_set('Asia/Jakarta');
			if ($this->tank_auth->is_logged_in()) {
			$user	= $this->tank_auth->get_username();
			
			$data_account = $this->model_account_master->getAccount("WHERE username = '".$user."' ")->result_array();
			$data_role = $this->model_account_master->getRole("WHERE id_role = '".$data_account[0]['user_access']."' ")->result_array();
		
			if($data_role[0]['upload_file_new']=='yes')
			{
			ini_set('memory_limit', '-1');
		    $fileName = $_FILES['file_import']['name'];
			$config['upload_path'] = './assets/tmp/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx|csv|XLS';
			$config['max_size']		= 10000000;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('file_import') )
			{
				echo"<div class='alert alert-danger'>Failed to import data, please try again!</div>";
			}
			else
			{
				$media = $this->upload->data('file_import');
				$inputFileName = './assets/tmp/'.$media['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
 
				//get only the Cell Collection
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
				 
				//extract to a PHP readable array format
				foreach ($cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
					$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				 
					//header will/should be in row 1 only. of course this can be modified to suit your need.
					if ($row == 1) {
						$header[$row][$column] = $data_value;
						echo $header[$row][$column];
					} else {
						$arr_data[$row][$column] = $data_value;
						
						echo $arr_data[$row][$column];
					}
				}
				 
				//send the data in an array format
				$data['header'] = $header;
				$data['values'] = $arr_data;
							
			}
			
			}else
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