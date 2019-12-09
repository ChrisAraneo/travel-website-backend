<?
    class Login {

        private function startSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
                
                $_SESSION['login'] = false;
            }
        }

        private function destroySession() {
            if (session_status() != PHP_SESSION_NONE) {
                session_unset();
                session_destroy();
            }
        }

        public function logIn($conn, $username, $password) {
            $this->startSession();

            $result = Users::getUser($conn, $username);
            $correct_hash = null;

            if($result->rowCount() > 0) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $correct_hash = $row['password'];
                }
            } else {
                $this->logOut();
                return false;
            }

            if(password_verify($password, $correct_hash)) {
                $_SESSION['login'] == $username;
                return true;
            } else {
                $this->logOut();
                return false;
            }
        }

        public function logOut() {
            $this->destroySession();
        }

        public function isLogged() {
            if (session_status() == PHP_SESSION_NONE) {
                return false;
            } else if($_SESSION['login'] != false) {
                return true;
            }
            return false;
        }

        public function isLoggedAsAdmin() {
            if (session_status() == PHP_SESSION_NONE) {
                return false;
            } else if($_SESSION['login'] == 'admin') {
                return true;
            }
            return false;
        }
    }
?>