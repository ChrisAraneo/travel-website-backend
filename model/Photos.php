<?
    /*
        CREATE TABLE Photos (
            id_photo int NOT NULL AUTO_INCREMENT,
            id_travel int NOT NULL,
            filename varchar(255),
            PRIMARY KEY (id_photo),
            FOREIGN KEY (id_travel) REFERENCES Travels(id_travel),
        );
    */
    class Photos {
        public static postPhoto($conn, $filename, $id_travel) {
            $query = 'INSERT INTO Authors (filename, id_travel) VALUES ('
            . '\'' . $filename . '\', '
            . $id_travel . ');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return $statement;
        }
    }
 ?>