<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_transport_order_api extends CI_Model{



    /** for API */

    public function updateDO($spkNumber, $data ){

        $this->db->where('spk_number', $spkNumber);
        $res = $this->db->update('transport_order', $data);

        return $res;
    }

    public function updateTrafficMonitoring($spkNumber, $data){

        $this->db->where('spk_number', $spkNumber);
        $res = $this->db->update('traffic_monitoring', $data);

        return $res;
    }


    public function allByDriverNotFinished($driverCode){

        $q = "SELECT 
              tro.spk_number,
              tro.manifest,
              tro.qty,
              tro.do_number,
              tro.req_pick_up_date,
              tro.req_delivery_date,
              tro.origin_area,
              tro.origin_name,
              tro.origin_address,
              tro.destination_area,
              tro.destination_name,
              tro.destination_address,
              tro.status as do_status,
              origin.customer_latitude as origin_latitude,
              origin.customer_longitude as origin_longitude,
              destination.customer_latitude as destination_latitude,
              destination.customer_longitude as destination_longitude,
              tm.status
              FROM 
              master_manifest mm
              LEFT JOIN  transport_order tro ON mm.id_manifest = tro.manifest
              LEFT JOIN traffic_monitoring tm ON tm.spk_number = tro.spk_number
              LEFT JOIN customer origin ON tro.origin_id = origin.customer_id
              LEFT JOIN customer destination ON tro.origin_id = destination.customer_id
              WHERE driver_code='$driverCode' 
                    AND mm.status_manifest in ('dalam perjalanan')
                    AND  tm.status NOT IN ('terkirim', 'tidak terkirim')
                    -- OR mm.status_manifest is NULL OR mm.status_manifest = ''
              ";

        $do = $this->db->query($q)->result();
        if(!$do) $do= [];

        return $do;
    }

    public function allByDriverFinished($driverCode, $date = null){

        $where = '';
        if($date){
            $where .= "AND tm.finish_unloading_date = '$date'";
        }

        $q = "SELECT 
              tro.spk_number,
              tro.manifest,
              tro.qty,
              tro.do_number,
              tro.req_pick_up_date,
              tro.req_delivery_date,
              tro.origin_area,
              tro.origin_name,
              tro.origin_address,
              tro.destination_area,
              tro.destination_name,
              tro.destination_address,
              tm.finish_unloading_date ,
              tro.status as do_status,
              origin.customer_latitude as origin_latitude,
              origin.customer_longitude as origin_longitude,
              destination.customer_latitude as destination_latitude,
              destination.customer_longitude as destination_longitude,
              tm.status
              FROM 
              master_manifest mm
              LEFT JOIN  transport_order tro ON mm.id_manifest = tro.manifest
              LEFT JOIN traffic_monitoring tm ON tm.spk_number = tro.spk_number
              LEFT JOIN customer origin ON tro.origin_id = origin.customer_id
              LEFT JOIN customer destination ON tro.origin_id = destination.customer_id
              WHERE driver_code='$driverCode' 
                    AND  tm.status IN ('terkirim', 'tidak terkirim')
                    -- OR mm.status_manifest is NULL OR mm.status_manifest = ''
                    $where
              ORDER BY tm.finish_unloading_date DESC
              ";

        $do = $this->db->query($q)->result();
        if(!$do) $do= [];

        return $do;
    }

    public function getPhoto($spkNumber){
        $query =  "
                    SELECT * FROM transport_order_photo WHERE ref_id='$spkNumber' AND status = 'terkirim'
                   ";

        return  $this->db->query($query)->result();

    }

    public function detail($spkNumber){

        $q = "SELECT 
              tro.spk_number,
              tro.manifest,
              tro.qty,
              tro.do_number,
              tro.req_pick_up_date,
              tro.req_delivery_date,
              tro.origin_area,
              tro.origin_name,
              tro.origin_address,
              tro.destination_area,
              tro.destination_name,
              tro.destination_address,
              tro.status as do_status,
              origin.customer_latitude as origin_latitude,
              origin.customer_longitude as origin_longitude,
              destination.customer_latitude as destination_latitude,
              destination.customer_longitude as destination_longitude,
              tm.status
              FROM 
              master_manifest mm
              LEFT JOIN  transport_order tro ON mm.id_manifest = tro.manifest
              LEFT JOIN traffic_monitoring tm ON tm.spk_number = tro.spk_number
              LEFT JOIN customer origin ON tro.origin_id = origin.customer_id
              LEFT JOIN customer destination ON tro.origin_id = destination.customer_id
              WHERE tro.spk_number = '$spkNumber'
              LIMIT 0,1
              ";

        $do = $this->db->query($q)->result();
        if(!isset($do[0])) return false;

        return $do[0];
    }




}

/* End of file model_import.php */
/* Location: ./application/controllers/welcome.php */