<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/AuthorGroups.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isLogged = Login::isLogged();
        if($isLogged == true) {
            if(isset($_REQUEST['id_author']) && isset($_REQUEST['id_travel'])) {
                $id_author = $_REQUEST['id_author'];
                $id_travel = $_REQUEST['id_travel'];
        
                $database = new Database();
                $conn = $database->connect();
        
                $result = AuthorGroups::postAuthorToGroup($conn, $id_author, $id_travel);
        
                if($result == true) {
                    echo json_encode(array(
                    'success' => true,
                    'message' => 'OK'
                ));
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => $result
                    ));
                }
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