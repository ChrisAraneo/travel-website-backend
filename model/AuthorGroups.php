<?
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
        public static function postAuthorToGroup($conn, $id_author, $id_travel) {
            // CHECKING IF TRAVEL EXIST
            if(sizeof(Travels::getTravel($conn, $id_tarvel)) < 1) {
                return "Travel ". $id_travel . " doesn't exist in database";
            }

            // CHECKING IF AUTHOR EXIST
            if(sizeof(Authors::getAuthor($conn, $id_author)) < 1) {
                return "Author ". $id_author . " doesn't exist in database";
            }

            // ADDING AUTHORGROUPS RECORD
            $query = 'INSERT INTO AuthorGroups ($id_author, $id_travel) VALUES ('
            . '\'' . $id_author . '\', '
            . '\'' . $id_travel . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return true;
        }
    }
 ?>