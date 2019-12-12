<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Photos.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isLogged = Login::isLogged();
        if($isLogged == true) {
            if(isset($_FILES['file']) && isset($_REQUEST['id_travel'])) {
                $id_travel = $_REQUEST['id_travel'];
                $filename = $_FILES['file']['name'];
                $result = Photos::uploadPhoto($_FILES['file']);
                
                if($result['success'] == true) {
                    $database = new Database();
                    $conn = $database->connect();
                    
                    $photoResult = Photos::postPhoto($conn, $id_travel, $filename);

                    if($photoResult == true) {
                        echo json_encode(array(
                            'success' => true,
                            'message' => "OK"
                        ));
                    } else {
                        echo json_encode(array(
                            'success' => false,
                            'message' => $photoResult
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => $result['message']
                    ));
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Make sure FILES file and REQUEST id_travel are set'
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