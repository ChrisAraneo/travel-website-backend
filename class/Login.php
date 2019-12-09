<?
    include(dirname(__FILE__).'/../model/Users.php');

    class Login {

        private static function startSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
                $_SESSION['login'] = false;
            }
        }

        private static function destroySession() {
            if (session_status() != PHP_SESSION_NONE) {
                session_unset();
                session_destroy();
            }
        }

        public static function loginUser($conn, $username, $password) {
            Login::startSession();

            $result = Users::getUser($conn, $username);
            $row = $result[0];
            $correct_hash = $row['password'];

            if(password_verify($password, $correct_hash)) {
                $_SESSION['login'] == $username;
                return true;
            } else {
                Login::logoutUser();
                return false;
            }
        }

        public static function logoutUser() {
            if (session_status() != PHP_SESSION_NONE) {
                Login::destroySession();
                return 'Logged out';
            } else {
                return 'You are already logged out';
            }
        }

        public static function isLogged() {
            if (session_status() == PHP_SESSION_NONE) {
                return "You need to be logged in. Enable cookies - can't provide session";
            } else if($_SESSION['login'] != false) {
                return true;
            } else {
                return "You are not logged in";
            }
        }

        public static function isLoggedAsAdmin() {
            if (session_status() == PHP_SESSION_NONE) {
                return false;
            } else if($_SESSION['login'] == 'admin') {
                return true;
            }
            return false;
        }
    }
?>