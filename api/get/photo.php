<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Authors.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $isLogged = Login::isLogged();
        if($isLogged == true) {
            
            // $database = new Database();
            // $conn = $database->connect();

            // echo json_encode(array(
            //     'success' => true,
            //     'message' => '',
            //     'data' => Authors::getAuthors($conn)
            // ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => $isLogged
            ));
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use GET method. To upload an image use POST api/photo.php'
        ));
    }
?>