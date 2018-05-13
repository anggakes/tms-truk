<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 5/6/18
 * Time: 1:18 PM
 */

class ApiLib
{
    protected $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    public function response($controller, $data, $httpStatusCode){
        return $controller->output
            ->set_content_type('application/json')
            ->set_status_header($httpStatusCode)
            ->set_output(json_encode($data));
    }

    public function responseUnauthorized($controller){

        return $this->response($controller,[
            'message' => 'unauthorized',
            'code'    => 90002
        ], 401);
    }

    public function responseNotFound($controller){

        return $this->response($controller,[
            'message' => 'not found',
            'code'    => 90003
        ], 404);
    }

    public function responseInternalError($controller){

        return $this->response($controller,[
            'message' => 'internal server error',
            'code'    => 90000
        ], 500);
    }

    public function getToken($controller){
        $header = trim($controller->input->get_request_header('Authorization'));
        if(!$header) return false;

        if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $token =  $matches[1];

            return $token;

        }else{
            return false;
        }
    }

    public function isValidToken($controller){

        $token  = $this->getToken($controller);

        if(!$token) return $token;

        $this->CI->load->model('model_driver_login_token','', true);
        $userId = $this->CI->model_driver_login_token->find($token);

        if($userId === false) return false;

        return $userId;

    }

    public function getDriver($driverId){

        $driver = $this->CI->model_driver->getDriver('WHERE id_driver = "'.$driverId.'" ')->result();
        if(!isset($driver[0])) return false;

        return $driver[0];
    }

}