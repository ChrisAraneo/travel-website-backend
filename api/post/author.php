<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Author.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isLogged = Login::isLogged();
        if($isLogged == true) {
            if(isset($_REQUEST['firstname']) && isset($_REQUEST['lastname'])) {
                $firstname = $_REQUEST['firstname'];
                $lastname = $_REQUEST['lastname'];
        
                $database = new Database();
                $conn = $database->connect();
        
                Authors::postAuthor($conn, $firstname, $lastname);
        
                echo json_encode(array(
                    'success' => true,
                    'message' => 'OK'
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'POST firstname & POST lastname not set'
                ));
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => $isLogged
            ));
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use POST method'
        ));
    }
?>