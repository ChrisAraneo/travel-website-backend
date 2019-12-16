<?
    include(dirname(__FILE__).'/../../class/Login.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $result_logout = Login::logoutUser();
    echo json_encode($result_logout);
?>