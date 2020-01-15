<?
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Login.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/Authors.php');

    if(Request::postAdmin() == true) {
        if(isset($_POST['firstname']) && isset($_POST['lastname'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
    
            $database = new Database();
            $conn = $database->connect();
    
            $result = Authors::postAuthor($conn, $firstname, $lastname);
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'POST firstname & POST lastname not set'
            ));
        }
    }
?>
