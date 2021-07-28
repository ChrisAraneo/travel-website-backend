<?php
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Login.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/MeetingPoints.php');

    if(Request::getUser() == true) {
        $database = new Database();
        $conn = $database->connect();

        echo json_encode(array(
            'success' => true,
            'message' => 'OK',
            'data' => MeetingPoints::getMeetingPoints($conn)
        ));
    }
?>