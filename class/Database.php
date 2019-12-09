<?
    include(dirname(__FILE__).'/../secure/config.php');

    class Database {
        private $host = null;
        private $dbname = null;
        private $username = null;
        private $password = null;
        private $conn = null;

        public function __construct() {
            $config = new Config();

            $this->host = $config->DB_HOST;
            $this->dbname = $config->DB_DBNAME;
            $this->username = $config->DB_USERNAME;
            $this->password = $config->DB_PASSWORD;
        }

        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOEXCEPTION $e) {
                echo 'Connection error: ' . $e->getMessage();
            }

            return $this->conn;
        }
    }
?>