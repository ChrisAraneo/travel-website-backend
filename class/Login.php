<?
    include(dirname(__FILE__).'/../model/Users.php');
    
    include(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/BeforeValidException.php');
    include(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/ExpiredException.php');
    include(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/SignatureInvalidException.php');
    include(dirname(__FILE__).'/../vendor/firebase/php-jwt/src/JWT.php');

    use \Firebase\JWT\JWT;

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

                    $payload = array(
                        "iss" => $config->ISSUER,
                        "aud" => $config->AUDIENCE,
                        "iat" => $config->ISSUED_AT,
                        "nbf" => $config->NOT_BEFORE,
                        "data" => array(
                            "username" => $username
                        )
                    );

                    return array(
                        'success' => true,
                        'message' => 'Successfully logged in',
                        'data' => JWT::encode($payload, $config->KEY)
                    );
                } else {
                    return array(
                        'success' => false,
                        'message' => 'Incorrect password'
                    );
                }
            }
        }

        public static function isLogged($conn, $jwt) {
            $config = new Config();
            $key = $config->KEY;

            try {
                $decoded = JWT::decode($jwt, $key, array('HS256'));
            }
            catch (Exception $e){
                http_response_code(401);
                return array(
                    "success" => false,
                    "message" => $e->getMessage(),
                    "username" => null
                );
            }
            
            $username = $decoded->data->username;
            $result = Users::getUser($conn, $username);

            if(empty($result)) {
                return array(
                    'success' => false,
                    'message' => 'Incorrect token: user doesn\'t exist',
                    "username" => $username
                );
            } else {
                return array(
                    'success' => true,
                    'message' => 'Correct token',
                    "username" => $username
                );
            }
        }
    }
?>