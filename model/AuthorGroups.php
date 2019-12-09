<?
    /*
        CREATE TABLE AuthorGroups (
            id_author int NOT NULL,
            id_travel int NOT NULL,
            PRIMARY KEY (id_author, id_travel),
            FOREIGN KEY (id_author) REFERENCES Authors(id_author),
            FOREIGN KEY (id_travel) REFERENCES Travels(id_travel),
        );
    */
    class AuthorGroups {
        public static postAuthorToGroup($conn, $id_author, $id_travel) {
            $query = 'INSERT INTO AuthorGroups ($id_author, $id_travel) VALUES ('
            . '\'' . $id_author . '\', '
            . '\'' . $id_travel . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return $statement;
        }
    }
 ?>