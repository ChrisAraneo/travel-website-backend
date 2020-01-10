<?php
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
    
            $database = new Database();
            $conn = $database->connect();
    
            $result_logout = Login::logoutUser();
            
            if($result_logout['success'] == true) {
                $result_login = Login::loginUser($conn, $username, $password);
                echo json_encode($result_login);
            } else {
                echo json_encode($result_logout);
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'POST username & POST password not set'
            ));
        }        
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use POST method'
        ));
    }
?>