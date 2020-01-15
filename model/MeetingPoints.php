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
        public static function getMeetingPoint($conn, $id_meetingpoint) {
            $query = 'SELECT * FROM MeetingPoints WHERE id_meetingpoint = ' . $id_meetingpoint . ';';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_meetingpoint' => $id_meetingpoint,
                        'name' => $name,
                        'address' => $address
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function getMeetingPoints($conn) {
            $query = 'SELECT * FROM MeetingPoints;';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_meetingpoint' => $id_meetingpoint,
                        'name' => $name,
                        'address' => $address
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function postMeetingPoint($conn, $name, $address) {
            $query = 'INSERT INTO MeetingPoints (name, address) VALUES ('
            . '\'' . $name . '\', '
            . '\'' . $address . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return array(
                'success' => true,
                'message' => 'OK'
            );
        }
    }
 ?>