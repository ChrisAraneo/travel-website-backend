<?
    include('../../class/Main.php');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $main = new Main();
        echo $main->postLogin();
    } else {
        return json_encode(array(
            'success' => false,
            'message' => 'Use POST method'
        ));
    }
?>