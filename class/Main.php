<?
    include('../secure/config.php');
    include('./Login.php');
    include('./Database.php');

    include('../model/Travels.php');

    class Main {
        private $config = null;

        public function __construct() {
            $this->config = new Config();
        }

        private function connectDatabase() {
            $this->database = new Database(
                $this->config->DB_HOST;
                $this->config->DB_DBNAME;
                $this->config->DB_USERNAME;
                $this->config->DB_PASSWORD;
            );

            $conn = $this->database->connect();

            return $conn;
        }

        public function postLogin($username, $password) {
            $conn = $this->connectDatabase();

            $this->login->logOut();
            $this->login->logIn($conn, $username, $password);

            if($this->login->isLogged() == true) {
                return json_encode(array(
                    'success' => true,
                    'message' => 'Successfully logged in'
                ));
            } else {
                return json_encode(array(
                    'success' => false,
                    'message' => 'Wrong login credentials'
                ));
            }
        }

        public function getTravels() {
            if($this->login->isLogged() == true) {
                $conn = $this->connectDatabase();
                return Travels::getTravels($conn);
            } else {
                return json_encode(array(
                    'success' => false,
                    'message' => 'Not logged'
                ));
            }
        }
        
    }
?>
