<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $database = new Database();
        $conn = $database->connect();

        Login::logoutUser();
        Login::loginUser($conn, $username, $password);

        if(Login::isLogged() == true) {
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
            'message' => 'Use POST method'
        ));
    }
?>