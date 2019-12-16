<?
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Author.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    function checkIsSet($variable) {
        if(isset($_REQUEST[$variable])) {
            return $_REQUEST[$variable];
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'POST ' . $variable . ' is not set'
            ));
            return null;
        }
    }

    function arrayContainsNull($array) {
        foreach ($array as &$value) {
            if($value == null) {
                return true;
            }
        }
        return false;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result_login = Login::isLogged();
        if($result_login['success'] == true) {

            $data = array(
                'title' => checkIsSet('title'),
                'location' => checkIsSet('location'),
                'date' => checkIsSet('date'),
                'hour' => checkIsSet('hour'),
                'id_meetingpoint' => checkIsSet('id_meetingpoint'),
                'latitude' => checkIsSet('latitude'),
                'longitude' => checkIsSet('longitude'),
                'description' => checkIsSet('description')
            )

            if(!arrayContainsNull($data)) {
                $database = new Database();
                $conn = $database->connect();

                $result = Travels::postTravel($conn, $data['title'], $data['location'], $data['date'], $data['hour'], $data['id_meetingpoint'], $data['latitude'], $data['longitude'], $data['description']);
                echo json_encode($result);
            }
        } else {
            echo json_encode($result_login);
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Use POST method'
        ));
    }
?>