<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_json extends CI_Model{
	
	
	public function dataJobNumber($job_number){
		$this->db->like('id_trucking_order', $job_number);
		$this->db->where('status_transport_order','no');
		return $query = $this->db->get('detail_trucking_order')->result();
	}
	
	public function dataJsonPOD($spk_number){
		$this->db->where('spk_number', $spk_number);
		return $query = $this->db->get('pod')->result();
	}
	
	public function dataSM($id_room_service_management){
		$this->db->where('id_room_service_management', $id_room_service_management);
		return $query = $this->db->get('detail_service')->result();
	}
	
	public function dataTMLangsir($spk_number,$state,$point_id){
		$this->db->where('spk_number', $spk_number);
		$this->db->where('state', $state);
		$this->db->where('point_id', $point_id);
		return $query = $this->db->get('traffic_monitoring_langsir')->result();
	}
	
	public function dataTMImport($spk_number,$state,$point_id){
		$this->db->where('spk_number', $spk_number);
		$this->db->where('state', $state);
		$this->db->where('point_id', $point_id);
		return $query = $this->db->get('traffic_monitoring_import')->result();
	}
	
	public function dataTMExport($spk_number,$state,$point_id){
		$this->db->where('spk_number', $spk_number);
		$this->db->where('state', $state);
		$this->db->where('point_id', $point_id);
		return $query = $this->db->get('traffic_monitoring_export')->result();
	}
	
	public function dataTMRegular($spk_number,$state,$point_id){
		$this->db->where('spk_number', $spk_number);
		$this->db->where('state', $state);
		$this->db->where('point_id', $point_id);
		return $query = $this->db->get('traffic_monitoring_regular')->result();
	}
	
	public function dataTMLangsirEmpty($spk_number,$state,$point_id){
		$this->db->where('spk_number', $spk_number);
		$this->db->where('state', $state);
		$this->db->where('point_id', $point_id);
		return $query = $this->db->get('traffic_monitoring_langsir_empty')->result();
	}
	
	public function dataTruckingOrder($id_trucking_order){
		$this->db->like('id_trucking_order', $id_trucking_order);
		return $query = $this->db->get('master_trucking_order')->result();
	}
	
	public function dataTmsCostInvoice($id_pi){
		$this->db->where('id_invoice', $id_pi);
		return $query = $this->db->get('purchase_additional_cost_tms')->result();
	}
	
	
	public function dataTmsInvoice($id_pi){
		$this->db->where('id_invoice', $id_pi);
		return $query = $this->db->get('purchase_tms')->result();
	}
	
	
	public function dataProductPi($id_pi){
		$this->db->where('id_invoice', $id_pi);
		$this->db->join('product', 'product_orders_invoice.id_product = product.id_product','LEFT');
		return $query = $this->db->get('product_orders_invoice')->result();
	}
	
	
	
	public function dataIo($id_io){
		$this->db->where('io_type', 'assets');
		$this->db->where('status_io', 'approved');
		$this->db->like('id_io', $id_io);
		return $query = $this->db->get('master_io')->result();
	}
	
	
	public function dataAdditionalCostManifestPi($id_manifest){
		$this->db->where('manifest', $id_manifest);
		return $query = $this->db->get('manifest_additional_cost')->result();
	}
	
	
	
	public function dataDetailManifest($id_manifest){
		$this->db->like('id_manifest', $id_manifest);
		return $query = $this->db->get('master_manifest')->result();
	}
	
	public function dataDetailManifestPi($id_manifest){
		$this->db->where('confirmed_manifest', 'yes');
		$this->db->like('id_manifest', $id_manifest);
		return $query = $this->db->get('master_manifest')->result();
	}
	
	public function dataManifestPi($id_manifest){
		$this->db->where('confirmed_manifest', 'yes');
		$this->db->like('id_manifest', $id_manifest);
		return $query = $this->db->get('master_manifest')->result();
	}
	
	
	public function dataProductInvoice($id_io){
		$this->db->where('id_io', $id_io);
		$this->db->where('status_approved','approved');
		$this->db->join('location', 'product_orders_io.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product_orders_io.id_product = product.id_product','LEFT');
		return $query = $this->db->get('product_orders_io')->result();
	}
	
	
	public function dataProductIo($id_io){
		$this->db->where('id_io', $id_io);
		$this->db->join('location', 'product_orders_io.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product_orders_io.id_product = product.id_product','LEFT');
		return $query = $this->db->get('product_orders_io')->result();
	}
	
	
	public function dataInventoryList($search){
		
		$this->db->like('inventory_list.id_product', $search);
		$this->db->or_like('product.product_code', $search);
		$this->db->or_like('product.product_description', $search);
		$this->db->or_like('location.warehouse_code', $search);
		$this->db->or_like('location_type.location_type', $search);
		$this->db->join('location', 'inventory_list.id_location = location.id_location','LEFT');
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		$this->db->join('product', 'product.id_product = inventory_list.id_product','LEFT');
		return $query = $this->db->get('inventory_list')->result();
	}
	
	public function dataLocationGr($warehouse_code){
		
		$this->db->where("warehouse_code = '".$warehouse_code."' ");
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		return $query = $this->db->get('location')->result();
	}
	
	
	public function dataPoGr($id_po){
		$this->db->like('id_po', $id_po);
		$this->db->where("status_gr = 'new'  ");
		$this->db->where("status = 'approved'  ");
		return $query = $this->db->get('master_po')->result();
	}
	
	public function dataPoPi($id_po){
		$this->db->like('id_po', $id_po);
		$this->db->where("status_gr = 'gr_created'  ");
		$this->db->where("status = 'approved'  ");
		return $query = $this->db->get('master_po')->result();
	}
	
	public function dataAdditionalCost($id_manifest){
		$this->db->where('manifest', $id_manifest);
		return $query = $this->db->get('manifest_additional_cost')->result();
	}
	
	public function dataManifest($manifest){
		$this->db->where('id_manifest', $manifest);
		return $query = $this->db->get('master_manifest')->result();
	}
	
	public function dataManifestRoutePlanning($trip,$delivery_date,$client_id){
		$this->db->like('client_id', $client_id);
		$this->db->where('trip', $trip);
		$this->db->where('delivery_date', $delivery_date);
		return $query = $this->db->get('master_manifest')->result();
	}
	
	public function dataMasterUnitRoutePlanning($search){
		$this->db->like('vehicle_id', $search);
		$this->db->join('vehicle_type', 'master_unit.vehicle_type = vehicle_type.id_vehicle_type','LEFT');
		return $query = $this->db->get('master_unit')->result();
	}
	
	
	public function dataTransportOrderManifestRoutePlanning($trip,$delivery_date,$manifest){
		$this->db->where('trip', $trip);
		$this->db->where('manifest', $manifest);
		$this->db->where('delivery_date', $delivery_date);
		return $query = $this->db->get('transport_order')->result();
		
	}
	
	public function dataTransportOrderRoutePlanning($trip,$delivery_date,$client_id){
		$this->db->like('client_id', $client_id);
		//$this->db->where('delivery_date', $delivery_date);
		$this->db->where("manifest = '0' ");
		return $query = $this->db->get('transport_order')->result();
		
	}
	
	public function dataTransportOrder($search){
		$this->db->like('spk_number', $search);
		$this->db->where("manifest  != '0' ");
		$this->db->or_like('do_number', $search);
		return $query = $this->db->get('transport_order')->result();
		
	}
	
	public function dataPr($id_pr){
		$this->db->like('id_pr', $id_pr);
		return $query = $this->db->get('master_pr')->result();
		
	}
	
	
	public function dataProductPr($id_pr){
		$this->db->where('id_pr', $id_pr);
		$this->db->join('product', 'product_orders_pr.id_product = product.id_product','LEFT');
		return $query = $this->db->get('product_orders_pr')->result();
	}
	
	public function dataProductPo($id_po){
		$this->db->where('id_po', $id_po);
		$this->db->join('product', 'product_orders_po.id_product = product.id_product','LEFT');
		return $query = $this->db->get('product_orders_po')->result();
		
	}
	
	public function dataProductGr($id_gr){
		$this->db->where('id_gr', $id_gr);
		$this->db->join('product', 'product_orders_gr.id_product = product.id_product','LEFT');
		return $query = $this->db->get('product_orders_gr')->result();
		
	}
	
	
	public function dataProductPoGr($id_po){
		$this->db->where('status_approved', 'approved');
		$this->db->where('id_po', $id_po);
		$this->db->join('product', 'product_orders_po.id_product = product.id_product','LEFT');
		return $query = $this->db->get('product_orders_po')->result();
		
	}
	
	
	public function datatruckAbsent($search){
		$this->db->or_like('vehicle_type', $search);
		$this->db->or_like('vehicle_id', $search);
		return $query = $this->db->get('truck_absent')->result();
		
	}
	
	
	public function dataRoomService($search){
		$this->db->or_like('room_service_id', $search);
		$this->db->or_like('room_service_name', $search);
		return $query = $this->db->get('room_service')->result();
		
	}
	
	
	public function dataOrigin($search){
		$this->db->or_like('customer_id', $search);
		$this->db->or_like('customer_name', $search);
		return $query = $this->db->get('customer')->result();
		
	}
	
	public function dataTransporter($search){
		$this->db->or_like('transporter_id', $search);
		$this->db->or_like('transporter_name', $search);
		return $query = $this->db->get('transporter')->result();
		
	}
	
	public function dataLocation($search,$warehouse_code){
		$this->db->or_like('location_code', $search);
		if($warehouse_code!='')
		{
		$this->db->where("warehouse_code = '".$warehouse_code."' ");
		}
		$this->db->join('location_type', 'location.id_location_type = location_type.id_location_type','LEFT');
		return $query = $this->db->get('location')->result();
	}
	
	
	public function dataVehicleType($search){
		$this->db->or_like('vehicle_type', $search);
		$this->db->or_like('description', $search);
		return $query = $this->db->get('vehicle_type')->result();
		
	}
	
	public function dataProvince($search){
		$this->db->or_like('province_name', $search);
		return $query = $this->db->get('master_province')->result();
		
	}
	
	
	public function dataArea($search){
		$this->db->or_like('area_id', $search);
		$this->db->or_like('area_description', $search);
		return $query = $this->db->get('master_area')->result();
		
	}
	
	public function dataClient($search){
		$this->db->or_like('client_id', $search);
		$this->db->or_like('client_name', $search);
		return $query = $this->db->get('master_client')->result();
		
	}
	
	public function dataVendor($search){
		$this->db->or_like('vendor_id', $search);
		$this->db->or_like('vendor_name', $search);
		return $query = $this->db->get('master_vendor')->result();
		
	}
	
	public function dataDriver($search){
		$this->db->or_like('driver_code', $search);
		$this->db->or_like('driver_name', $search);
		return $query = $this->db->get('driver')->result();
		
	}
	
	public function dataMasterUnit($search){
		$this->db->or_like('vehicle_id', $search);
		$this->db->join('vehicle_type', 'master_unit.vehicle_type = vehicle_type.id_vehicle_type','LEFT');
		return $query = $this->db->get('master_unit')->result();
		
	}
	
	public function dataChasis($search){
		$this->db->or_like('chasis_id', $search);
		return $query = $this->db->get('master_chasis')->result();
		
	}
	
	
	public function dataProduct($search){
		$this->db->or_like('product_code', $search);
		$this->db->or_like('product_description', $search);
		return $query = $this->db->get('product')->result();
		
	}
	
	
	public function dataOrderType($search){
		$this->db->like('description', $search);
		return $query = $this->db->get('order_type')->result();
		
	}
	
	
	
	public function dataWarehouse($search){
		$this->db->like('warehouse_code', $search);
		return $query = $this->db->get('warehouse')->result();
		
	}
	
	public function dataSupplier($search){
		$this->db->like('supplier_code', $search);
		return $query = $this->db->get('supplier')->result();
		
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