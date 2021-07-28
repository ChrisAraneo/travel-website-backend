<?php  
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/Users.php');

    if(Request::post() == true) {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $database = new Database();
            $conn = $database->connect();
    
            $result = Users::postUser($conn, $username, $password);
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'POST username & POST password not set'
            ));
        }
    }
?>