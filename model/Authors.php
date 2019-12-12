<?
    /*
        CREATE TABLE Authors (
            id_author int NOT NULL AUTO_INCREMENT,
            firstname varchar(255) NOT NULL,
            lastname varchar(255) NOT NULL,
            PRIMARY KEY (id_author)
        );
    */
    class Authors {
        public static function getAuthor($conn, $id_author) {
            $query = 'SELECT * FROM Authors WHERE id_author = ' . $id_author . ';';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_author' => $id_author,
                        'firstname' => $firstname,
                        'lastname' => $lastname
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function getAuthors($conn) {
            $query = 'SELECT * FROM Authors;';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_author' => $id_author,
                        'firstname' => $firstname,
                        'lastname' => $lastname
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function postAuthor($conn, $firstname, $lastname) {
            $query = 'INSERT INTO Authors (firstname, lastname) VALUES ('
            . '\'' . $firstname . '\', '
            . '\'' . $lastname . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();
        }
    }
?>