<?
    include(dirname(__FILE__).'/../model/Users.php');

    class Login {

        private static function startSession() {
            if (session_status() != PHP_SESSION_ACTIVE) {
                session_start();
                $_SESSION['login'] = false;
            }
        }

        private static function destroySession() {
            if (session_status() == PHP_SESSION_ACTIVE) {
                session_unset();
                session_destroy();
            }
        }

        public static function loginUser($conn, $username, $password) {
            Login::startSession();

            $result = Users::getUser($conn, $username);

            if(empty($result)) {
                return array(
                    'success' => false,
                    'message' => 'User doesn\'t exist'
                );
            } else {
                $row = $result[0];
                $correct_hash = $row['password'];
    
                if(password_verify($password, $correct_hash)) {
                    $_SESSION['login'] = $username;
                    return array(
                        'success' => true,
                        'message' => 'Successfully logged in'
                    );
                } else {
                    Login::logoutUser();
                    return array(
                        'success' => false,
                        'message' => 'Incorrect password'
                    );
                }
            }
        }

        public static function logoutUser() {
            if (session_status() != PHP_SESSION_NONE) {
                Login::destroySession();
                return array(
                    'success' => true,
                    'message' => 'Successfully logged out'
                );
            } else {
                return array(
                    'success' => true,
                    'message' => 'You are already logged out'
                );
            }
        }

        public static function isLogged() {
            if(session_status() == PHP_SESSION_DISABLED) {
                return array(
                    'success' => false,
                    'message' => 'Session is disabled. Make sure you have cookies enabled in your browser.'
                );
            } else if (session_status() == PHP_SESSION_NONE) {
                return array(
                    'success' => false,
                    'message' => 'You need to be logged in. Make sure you have cookies enabled in your browser.'
                );
            } else if(session_status() == PHP_SESSION_ACTIVE) {
                if(isset($_SESSION['login'])) {
                    if($_SESSION['login'] != false) {
                        return array(
                            'success' => true,
                            'message' => 'You are logged in.'
                        );
                    } else {
                        return array(
                            'success' => false,
                            'message' => 'Session is active but you are not logged in (login var is false).'
                        );
                    }
                } else {
                    return array(
                        'success' => false,
                        'message' => 'Session is active but you need to log in first (login var is empty).'
                    );
                }
            }
        }

        public static function isLoggedAsAdmin() {
            if(session_status() == PHP_SESSION_DISABLED) {
                return array(
                    'success' => false,
                    'message' => 'Session is disabled. Make sure you have cookies enabled in your browser.'
                );
            } else if (session_status() == PHP_SESSION_NONE) {
                return array(
                    'success' => false,
                    'message' => 'You need to be logged in. Make sure you have cookies enabled in your browser.'
                );
            } else if(session_status() == PHP_SESSION_ACTIVE) {
                if(isset($_SESSION['login'])) {
                    if($_SESSION['login'] != false) {
                        if($_SESSION['login'] == 'admin') {
                            return array(
                                'success' => true,
                                'message' => 'You are logged in as admin.'
                            );
                        } else {
                            return array(
                                'success' => false,
                                'message' => 'You are logged in but you don\'t have admin privilages.'
                            );
                        }
                    } else {
                        return array(
                            'success' => false,
                            'message' => 'Session is active but you are not logged in (login var is false).'
                        );
                    }
                } else {
                    return array(
                        'success' => false,
                        'message' => 'Session is active but you need to log in first (login var is empty).'
                    );
                }
            }
        }
    }
?>