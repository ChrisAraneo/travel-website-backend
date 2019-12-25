<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/AuthorGroups.php');

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result_logged = Login::isLoggedAsAdmin();
        if($result_logged['success'] == true) {
            if(isset($_POST['id_author']) && isset($_POST['id_travel'])) {
                $id_author = $_POST['id_author'];
                $id_travel = $_POST['id_travel'];
        
                $database = new Database();
                $conn = $database->connect();
        
                $result = AuthorGroups::postAuthorToGroup($conn, $id_author, $id_travel);
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