<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
            $username = $_REQUEST["username"];
            $password = $_REQUEST["password"];
    
            $database = new Database();
            $conn = $database->connect();
    
            Login::logoutUser();
            if(Login::loginUser($conn, $username, $password) == true) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Successfully logged in'
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Wrong login credentials'
                ));
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