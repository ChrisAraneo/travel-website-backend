<?php

    include_once(dirname(__FILE__).'/Database.php');
    include_once(dirname(__FILE__).'/Login.php');

    class Request {

        public static function get() {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                return true;
            } else {
                echo json_token(array(
                    'success' => false,
                    'message' => 'Use GET method'
                ));
                return false;
            }
        }

        public static function getUser() {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if(isset($_GET['token'])) {
                    $database = new Database();
                    $conn = $database->connect();
                    $jwt = $_GET['token'];

                    $result_login = Login::isLogged($conn, $jwt);
                    if($result_login["success"] == true) {
                        return true;
                    } else {
                        echo json_encode($result_login);
                        return false;
                    }
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Include token in GET token'
                    ));
                    return false;
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Use GET method'
                ));
                return false;
            }
        }

        public static function post() {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                return true;
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Use POST method'
                ));
                return false;
            }
        }

        public static function postUser() {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['token'])) {
                    $database = new Database();
                    $conn = $database->connect();
                    $jwt = $_POST['token'];

                    $result_login = Login::isLogged($conn, $jwt);
                    if($result_login["success"] == true) {
                        return true;
                    } else {
                        echo json_encode($result_login);
                        return false;
                    }
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Include token in POST token'
                    ));
                    return false;
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Use POST method'
                ));
                return false;
            }
        }

        public static function postAdmin() {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['token'])) {
                    $database = new Database();
                    $conn = $database->connect();
                    $jwt = $_POST['token'];

                    $result_logged = Login::isLogged($conn, $jwt);
                    if($result_logged['success'] == true) {
                        if($result_logged['username'] == "admin") {
                            return true;
                        } else {
                            echo json_encode(array(
                                'success' => false,
                                'message' => 'You must be logged as admin'
                            ));
                            return false;
                        }
                    } else {
                        echo json_encode($result_logged);
                        return false;
                    }
                } else {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Include token in POST token'
                    ));
                    return false;
                }
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Use POST method'
                ));
                return false;
            }
        }
    }
?>