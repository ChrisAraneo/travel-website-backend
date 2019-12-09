<?
    /*
        CREATE TABLE Travels (
            id_travel int NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            location varchar(255) NOT NULL,
            date date NOT NULL,
            hour time NOT NULL,
            id_meetingpoint int varchar(255) NOT NULL,
            latitude double(40,2),
            longitude double(40,2),
            description varchar(255),
            PRIMARY KEY (id_travel),
            FOREIGN KEY (id_meetingpoint) REFERENCES MeetingPoints(id_meetingpoint)
        );
    */

    class Travels {

        public static getTravels($conn) {
            $query = 'SELECT * FROM Travels;' 

            $statement = $conn->prepare($query);
            $statement->execute();

            if($statement->rowCount() > 0) {
                $array = array();
                $array['success'] = true;
                $array['message'] = '';

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
                        'lingitude' => $longitude,
                        'description' => $description
                    );
                    array_push($array['data'], $travel);
                }

                return json_encode($array);
            } else {
                return json_encode(
                    array(
                        'success' => true,
                        'message' => 'No travels found'
                    );
                );
            }
        }

        public static postTravel($conn, $title, $location, $date, $hour, $meetingpoint, $latitude, $longitude, $description) {
            $query = 'INSERT INTO Travels (title, location, date, hour, id_meetingpoint, latitude, longitude, description, photos) VALUES ('
            . '\'' . $title . '\', '
            . '\'' . $location . '\', '
            . '\'' . $date . '\', '
            . '\'' . $hour . '\', '
            . $meetingpoint . ', '
            . $latitude . ', '
            . $longitude . ', '
            . '\'' . $description . '\');';

            $statement = $conn->prepare($query);
            $statement->execute();

            return $statement;
        }
    }
?>