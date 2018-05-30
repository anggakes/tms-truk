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
        $this->load->model('model_transport_order_api');


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

        if(!isset($_POST['manifest_id']))
            return $this->apilib->response($this, ['message' => 'manifest id not set', 'code' => 0], 400);

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

        if(!isset($_POST['manifest_id']))
            return $this->apilib->response($this, ['message' => 'manifest id not set', 'code' => 0], 400);

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

        if(!isset($_POST['manifest_id']))
            return $this->apilib->response($this, ['message' => 'manifest_id not set', 'code' => 0], 400);

        if(!isset($_POST['actual_qty']))
            return $this->apilib->response($this, ['message' => 'actual_qty not set', 'code' => 0], 400);

        $manifestId = $_POST['manifest_id'];
        $status = 'selesai muat';
        $status_foto = 'manifest';
        $actualQty = $_POST['actual_qty'];

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_manifest->detail($manifestId);

        if(!$res) return $this->apilib->responseNotFound($this);

        if(!isset($_FILES['photo_1'])) return $this->apilib->response($this, array(
            'message' => 'Photo harus diisi',
            'code' => 0
        ), 400);


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
            $this->model_transport_order_photo->insert($manifestId, $status_foto, base_url('files/images/'.$uploadRes));

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
            $this->model_transport_order_photo->insert($manifestId, $status_foto, base_url('files/images/'.$uploadRes));
        }


        return $this->apilib->response($this, $res, 200);

    }

    public function failedLoading(){

        $this->load->model('model_transport_order_cancel_reason');

        $type = 'loading';
        $status = 'tidak terkirim';
        $status_foto = 'manifest';

        if(!isset($_POST['manifest_id']))
            return $this->apilib->response($this, ['message' => 'manifest_id not set', 'code' => 0], 400);
        if(!isset($_POST['reason']))
            return $this->apilib->response($this, ['message' => 'reason not set', 'code' => 0], 400);

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
            $this->model_transport_order_photo->insert($manifestId, $status_foto, base_url('files/images/'.$uploadRes));

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
            $this->model_transport_order_photo->insert($manifestId, $status_foto, base_url('files/images/'.$uploadRes));
        }



        return $this->apilib->response($this, $res, 200);


    }


    /** ========================= START PICKUP ===================================== */

    // get onProgress DO
    public function pickup(){

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $driver = $this->apilib->getDriver($userId);

        $res = $this->model_transport_order_api->allByDriverNotFinished($driver->driver_code);

        return $this->apilib->response($this, $res, 200);

    }

    public function doDetail($spkNumber){


        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $res = $this->model_transport_order_api->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        return $this->apilib->response($this, $res, 200);
    }


    public function arrivalDestination(){

        if(!isset($_POST['spk_number']))
            return $this->apilib->response($this, ['message' => 'spk_number not set', 'code' => 0], 400);

        $spkNumber = $_POST['spk_number'];
        $status = 'tiba lokasi bongkar';

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_transport_order_api->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_transport_order_api->updateTrafficMonitoring($spkNumber, [
            'arrival_destination_date' => date('Y-m-d'),
            'arrival_destination_time' => date('H:i:s'),
            'status' => $status
        ]);

        $res = $this->model_transport_order_api->detail($spkNumber);

        return $this->apilib->response($this, $res, 200);

    }

    public function startUnLoading(){

        if(!isset($_POST['spk_number']))
            return $this->apilib->response($this, ['message' => 'spk_number not set', 'code' => 0], 400);

        $spkNumber = $_POST['spk_number'];
        $status = 'mulai bongkar';

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_transport_order_api->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        $this->model_transport_order_api->updateTrafficMonitoring($spkNumber, [
            'start_unloading_date' => date('Y-m-d'),
            'start_unloading_time' => date('H:i:s'),
            'status' => $status
        ]);

        $res = $this->model_transport_order_api->detail($spkNumber);

        return $this->apilib->response($this, $res, 200);

    }

    public function finishUnLoading(){

        $this->load->model('model_transport_order_photo');

        if(!isset($_POST['spk_number']))
            return $this->apilib->response($this, ['message' => 'spk_number not set', 'code' => 0], 400);
        if(!isset($_POST['actual_qty']))
            return $this->apilib->response($this, ['message' => 'actual_qty not set', 'code' => 0], 400);

        $spkNumber = $_POST['spk_number'];
        $status = 'terkirim';
        $status_foto = 'spk';
        $actualQty = $_POST['actual_qty'];

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        // check exist
        $res = $this->model_transport_order_api->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);

        if(!isset($_FILES['photo_1'])) return $this->apilib->response($this, array(
            'message' => 'Photo harus diisi',
            'code' => 0
        ), 400);

        $this->model_transport_order_api->updateTrafficMonitoring($spkNumber, [
            'finish_unloading_date' => date('Y-m-d'),
            'finish_unloading_time' => date('H:i:s'),
            'status' => $status
        ]);

        $this->model_transport_order_api->updateDO($spkNumber, [
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
            $this->model_transport_order_photo->insert($spkNumber, $status_foto, base_url('files/images/'.$uploadRes));

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
            $this->model_transport_order_photo->insert($spkNumber, $status_foto, base_url('files/images/'.$uploadRes));
        }



        $res = $this->model_transport_order_api->detail($spkNumber);

        return $this->apilib->response($this, $res, 200);

    }


    public function failedUnLoading(){

        $this->load->model('model_transport_order_cancel_reason');

        if(!isset($_POST['spk_number']))
            return $this->apilib->response($this, ['message' => 'spk_number not set', 'code' => 0], 400);
        if(!isset($_POST['reason']))
            return $this->apilib->response($this, ['message' => 'reason not set', 'code' => 0], 400);

        $type = 'unloading';
        $status = 'tidak terkirim';
        $status_foto = 'spk';
        $spkNumber = $_POST['spk_number'];
        $reason  = $_POST['reason'];

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);


        // update cancel DO

        $res = $this->model_transport_order_api->detail($spkNumber);

        if(!$res) return $this->apilib->responseNotFound($this);


        $this->model_transport_order_api->updateTrafficMonitoring($spkNumber, [
            'status' => $status
        ]);

        $this->model_transport_order_cancel_reason->insert($spkNumber, $type, $reason);

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
            $this->model_transport_order_photo->insert($spkNumber, $status_foto, base_url('files/images/'.$uploadRes));

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
            $this->model_transport_order_photo->insert($spkNumber, $status_foto, base_url('files/images/'.$uploadRes));
        }


        $res = $this->model_transport_order_api->detail($spkNumber);



        return $this->apilib->response($this, $res, 200);


    }

    /** ===================== FINISHED =====================*/

    public function history(){

        $userId = $this->apilib->isValidToken($this);

        if($userId === false) return $this->apilib->responseUnauthorized($this);

        $driver = $this->apilib->getDriver($userId);

        $res = $this->model_transport_order_api->allByDriverFinished($driver->driver_code);

        return $this->apilib->response($this, $res, 200);

    }


}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */