<?
    include(dirname(__FILE__).'/../../class/Login.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $message = Login::logoutUser();

    echo json_encode(array(
        'success' => true,
        'message' => $message
    ));
?>