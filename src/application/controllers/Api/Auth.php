<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    /**
     *  this file will become router
     */

    function __construct()  {
        parent::__construct();

        $this->load->model('model_driver');
        $this->load->model('model_driver_login_token');
        $this->load->library('apilib');

    }

    public function login(){

        if(!isset($_POST['username']) || !isset($_POST['password'])) return  $this->apilib->response($this, [
            'message' => 'username atau password tidak boleh kosong',
            'code'    => 90004
        ], 400);

        $username  = $_POST['username'];
        $password = $_POST['password'];
        $pushNotifId = $_POST['push_notification_id'];

        $driver = $this->model_driver->getDriver('WHERE driver_code = "'.$username.'"')->result();

        if(!isset($driver[0])){
            return  $this->apilib->response($this, [
                'message' => 'nomor HP atau password yang anda masukkan salah',
                'code'    => 10001
            ], 400);
        }

        $driver = (array) $driver[0];

        // authentication password
        $hashpassword =  md5($password);
        if($driver['password'] !== $hashpassword){
            return  $this->apilib->response($this, [
                'message' => 'nomor HP atau password yang anda masukkan salah',
                'code'    => 10002
            ], 400);
        }


        unset($driver['password']);

        // set auth token:
        $token =  md5(uniqid());
        $res = $this->model_driver_login_token->insert($driver['id_driver'], $token, $pushNotifId);
        if(!$res) $this->apilib->responseInternalError();

        return  $this->apilib->response($this, [
            'user' => $driver,
            'token' => $token
        ], 200);
    }

    public function logout(){

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $res = $this->model_driver_login_token->delete($this->apilib->getToken($this));

        if(!$res) $this->apilib->responseInternalError();

        return  $this->apilib->response($this, [
            'success' => 'true'
        ], 200);

    }


}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */