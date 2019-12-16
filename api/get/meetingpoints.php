<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/MeetingPoints.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result_logged = Login::isLogged();
        if($result_logged['success'] == true) {
            $database = new Database();
            $conn = $database->connect();

            echo json_encode(array(
                'success' => true,
                'message' => 'OK',
                'data' => MeetingPoints::getMeetingPoints($conn)
            ));
        } else {
            echo json_encode($result_logged);
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use GET method. To add an author use POST api/author.php'
        ));
    }
?>