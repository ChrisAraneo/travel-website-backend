<?
    include_once(dirname(__FILE__).'/Authors.php');
    include_once(dirname(__FILE__).'/MeetingPoints.php');

    /*
        CREATE TABLE Travels (
            id_travel int NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            location varchar(255) NOT NULL,
            date date NOT NULL,
            hour time NOT NULL,
            id_meetingpoint int NOT NULL,
            latitude double(10,2),
            longitude double(10,2),
            description varchar(255),
            PRIMARY KEY (id_travel),
            FOREIGN KEY (id_meetingpoint) REFERENCES MeetingPoints(id_meetingpoint)
        );
    */

    class Travels {
        public static function getTravel($conn, $id_travel) {
            $query = 'SELECT * FROM Travels WHERE id_travel = ' . $id_travel . ';';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_travel' => $id_travel,
                        'title' => $title,
                        'location' => $location,
                        'date' => $date,
                        'hour' => $hour,
                        'id_meetingpoint' => $id_meetingpoint,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'description' => $description
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function getTravels($conn) {
            $query = 'SELECT * FROM Travels;';

            $statement = $conn->prepare($query);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_travel' => $id_travel,
                        'title' => $title,
                        'location' => $location,
                        'date' => $date,
                        'hour' => $hour,
                        'id_meetingpoint' => $id_meetingpoint,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'description' => $description
                    );
                    array_push($array, $item);
                }
            }
            
            return $array;
        }

        public static function postTravel($conn, $title, $location, $date, $hour, $id_meetingpoint, $latitude, $longitude, $description) {
            // CHECKING IF MEETINGPOINT EXIST
            if(sizeof(MeetingPoints::getMeetingPoint($conn, $id_meetingpoint)) < 1) {
                return array(
                    'success' => false,
                    'message' => "Meeting point ". $id_meetingpoint . " doesn't exist in database"
                );
            }

            // ADDING TRAVEL TO DATABASE
            $query = 'INSERT INTO Travels (title, location, date, hour, id_meetingpoint, latitude, longitude, description) VALUES ('
            . '\'' . $title . '\', '
            . '\'' . $location . '\', '
            . '\'' . $date . '\', '
            . '\'' . $hour . '\', '
            . $id_meetingpoint . ', '
            . $latitude . ', '
            . $longitude . ', '
            . '\'' . $description . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            // FINDING ID OF THIS TRAVEL
            $query2 = 'SELECT id_travel FROM Travels WHERE ';
            $query2 .= 'title = \'' . $title . '\' AND ';
            $query2 .= 'location = \'' . $location . '\' AND ';
            $query2 .= 'id_meetingpoint = ' . $id_meetingpoint . ' AND ';
            $query2 .= 'latitude = ' . $latitude. ' AND ';
            $query2 .= 'longitude = ' . $longitude. ';';

            $statement = $conn->prepare($query2);
            $statement->execute();

            $array = array();

            if($statement->rowCount() > 0) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        'id_travel' => $id_travel
                    );
                    array_push($array, $item);
                }
            }

            return array(
                'success' => true,
                'message' => 'Travel successfully added',
                'id_travel' => $id_travel
            );
        }
    }
?>