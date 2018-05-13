<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 5/10/18
 * Time: 7:36 PM
 */

class Model_transport_order_photo extends CI_Model{


    public function insert($refId, $status, $url){

        $this->db->where('ref_id', $refId);
        $this->db->where('status', $status);
        $this->db->delete('transport_order_photo');

        return $this->db->insert('transport_order_photo',[
            'ref_id' => $refId,
            'status' => $status,
            'url' => $url
        ]);
    }

    public function getPhoto($refId, $status){
        $query =  "
                    SELECT * FROM transport_order_photo WHERE ref_id='$refId' AND status = '$status'
                   ";

        return  $this->db->query($query)->result();

    }


}