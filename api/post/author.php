<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Authors.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result_logged = Login::isLogged();
        if($result_logged['success'] == true) {
            if(isset($_REQUEST['firstname']) && isset($_REQUEST['lastname'])) {
                $firstname = $_REQUEST['firstname'];
                $lastname = $_REQUEST['lastname'];
        
                $database = new Database();
                $conn = $database->connect();
        
                $result = Authors::postAuthor($conn, $firstname, $lastname);
                echo json_encode($result);
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'POST firstname & POST lastname not set'
                ));
            }
        } else {
            echo json_encode($result_logged);
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use POST method'
        ));
    }
?>