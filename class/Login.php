<?
    include(dirname(__FILE__).'/../model/Users.php');
    include(dirname(__FILE__).'/../secure/config.php');

    include_once(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/BeforeValidException.php');
    include_once(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/ExpiredException.php');
    include_once(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/SignatureInvalidException.php');
    include_once(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/JWT.php');

    class Login {

        public static function loginUser($conn, $username, $password) {
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
                    $config = new Config();

                    $token = array(
                        "iss" => $config->ISSUED,
                        "aud" => $config->AUDIENCE,
                        "iat" => $config->ISSUED_AT,
                        "nbf" => $config->NOT_BEFORE,
                        "data" => array(
                            "username" => $username
                        )
                    );
                    $jwt = JWT::encode($token, $key);

                    return array(
                        'success' => true,
                        'message' => 'Successfully logged in',
                        'data' => $jwt
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