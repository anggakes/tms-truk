<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 5/6/18
 * Time: 1:34 PM
 */

class model_driver_login_token extends CI_Model
{

    public function insert($driverId, $token){
        $data = [
            'driver_id'  => $driverId,
            'token' => $token,
        ];
        $res = $this->db->insert('driver_login_token',$data);
        return $res;
    }

    public function find($token){
        $data = $this->db->query("SELECT * FROM driver_login_token WHERE token='".$token."'")->result();
        if(!isset($data[0])) return false;

        return $data[0]->driver_id;
    }

    public function delete($token){
        $delete = $this->db->delete('driver_login_token',array("token" => $token));
        return $delete;
    }

}