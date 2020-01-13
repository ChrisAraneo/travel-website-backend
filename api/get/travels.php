<?
    include(dirname(__FILE__).'/../../class/Request.php');
    include(dirname(__FILE__).'/../../class/Login.php');
    include(dirname(__FILE__).'/../../class/Database.php');
    include(dirname(__FILE__).'/../../model/Travels.php');

    if(Request::getUser() == true) {
        $database = new Database();
        $conn = $database->connect();

        echo json_encode(array(
            'success' => true,
            'message' => 'OK',
            'data' => Travels::getTravels($conn)
        ));
    }
?>