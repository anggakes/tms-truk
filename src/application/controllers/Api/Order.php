<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

    /**
     *  this file will become router
     */

    function __construct()  {
        parent::__construct();

        $this->load->model('model_driver');
        $this->load->model('model_driver_login_token');
        $this->load->library('apilib');
        $this->load->model('model_manifest');
        $this->load->model('model_transport_order');


    }


    /** ========================= START DISPATCHED ===================================== */

    public function dispatched(){

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $driver = $this->apilib->getDriver($userId);

        $res = $this->model_manifest->allByDriver($driver->driver_code);

        return $this->apilib->response($this, $res, 200);

    }

    public function manifestDetail($manifestId){


        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $res = $this->model_manifest->detail($manifestId);

        if(!$res) return $this->apilib->responseNotFound($this);

        return $this->apilib->response($this, $res, 200);
    }

    public function arrivalOrigin(){

        $manifestId = $_POST['manifest_id'];
        $status = 'tiba lokasi muat';

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_manifest->detail($manifestId);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_manifest->updateTrafficMonitoring($manifestId, [
            'arrival_origin_date' => date('Y-m-d'),
            'arrival_origin_time' => date('H:i:s'),
            'status' => $status
        ]);


        $res = $this->model_manifest->update($manifestId, [
            'status_manifest' => $status
        ]);

        return $this->apilib->response($this, $res, 200);

    }

    public function startLoading(){

        $manifestId = $_POST['manifest_id'];
        $status = 'mulai muat';

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_manifest->detail($manifestId);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_manifest->updateTrafficMonitoring($manifestId, [
            'start_loading_date' => date('Y-m-d'),
            'start_loading_time' => date('H:i:s'),
            'status' => $status
        ]);


        $res = $this->model_manifest->update($manifestId, [
            'status_manifest' => $status
        ]);

        return $this->apilib->response($this, $res, 200);

    }

    public function finishLoading(){

        $this->load->model('model_transport_order_photo');

        $manifestId = $_POST['manifest_id'];
        $status = 'selesai muat';
        $actualQty = $_POST['actual_qty'];

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_manifest->detail($manifestId);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_manifest->updateTrafficMonitoring($manifestId, [
            'finish_loading_date' => date('Y-m-d'),
            'finish_loading_time' => date('H:i:s'),
            'status' => $status
        ]);

        $res = $this->model_manifest->update($manifestId, [
            'status_manifest' => 'dalam perjalanan',
            'actual_qty' => $actualQty
        ]);

        // upload images

        $config = array(
            'upload_path' => "./files/images",
            'allowed_types' => "jpg|jpeg|png",
            'overwrite' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1024",
            'max_width' => "1024"
        );

        $this->load->library('upload', $config);

        $uploadRes = [];

        if(!isset($_FILES['photo_1'])) return $this->apilib->response($this, array(
            'message' => 'Photo harus diisi',
            'code' => 0
        ), 400);

        if(isset($_FILES['photo_1'])){
            if(!$this->upload->do_upload('photo_1'))
            {
                $error = array(
                    'errors' => $this->upload->display_errors(),
                    'message' => 'error upload',
                    'code' => 0
                );

                return $this->apilib->response($this, $error, 400);
            }

            $uploadRes = $this->upload->data()['file_name'];
            $this->model_transport_order_photo->insert($manifestId, $status, base_url('files/images/'.$uploadRes));

        }

        if(isset($_FILES['photo_2'])){
            if(!$this->upload->do_upload('photo_2'))
            {
                $error = array(
                    'errors' => $this->upload->display_errors(),
                    'message' => 'error upload',
                    'code' => 0
                );

                return $this->apilib->response($this, $error, 400);
            }

            $uploadRes = $this->upload->data()['file_name'];
            $this->model_transport_order_photo->insert($manifestId, $status, base_url('files/images/'.$uploadRes));
        }


        return $this->apilib->response($this, $res, 200);

    }

    public function failedLoading(){

        $this->load->model('model_transport_order_cancel_reason');

        $type = 'loading';
        $status = 'tidak terkirim';
        $manifestId = $_POST['manifest_id'];
        $reason  = $_POST['reason'];

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $res = $this->model_manifest->detail($manifestId);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_manifest->updateTrafficMonitoring($manifestId, [
            'status' => $status
        ]);

        foreach ($res->dispatch_order as $do){

            $this->model_transport_order_cancel_reason->insert($do->spk_number, $type, $reason);
        }

        $res = $this->model_manifest->update($manifestId, [
            'status_manifest' => 'selesai'
        ]);

        return $this->apilib->response($this, $res, 200);


    }


    /** ========================= START PICKUP ===================================== */

    // get onProgress DO
    public function pickup(){

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $driver = $this->apilib->getDriver($userId);

        $res = $this->model_transport_order->allByDriverNotFinished($driver->driver_code);

        return $this->apilib->response($this, $res, 200);

    }

    public function doDetail($spkNumber){


        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $res = $this->model_transport_order->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        return $this->apilib->response($this, $res, 200);
    }


    public function arrivalDestination(){

        $spkNumber = $_POST['spk_number'];
        $status = 'tiba lokasi bongkar';

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_transport_order->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_transport_order->updateTrafficMonitoring($spkNumber, [
            'arrival_destination_date' => date('Y-m-d'),
            'arrival_destination_time' => date('H:i:s'),
            'status' => $status
        ]);

        $res = $this->model_transport_order->detail($spkNumber);

        return $this->apilib->response($this, $res, 200);

    }

    public function startUnLoading(){

        $spkNumber = $_POST['spk_number'];
        $status = 'mulai bongkar';

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_transport_order->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_transport_order->updateTrafficMonitoring($spkNumber, [
            'start_unloading_date' => date('Y-m-d'),
            'start_unloading_time' => date('H:i:s'),
            'status' => $status
        ]);

        $res = $this->model_transport_order->detail($spkNumber);

        return $this->apilib->response($this, $res, 200);

    }

    public function finishUnLoading(){

        $this->load->model('model_transport_order_photo');

        $spkNumber = $_POST['spk_number'];
        $status = 'terkirim';
        $actualQty = $_POST['actual_qty'];

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_transport_order->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_transport_order->updateTrafficMonitoring($spkNumber, [
            'finish_unloading_date' => date('Y-m-d'),
            'finish_unloading_time' => date('H:i:s'),
            'status' => $status
        ]);

        $this->model_transport_order->updateDO($spkNumber, [
            'actual_qty' => $actualQty
        ]);

        // update manifest
        $notFinished = $this->model_manifest->getDOnotFinished($res->manifest);

        if(count($notFinished) <= 0){
            $this->model_manifest->update($res->manifest, [
                'status_manifest' => 'selesai'
            ]);
        }

        // upload images

        $config = array(
            'upload_path' => "./files/images",
            'allowed_types' => "jpg|jpeg|png",
            'overwrite' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "1024",
            'max_width' => "1024"
        );

        $this->load->library('upload', $config);

        $uploadRes = [];

        if(!isset($_FILES['photo_1'])) return $this->apilib->response($this, array(
            'message' => 'Photo harus diisi',
            'code' => 0
        ), 400);

        if(isset($_FILES['photo_1'])){
            if(!$this->upload->do_upload('photo_1'))
            {
                $error = array(
                    'errors' => $this->upload->display_errors(),
                    'message' => 'error upload',
                    'code' => 0
                );

                return $this->apilib->response($this, $error, 400);
            }

            $uploadRes = $this->upload->data()['file_name'];
            $this->model_transport_order_photo->insert($spkNumber, $status, base_url('files/images/'.$uploadRes));

        }

        if(isset($_FILES['photo_2'])){
            if(!$this->upload->do_upload('photo_2'))
            {
                $error = array(
                    'errors' => $this->upload->display_errors(),
                    'message' => 'error upload',
                    'code' => 0
                );

                return $this->apilib->response($this, $error, 400);
            }

            $uploadRes = $this->upload->data()['file_name'];
            $this->model_transport_order_photo->insert($spkNumber, $status, base_url('files/images/'.$uploadRes));
        }



        $res = $this->model_transport_order->detail($spkNumber);

        return $this->apilib->response($this, $res, 200);

    }


    public function failedUnLoading(){

        $this->load->model('model_transport_order_cancel_reason');

        $type = 'unloading';
        $status = 'tidak terkirim';
        $spkNumber = $_POST['spk_number'];
        $reason  = $_POST['reason'];

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);


        // update cancel DO

        $res = $this->model_transport_order->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);


        $this->model_transport_order->updateTrafficMonitoring($spkNumber, [
            'status' => $status
        ]);

        $this->model_transport_order_cancel_reason->insert($spkNumber, 'unloading', $reason);

        // update manifest
        $notFinished = $this->model_manifest->getDOnotFinished($res->manifest);

        if(count($notFinished) <= 0){
            $this->model_manifest->update($res->manifest, [
                'status_manifest' => 'selesai'
            ]);
        }

        $res = $this->model_transport_order->detail($spkNumber);



        return $this->apilib->response($this, $res, 200);


    }

    /** ===================== FINISHED =====================*/

    public function history(){

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $driver = $this->apilib->getDriver($userId);

        $res = $this->model_transport_order->allByDriverFinished($driver->driver_code);

        return $this->apilib->response($this, $res, 200);

    }


}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */