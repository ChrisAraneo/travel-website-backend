<?  
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Users.php');
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use POST method'
        ));
    }
?>