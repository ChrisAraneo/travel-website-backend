<?php
    include_once(dirname(__FILE__).'/../../class/Request.php');

    if(Request::getUser() == true) {
        if(isset($_GET['filename'])) {
            $filename = $_GET['filename'];
            $path = dirname(__FILE__).'/../../upload/' . $filename . '.php';
            if(file_exists($path)) {
                include_once($path);
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Incorrect filename',
                    'data' => ''
                ));
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'GET filename is missing',
                'data' => ''
            ));
        }
    }
?>