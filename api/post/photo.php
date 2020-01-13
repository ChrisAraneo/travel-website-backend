<?
    include_once(dirname(__FILE__).'/../../class/Login.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/Photos.php');

    if(Request::postAdmin() == true) {
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
    }
?>