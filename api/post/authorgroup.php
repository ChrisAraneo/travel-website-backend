<?
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Login.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/AuthorGroups.php');

    if(Request::postAdmin() == true) {
        if(isset($_POST['id_author']) && isset($_POST['id_travel'])) {
            $id_author = $_POST['id_author'];
            $id_travel = $_POST['id_travel'];
    
            $database = new Database();
            $conn = $database->connect();
    
            $result = AuthorGroups::postAuthorToGroup($conn, $id_author, $id_travel);
            echo json_encode($result);
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'POST id_author & POST id_travel not set'
            ));
        }
    }
?>