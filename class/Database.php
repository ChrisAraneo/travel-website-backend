<?
    class Database {
        private $host = null;
        private $dbname = null;
        private $username = null;
        private $conn = null;

        public function __construct($host, $dbname, $username, $password) {
            $this->host = $host;
            $this->dbname = $dbname;
            $this->username = $username;
            $this->password = $password;
        }

        private function connect() {
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