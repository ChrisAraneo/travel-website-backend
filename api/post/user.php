<?
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Users.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
    
            $database = new Database();
            $conn = $database->connect();
    
            Users::postUser($conn, $username, $password);
    
            echo json_encode(array(
                'success' => true,
                'message' => 'OK'
            ));
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