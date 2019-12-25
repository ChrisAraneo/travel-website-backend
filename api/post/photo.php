<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Photos.php');

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result_logged = Login::isLoggedAsAdmin();
        if($result_logged['success'] == true) {
            if(isset($_FILES['file']) && isset($_POST['id_travel'])) {
                $id_travel = $_POST['id_travel'];
                $filename = $_FILES['file']['name'] . '.php';
                $result = Photos::uploadPhoto($_FILES['file']);
                
                if($result['success'] == true) {
                    $database = new Database();
                    $conn = $database->connect();
                    
                    $result_photo = Photos::postPhoto($conn, $id_travel, $filename);
                    echo json_encode($result_photo);
                } else {
                    echo json_encode($result);
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Make sure FILES file and POST id_travel are set'
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