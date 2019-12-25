<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Authors.php');

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result_logged = Login::isLoggedAsAdmin();
        if($result_logged['success'] == true) {
            if(isset($_POST['firstname']) && isset($_POST['lastname'])) {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
        
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
