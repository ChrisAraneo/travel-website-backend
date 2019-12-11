<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Authors.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isLogged = Login::isLogged();
        if($isLogged == true) {
            if(isset($_FILES['file']) && isset($_REQUEST['id_travel'])) {

                $result = Photos::uploadPhoto($_FILES['file']);
                

                if($result == true) {
                    $database = new Database();
                    $conn = $database->connect();

                    $id_travel = $_REQUEST['id_travel'];
                    $filename = ''; // TO DO
                    Photos::postPhoto($conn, $id_travel, $filename);

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
                    'message' => 'Make sure FILES file, REQUEST id_travel is set'
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