<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/MeetingPoints.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result_logged = Login::isLogged();
        if($result_logged['success'] == true) {
            if(isset($_REQUEST['name']) && isset($_REQUEST['address'])) {
                $name = $_REQUEST['name'];
                $address = $_REQUEST['address'];
        
                $database = new Database();
                $conn = $database->connect();
        
                $result = MeetingPoints::postMeetingPoint($conn, $name, $address);
                echo json_encode($result);
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'POST name & POST address not set'
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