<?
    include('../../class/Main.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $main = new Main();
        echo $main->getTravels();
    } else {
        return json_encode(array(
            'success' => false,
            'message' => 'Use GET method. To add a travel use POST api/travel.php'
        ));
    }
?>