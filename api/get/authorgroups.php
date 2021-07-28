<?php
    include_once(dirname(__FILE__).'/../../class/Request.php');
    include_once(dirname(__FILE__).'/../../class/Database.php');
    include_once(dirname(__FILE__).'/../../model/AuthorGroups.php');

    if(Request::getUser() == true) {
        $database = new Database();
        $conn = $database->connect();

        echo json_encode(array(
            'success' => true,
            'message' => 'OK',
            'data' => AuthorGroups::getAuthorGroups($conn)
        ));
    }
?>