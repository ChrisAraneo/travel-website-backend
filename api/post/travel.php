<?
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Login.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/Travels.php');


    function checkIsSet($variable) {
        if(isset($_POST[$variable])) {
            return $_POST[$variable];
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

    if(Request::postAdmin() == true) {
        $data = array(
            'title' => checkIsSet('title'),
            'location' => checkIsSet('location'),
            'date' => checkIsSet('date'),
            'hour' => checkIsSet('hour'),
            'id_meetingpoint' => checkIsSet('id_meetingpoint'),
            'latitude' => checkIsSet('latitude'),
            'longitude' => checkIsSet('longitude'),
            'description' => checkIsSet('description')
        );

        if(!arrayContainsNull($data)) {
            $database = new Database();
            $conn = $database->connect();

            $result = Travels::postTravel($conn, $data['title'], $data['location'], $data['date'], $data['hour'], $data['id_meetingpoint'], $data['latitude'], $data['longitude'], $data['description']);
            echo json_encode($result);
        }
    }
?>