<?php
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Login.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/Photos.php');

    if(Request::postAdmin() == true) {
        if(isset($_POST['base64']) && isset($_POST['id_travel'])) {
            $base64 = $_POST['base64'];
            $id_travel = $_POST['id_travel'];

            $result = Photos::saveBase64Photo($base64, $id_travel);
            
            if($result['success'] == true) {
                $database = new Database();
                $conn = $database->connect();

                $filename = $result['filename'];
                
                $result_photo = Photos::postPhoto($conn, $id_travel, $filename);
                echo json_encode($result_photo);
            } else {
                echo json_encode($result);
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Make sure POST base64 and POST id_travel are set'
            ));
        }
    }
?>