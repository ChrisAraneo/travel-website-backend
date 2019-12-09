<?
    /*
        CREATE TABLE MeetingPoints (
            id_meetingpoint int NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            address varchar(255),
            PRIMARY KEY (id_meetingpoint)
        );
    */
    class MeetingPoints {
        public static postMeetingPoint($conn, $name, $address) {
            $query = 'INSERT INTO MeetingPoints (name, address) VALUES ('
            . '\'' . $name . '\', '
            . '\'' . $address . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return $statement;
        }
    }
 ?>