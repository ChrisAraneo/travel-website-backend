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
        public static postAuthor($conn, $firstname, $lastname) {
            $query = 'INSERT INTO Authors (firstname, lastname) VALUES ('
            . '\'' . $firstname . '\', '
            . '\'' . $lastname . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return $statement;
        }
    }
?>