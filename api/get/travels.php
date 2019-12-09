<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Travels.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(Login::isLogged() == true) {
            $database = new Database();
            $conn = $database->connect();

            echo json_encode(array(
                'success' => true,
                'message' => '',
                'data' => Travels::getTravels($conn)
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Not logged'
            ));
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use GET method. To add a travel use POST api/travel.php'
        ));
    }
?>