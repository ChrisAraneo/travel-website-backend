<?php
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Login.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/MeetingPoints.php');

    if (Request::postAdmin() == true) {
        if(isset($_POST['name']) && isset($_POST['address'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
    
            $database = new Database();
            $conn = $database->connect();
    
            $result = MeetingPoints::postMeetingPoint($conn, $name, $address);
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'POST name & POST address not set'
            ));
        }
    }
?>