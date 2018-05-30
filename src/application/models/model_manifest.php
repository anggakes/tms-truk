<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 5/10/18
 * Time: 7:36 PM
 */

class Model_manifest extends CI_Model{


    public function allByDriver($driverCode){

        $query =  "
                    SELECT 
                    mm.id_manifest,
                    mm.origin_area,
                    mm.client_name, 
                    mm.destination_area,
                    mm.delivery_date,
                    mm.vehicle_id,
                    mm.status_manifest,
                    vt.vehicle_type
                    FROM master_manifest mm
                    LEFT JOIN vehicle_type vt ON mm.id_vehicle_type = vt.id_vehicle_type
                    WHERE driver_code='$driverCode' 
                    AND (mm.status_manifest in ('belum pickup', 'tiba lokasi muat', 'mulai muat') 
                     OR mm.status_manifest is NULL OR mm.status_manifest = ''
                    )
                   ";
        $manifest = $this->db->query($query)->result();

        $res = [];

        foreach ($manifest as $data){
            $data->dispatch_order = $this->getDO($data->id_manifest);
            $res[] = $data;
        }

        return $res;
    }

    public function getPhoto($manifestId){
        $query =  "
                    SELECT * FROM transport_order_photo WHERE ref_id='$manifestId' AND status = 'selesai muat'
                   ";

        return  $this->db->query($query)->result();

    }

    public function detail($manifestId){

        $query =  "
                    SELECT 
                    mm.id_manifest,
                    mm.origin_area,
                    mm.client_name, 
                    mm.destination_area,
                    mm.delivery_date,
                    mm.vehicle_id,
                    mm.status_manifest,
                    vt.vehicle_type
                    FROM master_manifest mm
                    LEFT JOIN vehicle_type vt ON mm.id_vehicle_type = vt.id_vehicle_type
                    WHERE mm.id_manifest='$manifestId' 
                    LIMIT 0,1
                   ";

        $manifest =  $this->db->query($query)->result();

        if(!isset($manifest[0])) return false;

        $res = $manifest[0];
        $res->dispatch_order = $this->getDO($manifestId);
        return $res;
    }

    public function update($manifestId, $data){

        $this->db->where('id_manifest', $manifestId);
        $res = $this->db->update('master_manifest', $data);

        if(!$res) return false;

        return $this->detail($manifestId);

    }

    public function updateDO($manifestId, $data){

        $this->db->where('manifest', $manifestId);
        $res = $this->db->update('transport_order', $data);

        return $res;
    }

    public function updateTrafficMonitoring($manifestId, $data){
        

        $this->db->where('id_manifest', $manifestId);
        $res = $this->db->update('traffic_monitoring', $data);

        return $res;
    }

    public function getDO($manifestId){

        $q = "SELECT 
              tro.spk_number,
              tro.qty,
              tro.do_number,
              tro.destination_area,
              tro.status as do_status,
              tm.status
              FROM 
              transport_order tro
              LEFT JOIN traffic_monitoring tm ON tm.spk_number = tro.spk_number
              where manifest = '".$manifestId."' 
              ";

        $do = $this->db->query($q)->result();
        if(!$do) $do= [];

        return $do;
    }

    public function getDOnotFinished($manifestId){

        $q = "SELECT 
              tro.spk_number,
              tro.qty,
              tro.do_number,
              tro.destination_area,
              tro.status as do_status,
              tm.status
              FROM 
              transport_order tro
              LEFT JOIN traffic_monitoring tm ON tm.spk_number = tro.spk_number
              where manifest = '".$manifestId."' AND 
              tm.status NOT IN ('terkirim', 'tidak terkirim')
              ";

        $do = $this->db->query($q)->result();
        if(!$do) $do= [];

        return $do;
    }


}