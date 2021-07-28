<?php
    include_once(dirname(__FILE__).'/Authors.php');
    include_once(dirname(__FILE__).'/Travels.php');
    /*
        CREATE TABLE AuthorGroups (
            id_author int NOT NULL,
            id_travel int NOT NULL,
            PRIMARY KEY (id_author, id_travel),
            FOREIGN KEY (id_author) REFERENCES Authors(id_author),
            FOREIGN KEY (id_travel) REFERENCES Travels(id_travel)
        );
    */
    class AuthorGroups {
        public static function getAuthorGroups($conn) {
            $query = 'SELECT * FROM AuthorGroups;';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_author' => $id_author,
                        'id_travel' => $id_travel
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function postAuthorToGroup($conn, $id_author, $id_travel) {
            // CHECKING IF TRAVEL EXIST
            if(sizeof(Travels::getTravel($conn, $id_travel)) < 1) {
                return array(
                    'success' => false,
                    'message' => "Travel ". $id_travel . " doesn't exist in database"
                );
            }

            // CHECKING IF AUTHOR EXIST
            if(sizeof(Authors::getAuthor($conn, $id_author)) < 1) {
                return array(
                    'success' => false,
                    'message' => "Author ". $id_author . " doesn't exist in database"
                );
            }

            // ADDING AUTHORGROUPS RECORD
            $query = 'INSERT INTO AuthorGroups (id_author, id_travel) VALUES (' . $id_author . ', ' . $id_travel . ');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return array(
                'success' => true,
                'message' => 'OK'
            );
        }
    }
 ?>